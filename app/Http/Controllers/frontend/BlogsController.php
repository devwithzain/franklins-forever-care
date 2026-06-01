<?php

namespace App\Http\Controllers\frontend;

use App\Models\Tag;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogsController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->get('search');
        $categoryId = $request->get('category');
        $tagId = $request->get('tag');

        $blogs = Blog::with(['category', 'user'])
            ->where('status', 'published')
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->when($tagId, function ($query) use ($tagId) {
                return $query->whereHas('tags', function ($q) use ($tagId) {
                    $q->where('tags.id', $tagId);
                });
            })
            ->orderBy('published_at', 'desc')
            ->paginate(6);

        $categories = Category::where('type', 'blog')->withCount('blogs')->get();
        $popularPosts = Blog::where('status', 'published')->orderBy('published_at', 'desc')->take(3)->get();
        $tags = Tag::all();

        return view('frontend.blogs.index', compact('blogs', 'categories', 'popularPosts', 'tags', 'search'));
    }
}
