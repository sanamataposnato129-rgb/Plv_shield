@extends('layouts.admin')

@section('title', 'Participant Report')

@section('styles')
<style>
    :root {
        --navy: #1a1a4d;
        --navy-dark: #191970;
        --navy-gradient: linear-gradient(135deg, #1a1a4d 0%, #2a2a5d 100%);
        --gold: #FFD700;
        --gold-light: #ffea00;
        --bg-light: #f5f7fa;
        --text-dark: #1a1a4d;
        --text-muted: #6b7280;
        --success: #10b981;
        --border: #e5e7eb;
    }

    .report-wrap {
        margin-left: 240px;
        margin-top: 90px;
        padding: 2rem;
        background: var(--bg-light);
        min-height: calc(100vh - 90px);
    }

    /* Back Button - Same as your first design */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: white;
        color: var(--navy);
        border: 2px solid var(--border);
        border-radius: 0.5rem;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.25s ease;
        margin-bottom: 1.5rem;
    }
    .btn-back:hover {
        background: var(--navy);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(26,26,77,0.25);
    }

    /* Main Card */
    .detail-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .report-header {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .report-header .d-flex {
        flex-direction: column;
        gap: 1rem;
    }

    .report-header .d-flex h2 {
        margin: 0;
    }

    .report-header .d-flex > a {
        align-self: flex-start;
    }

    .report-subtitle {
        font-size: 1.3rem;
        font-weight: 600;
        color: #fff;
        opacity: 0.95;
    }

    .report-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
    }

    .report-meta-item i {
        color: var(--gold);
    }

    .meta-info {
        margin-top: 1rem;
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        font-size: 0.95rem;
    }
    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .meta-item i { color: var(--gold); }

    .card-body {
        padding: 2rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-item {
        background: linear-gradient(135deg, #fffbeb, #fef3c7);
        padding: 1.5rem;
        border-radius: 0.75rem;
        border-left: 6px solid var(--gold);
        box-shadow: 0 6px 16px rgba(255,215,0,0.15);
        transition: all 0.3s ease;
    }
    .info-item:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(255,215,0,0.25);
    }
    .info-item .label {
        font-size: 0.75rem;
        color: #92400e;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .info-item .value {
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-top: 0.5rem;
    }

    .report-content {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-left: 6px solid var(--navy);
        padding: 2rem;
        border-radius: 0.75rem;
        line-height: 1.8;
        font-size: 1.1rem;
        color: #374151;
        margin: 2rem 0;
    }

    .report-content h6 {
        color: var(--navy);
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    /* Overlay and Gallery */
    .img-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.9);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 2000;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .img-overlay.open {
        display: flex;
        opacity: 1;
    }

    .img-modal {
        position: relative;
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        max-width: 85vw;
        max-height: 80vh;
        overflow: auto;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }

    /* Desktop-only attachment thumbnail limits (web view) */
    @media (min-width: 992px) {
      .attachment-list {
        padding-left: 0;
        list-style: none;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin: 0 0 1rem 0;
      }

      .attachment-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        max-width: 520px;
        width: 100%;
      }

      .attachment-thumb {
        display: block;
        width: 100%;
        max-width: 520px;
        max-height: 360px;
        object-fit: cover;
        border-radius: 6px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
      }
    }

    @media (max-width: 768px) {
        .img-modal {
            padding: 1rem;
            border-radius: 0.75rem;
        }
    }

    /* Improve modal layout on mobile: take more vertical space, reduce top offset */
    @media (max-width: 480px) {
      .img-overlay.open { align-items: flex-start; padding-top: 8vh; }
      .img-modal { max-width: 95vw; width: 95vw; max-height: 90vh; padding: 0.75rem; border-radius: 0.6rem; }
      #imgOverlayImg { max-width: 100%; max-height: 65vh; }
      .img-modal .btn { padding: 0.5rem 0.75rem; }
    }

    /* No Report State */
    .no-report {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-muted);
    }
    .no-report i {
        font-size: 4rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }

    .action-buttons {
        text-align: center;
        padding: 2rem;
        border-top: 3px solid var(--border);
        background: white;
    }

    .btn-release-cert {
        padding: 1rem 3rem;
        background: linear-gradient(135deg, var(--success), #059669);
        color: white;
        border: none;
        border-radius: 0.75rem;
        font-weight: 700;
        font-size: 1.1rem;
        text-transform: uppercase;
        box-shadow: 0 8px 25px rgba(16,185,129,0.35);
        transition: all 0.3s ease;
    }
    .btn-release-cert:hover {
        transform: translateY(-4px);
        background: linear-gradient(135deg, #059669, #047857);
        box-shadow: 0 15px 35px rgba(16,185,129,0.5);
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .report-wrap {
            margin-left: 0;
            margin-top: 70px;
            padding: 1rem 0.75rem;
        }

        .info-grid, .photos-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .meta-info {
            flex-direction: column;
            gap: 0.75rem;
            font-size: 0.9rem;
        }

        .detail-card, .report-card {
            border-radius: 0.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 1rem;
        }

        .card-header {
            padding: 1.25rem 1rem;
        }

        .card-header h4 {
            font-size: 1.4rem;
        }

        .card-body {
            padding: 1rem;
        }

        .participant-name {
            font-size: 0.95rem;
            margin-top: 0.75rem;
        }

        .report-content {
            padding: 1rem;
            font-size: 0.95rem;
            line-height: 1.6;
            margin: 1.5rem 0;
        }

        .report-content h6 {
            font-size: 1rem;
        }

        .action-buttons {
            padding: 1rem;
            border-top: 2px solid var(--border);
        }

        .btn-back, .btn-release-cert, .btn-outline-secondary {
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            width: 100%;
            margin-bottom: 0.5rem;
        }

        .btn-back {
            margin-bottom: 1rem;
        }

        .btn-release-cert {
            margin-bottom: 0;
        }

        .photo-item {
            border-radius: 8px;
        }

        .photo-item img {
            height: 160px;
        }

        .attachment-list {
            padding-left: 0;
            list-style: none;
        }

        .attachment-item {
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
            display: flex;
            flex-direction: column;
        }

        .attachment-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            word-break: break-word;
        }

        .thumb {
            margin-bottom: 0.5rem;
        }

        .thumb img {
            max-height: 100px;
            border-radius: 4px;
        }

        .img-modal {
            max-width: 95vw;
            width: 95vw;
            max-height: 85vh;
        }

        #imgOverlayImg {
            max-width: 90vw;
            max-height: 60vh;
            width: 100%;
        }

        .img-caption {
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .no-report {
            padding: 2rem 1rem;
        }

        .no-report i {
            font-size: 3rem;
        }

        .report-meta {
            gap: 0.5rem !important;
        }

        .report-meta-item {
            font-size: 0.85rem;
        }

        /* Button Navigation */
        #imgPrev, #imgNext {
            padding: 0.5rem !important;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .info-item {
            padding: 1rem;
        }

        .info-item .label {
            font-size: 0.7rem;
        }

        .info-item .value {
            font-size: 1.1rem;
        }
    }

    /* Extra small devices (less than 480px) */
    @media (max-width: 480px) {
        .report-wrap {
            padding: 0.75rem 0.5rem;
        }

        .card-header {
            padding: 1rem 0.75rem;
        }

        .card-header h4 {
            font-size: 1.2rem;
        }

        .card-body {
            padding: 0.75rem;
        }

        .btn-back, .btn-release-cert, .btn-outline-secondary {
            padding: 0.65rem 0.75rem;
            font-size: 0.9rem;
        }

        .report-content {
            padding: 0.75rem;
            font-size: 0.9rem;
        }

        .photo-item img {
            height: 140px;
        }

        .info-item {
            padding: 0.85rem;
        }

        .info-item .label {
            font-size: 0.65rem;
        }

        .info-item .value {
            font-size: 1rem;
        }

        .meta-info {
            font-size: 0.8rem;
        }

        .report-meta-item {
            font-size: 0.8rem;
        }

        #imgOverlayImg {
            max-height: 50vh;
        }

        .img-caption {
            font-size: 0.8rem;
        }
    }
</style>
@endsection

@section('content')
@php
  use Illuminate\Support\Facades\Storage;
@endphp

<div class="mb-3">
  <a href="javascript:history.back()" class="btn-back">
    <i class="fas fa-arrow-left me-1"></i> Back
  </a>
</div>

@if($report)
  <div class="report-card">
    <div class="card-header">
      <div class="report-header">
        <div class="d-flex justify-content-between align-items-start flex-column flex-md-row">
          <h2 style="margin: 0; word-break: break-word; flex: 1;">{{ $report->summary }}</h2>
          <a href="{{ route('admin.reports.show', ['id' => $dutyId]) }}" class="btn btn-outline-secondary mt-2 mt-md-0 ms-md-2" style="white-space: nowrap; flex-shrink: 0;">
            <i class="fas fa-arrow-left me-1"></i>Back to Duty
          </a>
        </div>
        <div class="report-subtitle">{{ $participant->name ?? trim(($participant->first_name ?? '') . ' ' . ($participant->last_name ?? '')) }}</div>
        <div class="report-meta mt-3 d-flex flex-wrap align-items-start" style="gap:1rem;">
          <div class="report-meta-item">
            <i class="fas fa-id-badge"></i>
            <span>{{ $participant->plv_student_id ?? ($participant->participant_id ?? '—') }}</span>
          </div>
          <div class="report-meta-item">
            <i class="fas fa-envelope"></i>
            <span>{{ $participant->email ?? '—' }}</span>
          </div>
          <div class="report-meta-item">
            <i class="fas fa-calendar"></i>
            <span>Submitted {{ $report->submitted_at->format('M d, Y \a\t h:i A') }}</span>
          </div>
          @if($report->reviewed_at)
            <div class="report-meta-item">
              <i class="fas fa-check-circle text-success"></i>
              <span>Reviewed {{ $report->reviewed_at->format('M d, Y') }}</span>
            </div>
          @endif
        </div>
      </div>
    </div>

    <div class="card-body">
      <div class="report-section">
        <h3>Report Details</h3>
        <div class="report-content">
          {{ $report->details }}
        </div>
      </div>
      @if($report->attachments && count($report->attachments) > 0)
        <div class="report-section">
          <h3>Attachments</h3>
          <ul class="attachment-list">
            @php
              $imgIndex = 0;
            @endphp
            @foreach($report->attachments as $att)
              @php
                $path = ltrim($att, '/');
                try {
                  $url = Storage::url($path);
                } catch (\Exception $e) {
                  $url = asset('storage/' . $path);
                }
                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp','bmp']);
              @endphp
              <li class="attachment-item" @if($isImage) data-img-index="{{ $imgIndex }}" @endif>
                @if($isImage)
                  <div class="thumb">
                    <a href="{{ $url }}" class="img-preview-link" data-src="{{ $url }}" data-filename="{{ basename($path) }}" data-index="{{ $imgIndex }}">
                      <img src="{{ $url }}" alt="{{ basename($path) }}" class="attachment-thumb" />
                    </a>
                  </div>
                  <div class="attachment-info">
                    <a href="{{ $url }}" class="img-preview-link" data-src="{{ $url }}" data-filename="{{ basename($path) }}" data-index="{{ $imgIndex }}">{{ basename($path) }}</a>
                  </div>
                  @php $imgIndex++; @endphp
                @else
                  <div class="attachment-info">
                    <i class="fas fa-paperclip"></i>
                    <a href="{{ $url }}" target="_blank">{{ basename($path) }}</a>
                  </div>
                @endif
              </li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>
  </div>
@else
  <div class="report-card">
    <div class="card-body">
      <div class="no-report-message">
        <i class="fas fa-file-alt d-block"></i>
        <h3>No Report Submitted</h3>
        <p class="text-muted">This participant has not submitted a report yet.</p>
        <a href="{{ route('admin.reports.show', ['id' => $dutyId]) }}" class="btn btn-outline-secondary mt-3">
          <i class="fas fa-arrow-left me-1"></i>Back to Duty
        </a>
      </div>
    </div>
  </div>
@endif

<!-- Image preview overlay / gallery -->
<div id="imgOverlay" class="img-overlay" aria-hidden="true">
  <div class="img-modal" role="document">
    <button id="imgPrev" class="btn btn-light" style="position:absolute; left:8px; top:50%; transform:translateY(-50%); z-index:5;">
      <i class="fas fa-chevron-left"></i>
    </button>
    <div style="max-width:100%; text-align:center; width:100%;">
      <img id="imgOverlayImg" src="" alt="Preview" />
      <div id="imgCaption" class="img-caption"></div>
      <div style="margin-top:8px; display:flex; justify-content:center; gap:8px;">
        <button id="imgCloseBtn" class="btn btn-sm btn-secondary">Close</button>
        <a id="imgDownload" class="btn btn-sm btn-outline-primary" href="#" download>Download</a>
        <div id="imgIndex" style="align-self:center; color:#6b7280; font-size:0.95rem;"></div>
      </div>
    </div>
    <button id="imgNext" class="btn btn-light" style="position:absolute; right:8px; top:50%; transform:translateY(-50%); z-index:5;">
      <i class="fas fa-chevron-right"></i>
    </button>
  </div>
</div>

<script>
  (function(){
    var links = Array.from(document.querySelectorAll('.img-preview-link'));
    // build unique gallery in order of appearance
    var gallery = [];
    var captions = [];
    links.forEach(function(l){
      var src = l.getAttribute('data-src') || l.href;
      var filename = l.getAttribute('data-filename') || '';
      if(gallery.indexOf(src) === -1){
        gallery.push(src);
        captions.push(filename);
      }
    });

    var overlay = document.getElementById('imgOverlay');
    var imgEl = document.getElementById('imgOverlayImg');
    var capEl = document.getElementById('imgCaption');
    var idxEl = document.getElementById('imgIndex');
    var downloadEl = document.getElementById('imgDownload');
    var currentIndex = 0;

    function showIndex(i){
      if(!gallery.length) return;
      currentIndex = (i + gallery.length) % gallery.length;
      imgEl.src = gallery[currentIndex];
      capEl.textContent = captions[currentIndex] || '';
      downloadEl.href = gallery[currentIndex];
      idxEl.textContent = (currentIndex + 1) + ' / ' + gallery.length;
      overlay.classList.add('open');
      document.body.style.overflow = 'hidden';
    }
    function closeOverlay(){
      overlay.classList.remove('open');
      document.body.style.overflow = '';
      imgEl.src = '';
    }

    document.addEventListener('click', function(e){
      var link = e.target.closest && e.target.closest('.img-preview-link');
      if(!link) return;
      e.preventDefault();
      var src = link.getAttribute('data-src') || link.href;
      var index = gallery.indexOf(src);
      if(index === -1) index = 0;
      showIndex(index);
    });

    var closeBtn = document.getElementById('imgCloseBtn');
    if(closeBtn) closeBtn.addEventListener('click', closeOverlay);

    var prevBtn = document.getElementById('imgPrev');
    var nextBtn = document.getElementById('imgNext');
    if(prevBtn) prevBtn.addEventListener('click', function(e){ e.stopPropagation(); showIndex(currentIndex - 1); });
    if(nextBtn) nextBtn.addEventListener('click', function(e){ e.stopPropagation(); showIndex(currentIndex + 1); });

    overlay.addEventListener('click', function(e){ if(e.target === overlay) closeOverlay(); });

    document.addEventListener('keydown', function(e){
      if(!overlay.classList.contains('open')) return;
      if(e.key === 'Escape') closeOverlay();
      if(e.key === 'ArrowLeft') showIndex(currentIndex - 1);
      if(e.key === 'ArrowRight') showIndex(currentIndex + 1);
    });
  })();
</script>
@endsection
