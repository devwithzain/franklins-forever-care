<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Models\User;
use App\Http\Controllers\Controller;

class AdminHomePageController extends Controller
{
   public function index()
   {
      $users = User::whereIn('role', ['user', 'client', 'employee'])->get();
      return view('admin.container.home.dashboard', [
         'title' => "Admin Dashboard – Franklin's Forever Care",
         'users' => $users,
      ]);
   }
   public function employees()
   {
      return view('admin.container.employees.index');
   }
   public function attendance()
   {
      return view('admin.container.attendance.index');
   }
   public function payments()
   {
      return view('admin.container.payments.index');
   }
   public function outdoor()
   {
      return view('admin.container.outdoor.index');
   }
   public function requests()
   {
      return view('admin.container.requests.index');
   }
   public function complaints()
   {
      return view('admin.container.complaints.index');
   }
   public function notifications()
   {
      return view('admin.container.notifications.index');
   }
   public function reports()
   {
      return view('admin.container.reports.index');
   }
}
