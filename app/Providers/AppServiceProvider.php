<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('components.sidebar', function ($view) {
            if (auth()->check() && auth()->user()->role === 'admin') {
                $view->with([
                    'pendingRequestsCount' => \App\Models\ClientRequest::where('status', 'Pending')->count(),
                    'pendingComplaintsCount' => \App\Models\Complaint::where('status', 'Pending')->count(),
                ]);
            }
        });
    }
}
