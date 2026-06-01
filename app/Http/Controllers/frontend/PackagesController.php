<?php

namespace App\Http\Controllers\frontend;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        return view('frontend.packages.index', compact('services', 'selectedService', 'packages'));
    }
}