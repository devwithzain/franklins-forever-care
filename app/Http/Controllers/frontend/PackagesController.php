<?php

namespace App\Http\Controllers\frontend;

use App\Models\Service;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PackagesController extends Controller
{
    public function index(Request $request)
    {
        $selectedServiceId = $request->query('service');
        $services = Service::where('status', 'active')->get();
        $selectedService = $selectedServiceId ? Service::find($selectedServiceId) : $services->first();

        $packages = \App\Models\Package::where('status', 'active')
            ->where(function ($query) use ($selectedService) {
                $query->whereNull('service_id');
                if ($selectedService) {
                    $query->orWhere('service_id', $selectedService->id);
                }
            })
            ->get();

        // Get user's active subscriptions if authenticated
        $userSubscriptions = [];
        if (Auth::check()) {
            $userSubscriptions = ServiceBooking::where('user_id', Auth::id())
                ->whereIn('subscription_status', ['active', 'trialing'])
                ->whereNull('subscription_ends_at')
                ->orWhere('subscription_ends_at', '>', now())
                ->get()
                ->pluck('plan_type')
                ->map(fn($plan) => strtolower(str_replace(' ', '', $plan)))
                ->toArray();
        }

        return view('frontend.packages.index', compact('services', 'selectedService', 'packages', 'userSubscriptions'));
    }
}