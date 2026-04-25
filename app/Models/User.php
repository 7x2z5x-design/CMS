<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = true;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's initials for avatar display.
     */
    public function getInitialsAttribute()
    {
        $name = explode(' ', $this->name);
        if (count($name) >= 2) {
            return strtoupper(substr($name[0], 0, 1) . substr($name[1], 0, 1));
        }
        return strtoupper(substr($this->name, 0, 2));
    }

    /**
     * Check if user is active.
     */
    public function isActive()
    {
        return $this->status === 'Active';
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin()
    {
        return $this->role === 'Admin';
    }

    /**
     * Check if user is editor.
     */
    public function isEditor()
    {
        return $this->role === 'Editor';
    }

    /**
     * Check if user is author.
     */
    public function isAuthor()
    {
        return $this->role === 'Author';
    }

    /**
     * Check if user is publisher.
     */
    public function isPublisher()
    {
        return $this->role === 'Publisher';
    }

    /**
     * Check if user is viewer.
     */
    public function isViewer()
    {
        return $this->role === 'Viewer';
    }
}