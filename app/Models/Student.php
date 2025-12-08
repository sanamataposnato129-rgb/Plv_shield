<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory;
    // Ensure Student queries use the application (default) database connection
    // so eager-loading from models using the 'duty' connection doesn't
    // attempt to query the Student table on the duty database.
    protected $connection = 'mysql';

    protected $table = 'Student';
    protected $primaryKey = 'user_id';
    public $timestamps = true;

    protected $fillable = [
        'plv_student_id',
        'email',
        'first_name',
        'last_name',
        'password_hash',
        'last_login',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'password_hash'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'last_login'
    ];

    /**
     * Convenient accessor to get full name as "first last".
     * Allows views to use $student->name.
     */
    public function getNameAttribute()
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }

    /**
     * Provide a plv_id attribute used by views ($student->plv_id).
     */
    public function getPlvIdAttribute()
    {
        return $this->plv_student_id;
    }

    // Tell Laravel to use 'password_hash' instead of 'password'
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}