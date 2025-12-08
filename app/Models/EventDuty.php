<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Participant;

class EventDuty extends Model
{
    use HasFactory;

    // This model previously used a separate 'duty' connection. It now uses the
    // application's default database connection (accounts/mysql) so duty
    // tables are expected to exist in the primary database.

    // Table name as created in MySQL Workbench
    protected $table = 'Event_Duty';

    protected $primaryKey = 'event_id';

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'title',
        'description',
        'duty_date',
        'start_time',
        'end_time',
        'number_of_participants',
        'status',
        'completed_at',
        'team_leader_name'
    ];

    protected $casts = [
        'duty_date' => 'date',
        'start_time' => 'string',
        'end_time' => 'string',
        'number_of_participants' => 'integer',
        'completed_at' => 'datetime',
        'created_at' => 'datetime'
    ];

    /**
     * Participants registered for this duty (from duty DB connection).
     */
    public function participants()
    {
        return $this->hasMany(Participant::class, 'event_id', 'event_id');
    }

    public function getFormattedStartTimeAttribute()
    {
        return date('g:ia', strtotime($this->start_time));
    }

    public function getFormattedEndTimeAttribute()
    {
        return date('g:ia', strtotime($this->end_time));
    }
}
