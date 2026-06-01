<?php

namespace App\Http\Controllers\frontend;

use Illuminate\View\View;
use App\Models\Employee;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
   public function index(): View
   {
      $employees = Employee::with('user')
         ->where('status', 'Active')
         ->orderBy('created_at', 'asc')
         ->get();

      return view('frontend.team.index', compact('employees'));
   }

   public function show(int $id): View
   {
      $employee = Employee::with(['user', 'clients'])
         ->where('status', 'Active')
         ->findOrFail($id);

      return view('frontend.team.show', compact('employee'));
   }
}
