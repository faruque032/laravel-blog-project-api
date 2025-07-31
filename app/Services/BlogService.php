<?php

namespace App\Services;

use App\Models\BlogPost;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BlogService
{
    /**
     * Get paginated blog posts for frontend
     */
    public function getPublishedPosts(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return BlogPost::published()
            ->search($search)
            ->latest('published_at')
            ->paginate($perPage)
            ->withQueryString(); // Preserve search parameters in pagination links
    }

    /**
     * Get a single published post by slug
     */
    public function getPublishedPostBySlug(string $slug): ?BlogPost
    {
        return BlogPost::published()
            ->where('slug', $slug)
            ->firstOrFail();
    }

    /**
     * Get all posts for admin (including drafts)
     */
    public function getAllPostsForAdmin(?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        return BlogPost::search($search)
            ->latest('created_at')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Get post by ID for admin
     */
    public function getPostById(int $id): BlogPost
    {
        return BlogPost::findOrFail($id);
    }

    /**
     * Get recent published posts
     */
    public function getRecentPosts(int $limit = 5): Collection
    {
        return BlogPost::published()
            ->latest('published_at')
            ->limit($limit)
            ->get(['id', 'title', 'slug', 'published_at']);
    }

    /**
     * Get post statistics for admin dashboard
     */
    public function getPostStatistics(): array
    {
        $total = BlogPost::count();
        $published = BlogPost::published()->count();
        $drafts = BlogPost::where('status', 'draft')->count();
        $scheduled = BlogPost::where('status', 'published')
            ->where('published_at', '>', now())
            ->count();

        return [
            'total' => $total,
            'published' => $published,
            'drafts' => $drafts,
            'scheduled' => $scheduled
        ];
    }
}
