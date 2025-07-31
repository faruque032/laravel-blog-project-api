<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $posts = BlogPost::published()
            ->search($search)
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('blog.index', compact('posts')); 
    }

    public function show($id)
    {
        $post = BlogPost::published()->findOrFail($id);
        return view('blog.show', compact('post'));
    }

    public function adminList(Request $request)
    {
        $search = $request->get('search');
        $posts = BlogPost::search($search)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.blog_list', compact('posts'));
    }
}
