<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $blogs = Blog::with(['category', 'user'])
            ->when($search, function ($query) use ($search) {
                return $query->where('title', 'like', "%{$search}%")
                             ->orWhere('content', 'like', "%{$search}%");
            })->paginate(10);

        return view('admin.container.blogs.index', compact('blogs', 'search'));
    }

    public function create()
    {
        $categories = Category::where('type', 'blog')->get();
        $tags = Tag::all();
        return view('admin.container.blogs.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:draft,published,archived',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['user_id'] = Auth::id();
        
        if ($request->status === 'published' && !$request->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/blogs'), $imageName);
            $data['image'] = 'uploads/blogs/'.$imageName;
        }

        $blog = Blog::create($data);

        if ($request->tags) {
            $blog->tags()->sync($request->tags);
        }

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created successfully.');
    }

    public function edit(Blog $blog)
    {
        $categories = Category::where('type', 'blog')->get();
        $tags = Tag::all();
        return view('admin.container.blogs.edit', compact('blog', 'categories', 'tags'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:draft,published,archived',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);

        if ($request->status === 'published' && !$blog->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            if ($blog->image && file_exists(public_path($blog->image))) {
                unlink(public_path($blog->image));
            }
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/blogs'), $imageName);
            $data['image'] = 'uploads/blogs/'.$imageName;
        }

        $blog->update($data);

        if ($request->tags) {
            $blog->tags()->sync($request->tags);
        }

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image && file_exists(public_path($blog->image))) {
            unlink(public_path($blog->image));
        }
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post deleted successfully.');
    }
}
