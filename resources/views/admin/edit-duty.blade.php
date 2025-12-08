@extends('layouts.admin')

@section('title', 'Edit Duty')

@section('content')
    <div class="duties-header">
        <h2 class="duties-title">Edit Duty #{{ $duty->event_id }}</h2>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startTimeInput = document.getElementById('start_time');
            const endTimeInput = document.getElementById('end_time');

            function updateMinEndTime() {
                const startTime = startTimeInput.value;
                if (startTime) {
                    endTimeInput.min = startTime;
                    if (endTimeInput.value && endTimeInput.value < startTime) {
                        endTimeInput.value = startTime;
                    }
                }
            }

            function updateMaxStartTime() {
                const endTime = endTimeInput.value;
                if (endTime) {
                    startTimeInput.max = endTime;
                    if (startTimeInput.value && startTimeInput.value > endTime) {
                        startTimeInput.value = endTime;
                    }
                }
            }

            startTimeInput.addEventListener('change', updateMinEndTime);
            endTimeInput.addEventListener('change', updateMaxStartTime);

            // Initial validation
            updateMinEndTime();
            updateMaxStartTime();
        });
    </script>
    @endpush

    <div class="duties-form">
    <form method="POST" action="{{ route('admin.duties.update', $duty->event_id) }}">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="title">Title</label>
                <input id="title" name="title" value="{{ $duty->title }}" placeholder="Title" class="form-group input" required>
            </div>

            <div class="form-group">
                <label for="duty_date">Date</label>
                <input id="duty_date" name="duty_date" value="{{ $duty->duty_date->format('Y-m-d') }}" type="date" class="form-group input" required>
            </div>

            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input id="start_time" name="start_time" value="{{ $duty->start_time }}" type="time" class="form-group input" required>
            </div>

            <div class="form-group">
                <label for="end_time">End Time</label>
                <input id="end_time" name="end_time" value="{{ $duty->end_time }}" type="time" class="form-group input" required>
            </div>

            <div class="form-group">
                <label for="number_of_participants"># Participants</label>
                <input id="number_of_participants" name="number_of_participants" type="number" min="0" value="{{ $duty->number_of_participants }}" class="form-group input" placeholder="Number of participants">
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-group input">
                    @foreach(['OPEN','IN_PROGRESS','CERTIFIED','COMPLETED','CANCELLED'] as $s)
                        <option value="{{ $s }}" {{ $duty->status === $s ? 'selected' : '' }}>{{ str_replace('_',' ', $s) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group" style="margin-top:12px;">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-group input" required rows="4">{{ $duty->description }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">Update Duty</button>
            <a href="{{ route('admin.create-duties') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
    </div>

@endsection
