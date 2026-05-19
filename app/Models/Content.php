<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
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
        'category_id',
        'status',
        'published_at',
        'scheduled_at',
        'external_url',
        'media_id',
        'readability_score',
        'focus_keyword',
        'keyword_density',
        'seo_meta'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post', 'post_id', 'category_id');
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'content_tag');
    }

    /**
     * Get the linked media for this content
     */
    public function linkedMedia()
    {
        return $this->belongsTo(Content::class, 'media_id');
    }

    /**
     * Get all media items that can be linked (excluding this item)
     */
    public function getAvailableMediaAttribute()
    {
        return Content::where('user_id', $this->user_id)
            ->whereNotNull('file_path')
            ->where('content_type', '!=', 'video')
            ->where('id', '!=', $this->id)
            ->latest()
            ->get();
    }

    /**
     * Get the revisions for this content.
     */
    public function revisions()
    {
        return $this->hasMany(PostRevision::class, 'post_id')->latest();
    }

    /**
     * Helper to check if content is media (image, video, audio)
     */
    public function isMedia(): bool
    {
        return in_array($this->content_type, ['image', 'video', 'audio']);
    }
}
