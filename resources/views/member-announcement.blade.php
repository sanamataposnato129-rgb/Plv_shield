@extends('layouts.app')

@section('title', 'Available Duties')

@section('styles')
<style>
    .announcement-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }
    .duty-card {
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
        transition: transform 0.2s ease;
        border: 1px solid #e0e0e0;
    }
    .duty-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .duty-header {
        padding: 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .duty-title {
        font-size: 1.25rem;
        color: #1a1a4d;
        font-weight: 600;
        margin: 0;
    }
    .duty-status {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
    }
    .status-OPEN {
        background: #e3f2fd;
        color: #1565c0;
    }
    .status-IN_PROGRESS {
        background: #fff3e0;
        color: #ef6c00;
    }
    .duty-content {
        padding: 1.5rem;
    }
    .duty-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .info-label {
        color: #666;
        font-size: 0.875rem;
    }
    .info-value {
        color: #333;
        font-weight: 500;
    }
    .duty-description {
        color: #444;
        line-height: 1.6;
        margin: 1rem 0;
    }
    .duty-footer {
        padding: 1rem 1.5rem;
        background: #f8f9fa;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }
    .apply-button {
        background: #1a1a4d;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        transition: background-color 0.2s ease;
    }
    .apply-button:hover {
        background: #2d2d7a;
    }
    .duty-meta {
        color: #666;
        font-size: 0.875rem;
    }
    .filters {
        margin-bottom: 2rem;
        display: flex;
        gap: 1rem;
        align-items: center;
        padding: 1rem;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .filter-input {
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 0.875rem;
    }
    .filter-select {
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        background: white;
    }
    /* Mobile-specific override for floating/dialog windows used by announcement details */
    @media (max-width: 768px) {
        .floating-dialog {
            position: fixed !important;
            top: 6% !important;
            left: 12px !important;
            right: 12px !important;
            transform: none !important;
            width: auto !important;
            max-width: none !important;
            max-height: 88vh !important;
            overflow-y: auto !important;
            border-radius: 12px !important;
            box-shadow: 0 18px 40px rgba(0,0,0,0.25) !important;
            -webkit-overflow-scrolling: touch;
        }
        .floating-body { padding: 0.9rem !important; }
        .floating-header { padding: 0.75rem 1rem !important; }
        .floating-close { font-size: 1.2rem !important; }
    }
</style>
@endsection

@section('content')
<div class="announcement-container">
    <h1 class="text-2xl font-bold mb-6">Available Duties</h1>

    <div class="filters">
        <input type="text" class="filter-input" placeholder="Search duties...">
        <select class="filter-select">
            <option value="">All Statuses</option>
            <option value="OPEN">Open</option>
            <option value="IN_PROGRESS">In Progress</option>
        </select>
        <input type="date" class="filter-input">
    </div>

    @foreach($duties as $duty)
    <div class="duty-card">
        <div class="duty-header">
            <h2 class="duty-title">{{ $duty->title }}</h2>
            <span class="duty-status status-{{ $duty->status }}">{{ str_replace('_', ' ', $duty->status) }}</span>
        </div>
        <div class="duty-content">
            <div class="duty-info">
                <div class="info-item">
                    <span class="info-label">Date:</span>
                    <span class="info-value">{{ $duty->duty_date->format('M d, Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Time:</span>
                    <span class="info-value">{{ $duty->start_time }} - {{ $duty->end_time }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Participants:</span>
                    <span class="info-value">{{ $duty->number_of_participants }}</span>
                </div>
            </div>
            <p class="duty-description">{{ $duty->description }}</p>
        </div>
        <div class="duty-footer">
            <div class="duty-meta">
                Posted {{ $duty->created_at->diffForHumans() }}
            </div>
            @if($duty->status === 'OPEN')
            <a href="{{ route('duties.apply', $duty->event_id) }}" class="apply-button">Apply for Duty</a>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection