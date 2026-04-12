<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    protected $table = 'Users';
    protected $primaryKey = 'UserId';
    protected $keyType = 'int';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'Username',
        'Email',
        'PasswordHash',
        'FullName',
        'Bio',
        'ProfilePicture',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * NOTE: PasswordHash is intentionally NOT hidden so Laravel's
     * session-based auth can read and compare hashes correctly.
     */
    protected $hidden = [];


    public function getAuthPassword()
    {
        return $this->PasswordHash;
    }

    /**
     * The PK column used to store/retrieve the user from the session.
     * Must return the primary key name, not the email column.
     */
    public function getAuthIdentifierName()
    {
        return $this->primaryKey; // 'UserId'
    }
}