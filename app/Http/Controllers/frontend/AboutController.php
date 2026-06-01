<?php

namespace App\Http\Controllers\frontend;

use Illuminate\View\View;
use App\Models\Employee;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
   public function index(): View
   {
      $employees = Employee::with('user')
         ->where('status', 'Active')
         ->orderBy('created_at', 'asc')
         ->get();

      return view('frontend.about.index', compact('employees'));
   }
}
