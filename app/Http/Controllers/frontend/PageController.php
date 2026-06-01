<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function privacy()
    {
        return view('frontend.privacy.index');
    }

    public function terms()
    {
        return view('frontend.terms.index');
    }
}
