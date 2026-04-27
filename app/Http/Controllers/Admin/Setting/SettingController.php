<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
   public function index()
   {
      $user = Auth::user();

      if ($user && $user->role === 'admin') {
         // Fetch active sessions
         $sessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($session) {
                return (object) [
                    'id' => $session->id,
                    'ip_address' => $session->ip_address,
                    'user_agent' => $session->user_agent,
                    'last_activity' => \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                    'is_current_device' => $session->id === request()->session()->getId(),
                ];
            });

         return view('admin.container.setting.listings', [
            'user' => $user,
            'sessions' => $sessions,
            'title' => 'Settings - Franklin\'s Forever Care'
         ]);
      }

      abort(403, 'Unauthorized access.');
   }

   public function update(Request $request, $id)
   {
      try {
         $user = User::findOrFail($id);
         
         $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'current_password' => 'required_with:password|string|nullable',
            'password' => ['nullable', 'confirmed', 'min:8'],
            'two_factor_enabled' => 'nullable|boolean',
         ]);

         if ($request->has('name')) {
            $user->name = $validatedData['name'];
         }

         if ($request->has('email') && $request->email !== $user->email) {
            $user->email = $validatedData['email'];
         }

         // Handle 2FA Toggle
         $user->two_factor_enabled = $request->has('two_factor_enabled');

         if ($request->hasFile('image')) {
            $storage = Storage::disk('public');

            if ($user->image && $storage->exists($user->image)) {
               $storage->delete($user->image);
            }

            $imageName = 'profile/' . Str::random(32) . "." . $request->image->getClientOriginalExtension();
            $storage->put($imageName, file_get_contents($request->image->getRealPath()));

            $user->image = $imageName;
         }

         if (!empty($validatedData['password'])) {
            if (!isset($validatedData['current_password']) || !Hash::check($validatedData['current_password'], $user->password)) {
               return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $user->password = Hash::make($validatedData['password']);
         }

         $user->save();

         return redirect()->back()->with('success', 'Settings updated successfully!');
      } catch (\Exception $e) {
         return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
      }
   }

   public function logoutSession($id)
   {
       DB::table('sessions')->where('id', $id)->where('user_id', Auth::id())->delete();
       return back()->with('success', 'Session terminated successfully.');
   }
}
