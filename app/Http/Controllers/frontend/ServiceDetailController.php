<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\View\View;

class ServiceDetailController extends Controller
{
    public function index($slug): View
    {
        $service = Service::where('slug', $slug)->where('status', 'active')->firstOrFail();
        $allServices = Service::where('status', 'active')->get();

        return view('frontend.service-detail.index', compact('service', 'allServices'));
    }
}
