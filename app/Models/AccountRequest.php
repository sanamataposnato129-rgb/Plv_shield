<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountRequest extends Model
{
    use HasFactory;

    protected $table = 'Account_Request';
    protected $primaryKey = 'request_id';
    public $timestamps = false;

    protected $fillable = [
        'plv_student_id',
        'email',
        'first_name',
        'last_name',
        'password_hash',
        'request_status',
        'reviewed_by',
        'reviewed_at'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];
}