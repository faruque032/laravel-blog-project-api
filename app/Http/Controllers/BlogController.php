<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogSearchRequest;
use App\Models\BlogPost;
use App\Services\BlogService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BlogController extends Controller
{
    protected BlogService $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    /**
     * Display a listing of published blog posts for frontend
     */
    public function index(BlogSearchRequest $request): View
    {
        $posts = $this->blogService->getPublishedPosts(
            $request->getSearchTerm(),
            $request->getPerPage()
        );

        $recentPosts = $this->blogService->getRecentPosts();

        return view('blog.index', compact('posts', 'recentPosts'));
    }

    /**
     * Display the specified blog post
     */
    public function show(string $slug): View
    {
        try {
            $post = $this->blogService->getPublishedPostBySlug($slug);
            $recentPosts = $this->blogService->getRecentPosts();
            
            return view('blog.show', compact('post', 'recentPosts'));
        } catch (ModelNotFoundException $e) {
            abort(404, 'Blog post not found');
        }
    }

    /**
     * Display blog list for admin with search and pagination
     */
    public function adminList(BlogSearchRequest $request): View
    {
        $posts = $this->blogService->getAllPostsForAdmin(
            $request->getSearchTerm(),
            $request->getPerPage()
        );

        $statistics = $this->blogService->getPostStatistics();

        return view('admin.blog_list', compact('posts', 'statistics'));
    }

    /**
     * Show the form for creating a new blog post
     */
    public function adminCreate(): View
    {
        return view('admin.blog_create');
    }

    /**
     * Show the form for editing a blog post
     */
    public function adminEdit(int $id): View
    {
        try {
            $post = $this->blogService->getPostById($id);
            return view('admin.blog_edit', compact('post'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.blog.list')
                ->with('error', 'Blog post not found');
        }
    }
}
