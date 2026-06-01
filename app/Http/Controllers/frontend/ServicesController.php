<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServicesController extends Controller
{
    public function index(Request $request): View
    {
        $services = Service::where('status', 'active')->paginate(9);
        return view('frontend.services.index', compact('services'));
    }
}
