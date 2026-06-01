<?php

namespace App\Http\Controllers\frontend;

use App\Models\Blog;
use App\Models\Service;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(): View
    {
        $blogs = Blog::with(['category', 'user'])
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->take(6)
            ->get();

        $services = Service::where('status', 'active')
            ->orderBy('created_at', 'asc')
            ->take(6)
            ->get();

        return view('frontend.home.index', compact('blogs', 'services'));
    }
}
