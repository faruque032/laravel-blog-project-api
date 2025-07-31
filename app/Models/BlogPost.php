<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogPost extends Model
{
    use HasFactory;

    protected $table = 'blog_posts';

    protected $fillable = [
        'title',
        'content',
        'author',
        'published_at',
        'status'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%')
                  ->orWhere('author', 'like', '%' . $search . '%');
            });
        }
        return $query;
    }
}
