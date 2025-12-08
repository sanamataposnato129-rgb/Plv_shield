<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EventDuty;
use App\Models\Student;

class Participant extends Model
{
    use HasFactory;

    protected $connection = 'duty';
    protected $table = 'Participants';
    protected $primaryKey = 'participant_id';

    protected $fillable = [
        'event_id',
        'user_id',
        'plv_student_id',
        'email',
        'first_name',
        'last_name'
    ];

    public $timestamps = true;

    public function event()
    {
        return $this->belongsTo(EventDuty::class, 'event_id', 'event_id');
    }

    /**
     * Link to the Student record.
     * The participants table stores a plv_student_id which maps to
     * the Student.plv_student_id column in the central students table.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'plv_student_id', 'plv_student_id');
    }
}
