<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:tags,name']);

        $tag = Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json([
            'id'   => $tag->id,
            'name' => $tag->name,
        ]);
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->json(['success' => true]);
    }
}
