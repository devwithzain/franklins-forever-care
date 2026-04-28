<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
use App\Models\ClientRequest;
use Illuminate\Http\Request;

class ClientRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ClientRequest::with(['client.user'])->latest();
        
        $activeTab = $request->query('tab', 'all');
        
        if ($activeTab !== 'all') {
            $query->where('type', $activeTab);
        }
        
        $requests = $query->paginate(10)->appends(['tab' => $activeTab]);
        
        $stats = [
            'total' => ClientRequest::count(),
            'change_agent' => ClientRequest::where('type', 'Change Agent')->count(),
            'outdoor' => ClientRequest::where('type', 'Outdoor Access')->count(),
            'cancellations' => ClientRequest::where('type', 'Cancellations')->count(),
        ];

        return view('admin.container.requests.index', compact('requests', 'stats', 'activeTab'));
    }

    public function updateStatus(Request $request, ClientRequest $clientRequest)
    {
        $request->validate([
            'status' => 'required|in:Approved,Rejected',
        ]);

        $clientRequest->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.requests.index')->with('success', 'Request status updated to ' . $request->status);
    }
}
