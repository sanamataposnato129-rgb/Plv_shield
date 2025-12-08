<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'Admin';
    protected $primaryKey = 'admin_id';
    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'password_hash',
        'email',
        'admin_type',
        'last_login'
    ];

    protected $hidden = [
        'password_hash'
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    protected function getCreatedAtAttribute()
    {
        return $this->attributes['created_at'] ?? null;
    }

    protected function getUpdatedAtAttribute()
    {
        return $this->attributes['updated_at'] ?? null;
    }
}