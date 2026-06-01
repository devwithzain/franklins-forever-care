<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Models\CareerApplication;
use App\Http\Controllers\Controller;

class CareerController extends Controller
{
    public function index()
    {
        return view('frontend.career.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'message' => 'nullable|string',
        ]);

        CareerApplication::create(array_merge($validated, [
            'user_id' => auth()->id()
        ]));

        return back()->with('success', 'Your application has been submitted successfully. We will get back to you soon!');
    }
}
