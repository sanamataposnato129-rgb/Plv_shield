<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DutyReport extends Model
{
    use HasFactory;

    protected $connection = 'duty';
    protected $table = 'Duty_Reports';
    protected $primaryKey = 'id';

    protected $fillable = [
        'participant_id',
        'event_id',
        'user_id',
        'plv_student_id',
        'summary',
        'details',
        'attachments',
        'status',
        'submitted_at',
        'reviewed_at'
    ];

    protected $casts = [
        'attachments' => 'array',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime'
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id', 'participant_id');
    }

    public function event()
    {
        return $this->belongsTo(EventDuty::class, 'event_id', 'event_id');
    }
}
