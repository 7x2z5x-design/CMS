<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contents';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'file_path',
        'content_type',
        'user_id',
        'status'
    ];

    /**
     * Scope to query only posts (not other content types)
     */
    public function scopePosts($query)
    {
        return $query->where('content_type', 'post');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_content');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'content_tag');
    }

    /**
     * Helper to check if content is media (image, video, audio)
     */
    public function isMedia(): bool
    {
        return in_array($this->content_type, ['image', 'video', 'audio']);
    }
}
