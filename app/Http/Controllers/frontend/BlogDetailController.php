<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\View\View;

class BlogDetailController extends Controller
{
    public function index($slug): View
    {
        $blog = Blog::with(['category', 'user', 'tags'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $categories = Category::where('type', 'blog')->withCount('blogs')->get();
        $popularPosts = Blog::where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
        $tags = Tag::all();

        return view('frontend.blog-detail.index', compact('blog', 'categories', 'popularPosts', 'tags'));
    }
}
