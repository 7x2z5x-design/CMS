<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostRevision extends Model
{
    protected $fillable = [
        'post_id',
        'title',
        'content',
        'user_id'
    ];

    /**
     * Get the post that owns this revision.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Content::class, 'post_id');
    }

    /**
     * Get the user who created this revision.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the formatted creation date.
     */
    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at->format('M d, Y \a\t g:i A');
    }
}
