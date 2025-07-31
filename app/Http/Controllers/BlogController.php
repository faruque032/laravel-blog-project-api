<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $posts = DB::table('blog_posts')
            ->where('title', 'like', '%' . $search . '%')
            ->orWhere('content', 'like', '%' . $search . '%')
            ->get(); 

        return view('blog.index', compact('posts')); 
    }

    public function show($id)
    {
        $post = DB::table('blog_posts')->where('id', $id)->first();
        return view('blog.show', compact('post'));
    }

    public function adminList()
    {
        $posts = DB::table('blog_posts')->get();
        return view('admin.blog_list', compact('posts'));
    }
}
