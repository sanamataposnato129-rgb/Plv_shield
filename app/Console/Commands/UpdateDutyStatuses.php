<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\EventDuty;
use Carbon\Carbon;

class UpdateDutyStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'duty:update-statuses {--dry-run : Preview changes without updating}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically set IN_PROGRESS duties to UNDER_REVIEW when their end time has passed';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        try {
            $now = Carbon::now();

            // Find duties that have ended but are still IN_PROGRESS
            $query = EventDuty::where('status', 'IN_PROGRESS')
                ->whereRaw("CONCAT(duty_date, ' ', end_time) <= ?", [$now->format('Y-m-d H:i:s')]);

            $count = $query->count();

            if ($this->option('dry-run')) {
                $this->info("Dry run: Would update {$count} duties from IN_PROGRESS to UNDER_REVIEW");
                return 0;
            }

            if ($count === 0) {
                $this->info("No duties need updating.");
                return 0;
            }

            // Update the duties
            $updated = $query->update([
                'status' => 'UNDER_REVIEW',
                'completed_at' => $now
            ]);

            $this->info("Updated {$updated} duties from IN_PROGRESS to UNDER_REVIEW");
            Log::info("duty:update-statuses updated {$updated} duties to UNDER_REVIEW");

            return 0;
        } catch (\Exception $e) {
            Log::error("duty:update-statuses error: " . $e->getMessage());
            $this->error($e->getMessage());
            return 1;
        }
    }
}