<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Models\CareerApplication;
use App\Http\Controllers\Controller;

class CareerController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('frontend.career.index', compact('user'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', function ($attribute, $value, $fail) use ($user) {
                if ($value !== $user->email) {
                    $fail('You must use your registered email address.');
                }
            }],
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'message' => 'nullable|string',
        ]);

        CareerApplication::create(array_merge($validated, [
            'user_id' => $user->id
        ]));

        return back()->with('success', 'Your application has been submitted successfully. We will get back to you soon!');
    }
}
