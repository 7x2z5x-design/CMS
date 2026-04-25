<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    
    protected $table = 'media';

    protected $fillable = [
        'file_path', 
        'file_type', 
        'size', 
        'media_type',
        'title',
        'description',
        'url',
        'thumbnail',
        'alt_text',
        'original_name',
        'mime_type',
        'extension',
        'uploaded_by',
        'folder',
        'metadata'
    ];
}
