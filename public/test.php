<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "Clients: " . \App\Models\Client::count() . "\n";
echo "Employees: " . \App\Models\Employee::count() . "\n";
echo "CareerApps: " . \App\Models\CareerApplication::count() . "\n";
echo "ServiceBookings: " . \App\Models\ServiceBooking::count() . "\n";

$apps = \App\Models\CareerApplication::all();
foreach($apps as $app) {
    echo "App: {$app->id}, User: {$app->user_id}\n";
    try {
        $c = app(\App\Http\Controllers\Admin\Employee\EmployeeController::class);
        $c->approveApplication($app->id);
        echo "Approved app {$app->id} successfully\n";
    } catch (\Exception $e) {
        echo "Error approving app {$app->id}: " . $e->getMessage() . "\n";
    }
}

echo "Employees after: " . \App\Models\Employee::count() . "\n";
