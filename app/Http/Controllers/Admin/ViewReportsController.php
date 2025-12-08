<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventDuty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\DutyCertificate;
use PDF;
use Illuminate\Support\Facades\Storage;

class ViewReportsController extends Controller
{
    public function index(Request $request)
    {
        // Only show duties that have been certified
        $query = EventDuty::query()
            ->where('status', 'CERTIFIED')
            ->orderBy('created_at', 'desc');

        // Handle search
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Handle team leader filter
        if ($request->filled('tlFilter')) {
            $tlFilter = $request->input('tlFilter');
            if ($tlFilter === 'with-tl') {
                $query->whereNotNull('team_leader_name');
            } elseif ($tlFilter === 'no-tl') {
                $query->whereNull('team_leader_name');
            }
        }

        $reports = $query->paginate(10);

        return view('admin.view-reports', [
            'reports' => $reports,
            'search' => $request->input('search'),
            'tlFilter' => $request->input('tlFilter', 'all')
        ]);
    }

    public function approve($dutyId)
    {
        try {
            $duty = EventDuty::findOrFail($dutyId);
            $duty->status = 'COMPLETED';
            $duty->save();

            return response()->json([
                'success' => true,
                'message' => 'Report has been approved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve report.'
            ], 500);
        }
    }

    public function reject($dutyId)
    {
        try {
            $duty = EventDuty::findOrFail($dutyId);
            $duty->status = 'REJECTED';
            $duty->save();

            return response()->json([
                'success' => true,
                'message' => 'Report has been rejected successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject report.'
            ], 500);
        }
    }

    /**
     * Show details for a single duty and its participants.
     */
    public function show($dutyId)
    {
        $duty = EventDuty::with('participants')->where('event_id', $dutyId)->firstOrFail();

        return view('admin.report-details', [
            'duty' => $duty
        ]);
    }

    /**
     * History listing for completed duties
     */
    public function history(Request $request)
    {
        $query = EventDuty::query()
            ->where('status', 'COMPLETED')
            ->orderBy('duty_date', 'desc');

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('tlFilter')) {
            $tlFilter = $request->input('tlFilter');
            if ($tlFilter === 'with-tl') {
                $query->whereNotNull('team_leader_name');
            } elseif ($tlFilter === 'no-tl') {
                $query->whereNull('team_leader_name');
            }
        }

        $reports = $query->paginate(10);

        return view('admin.history', [
            'reports' => $reports,
            'search' => $request->input('search'),
            'tlFilter' => $request->input('tlFilter', 'all')
        ]);
    }

    /**
     * Show details for a single completed duty (history-specific view)
     */
    public function historyShow($dutyId)
    {
        $duty = EventDuty::with('participants')->where('event_id', $dutyId)->firstOrFail();

        return view('admin.history-report-details', [
            'duty' => $duty
        ]);
    }

    /**
     * Mark a duty as completed (status = COMPLETED).
     */
    public function markComplete(Request $request, $dutyId)
    {
        try {
            $duty = EventDuty::findOrFail($dutyId);
            $duty->status = 'COMPLETED';
            $duty->completed_at = now();
            $duty->save();

            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Duty marked as completed']);
            }

            return redirect()->route('admin.view-reports')->with('success', 'Duty marked as completed');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to mark duty completed'], 500);
            }
            return redirect()->back()->with('error', 'Failed to mark duty completed');
        }
    }

    /**
     * Show a participant's report for this duty (if any).
     */
    public function participantReport($dutyId, $participantId)
    {
        $report = \App\Models\DutyReport::where('event_id', $dutyId)
            ->where('participant_id', $participantId)
            ->first();

        $participant = \App\Models\Participant::where('participant_id', $participantId)->first();

        return view('admin.participant-report', [
            'report' => $report,
            'participant' => $participant,
            'dutyId' => $dutyId
        ]);
    }

    public function releaseCertificate($dutyId, $participantId)
    {
        try {
            // Get duty and participant
            $duty = EventDuty::findOrFail($dutyId);
            $participant = \App\Models\Participant::findOrFail($participantId);

            // Generate PDF from Blade view
            $pdf = PDF::loadView('pdfs.duty_certificate', [
                'participant' => $participant,
                'duty' => $duty
            ]);

            // Save PDF to temporary location
            $tempPath = storage_path('app/temp/');
            if (!file_exists($tempPath)) {
                mkdir($tempPath, 0755, true);
            }

            $fileName = 'certificate_' . $participant->participant_id . '_' . time() . '.pdf';
            $filePath = $tempPath . $fileName;
            $pdf->save($filePath);

            // Copy PDF to public storage so we can provide a download link
            $publicPath = storage_path('app/public/certificates/');
            if (!file_exists($publicPath)) {
                mkdir($publicPath, 0755, true);
            }
            $publicFilePath = $publicPath . $fileName;
            copy($filePath, $publicFilePath);
            $publicUrl = asset('storage/certificates/' . $fileName);

            // Send email with PDF attachment and a download link
            Mail::to($participant->email)
                ->send(new DutyCertificate($participant, $duty, $filePath, $publicUrl));

            Log::info('Certificate released successfully', [
                'participant_id' => $participantId,
                'duty_id' => $dutyId,
                'email' => $participant->email,
                'pdf_file' => $fileName,
                'public_url' => $publicUrl
            ]);

            // Clean up temporary PDF file after a delay (mail is queued)
            // For now, we'll keep the files for debugging; consider unlinking when stable
            // unlink($filePath);

            return redirect()->back()->with('success', 'Certificate email sent successfully to ' . $participant->email);
        } catch (\Exception $e) {
            Log::error('Failed to release certificate', [
                'error' => $e->getMessage(),
                'participant_id' => $participantId,
                'duty_id' => $dutyId,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->withErrors('Failed to send certificate: ' . $e->getMessage());
        }
    }

    /**
     * Serve certificate file download from storage/public/certificates via Laravel.
     */
    public function downloadCertificate($dutyId, $participantId)
    {
        try {
            // Look for a certificate file matching this participant (generated by releaseCertificate)
            $files = Storage::disk('public')->files('certificates');
            foreach ($files as $f) {
                if (preg_match('/certificate_' . preg_quote($participantId, '/') . '_/', $f)) {
                    // Return a streamed download with proper headers
                    return Storage::disk('public')->download($f);
                }
            }

            // Not found
            return redirect()->back()->withErrors('Certificate file not found.');
        } catch (\Exception $e) {
            Log::error('Failed to download certificate', ['error' => $e->getMessage(), 'participant' => $participantId]);
            return redirect()->back()->withErrors('Unable to download certificate.');
        }
    }
}