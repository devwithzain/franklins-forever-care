<?php

namespace App\Http\Controllers\Admin\Request;

use App\Http\Controllers\Controller;
use App\Models\ClientRequest;
use App\Models\ServiceBooking;
use App\Services\WorkloadBalancingService;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class ClientRequestController extends Controller
{
    protected WorkloadBalancingService $workloadService;
    protected NotificationService $notificationService;

    public function __construct(
        WorkloadBalancingService $workloadService,
        NotificationService $notificationService
    ) {
        $this->workloadService = $workloadService;
        $this->notificationService = $notificationService;
    }

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

        // Execute the approved action if status is Approved
        if ($request->status === 'Approved') {
            $this->executeApprovedRequest($clientRequest);
        }

        return redirect()->route('admin.requests.index')->with('success', 'Request status updated to ' . $request->status);
    }

    /**
     * Execute the action for an approved request
     */
    private function executeApprovedRequest(ClientRequest $request): void
    {
        switch ($request->type) {
            case 'Change Agent':
                $this->executeChangeAgent($request);
                break;
            case 'Outdoor Access':
                $this->executeOutdoorAccess($request);
                break;
            case 'Cancellations':
                $this->executeCancellation($request);
                break;
        }
    }

    /**
     * Execute change agent request
     */
    private function executeChangeAgent(ClientRequest $request): void
    {
        if (!$request->details || !$request->client) {
            return;
        }

        // Find the new agent from request details (assuming it contains agent_id or agent name)
        // For now, we'll auto-assign using workload balancing
        $bookings = ServiceBooking::whereHas('client', function($q) use ($request) {
            $q->where('id', $request->client->id);
        })->get();

        foreach ($bookings as $booking) {
            $this->workloadService->assignWithBalancing($booking);
        }

        // Create notification
        $this->notificationService->create([
            'type' => 'agent_changed',
            'title' => 'Agent Changed via Request',
            'message' => "Agent changed for client {$request->client->user?->name} per their request.",
            'data' => [
                'request_id' => $request->id,
                'client_id' => $request->client->id,
            ],
            'is_read' => false,
        ]);
    }

    /**
     * Execute outdoor access request
     */
    private function executeOutdoorAccess(ClientRequest $request): void
    {
        // Update client's outdoor access status if field exists
        if ($request->client && method_exists($request->client, 'update')) {
            // Assuming there's an outdoor_access field or related model
            // This would need to be customized based on your actual schema
        }

        // Create notification
        $this->notificationService->create([
            'type' => 'outdoor_access_granted',
            'title' => 'Outdoor Access Granted',
            'message' => "Outdoor access granted to {$request->client->user?->name}.",
            'data' => [
                'request_id' => $request->id,
                'client_id' => $request->client?->id,
                'details' => $request->details,
            ],
            'is_read' => false,
        ]);
    }

    /**
     * Execute cancellation request
     */
    private function executeCancellation(ClientRequest $request): void
    {
        // Cancel associated bookings
        if ($request->client) {
            ServiceBooking::where('client_id', $request->client->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->update(['status' => 'cancelled']);
        }

        // Create notification
        $this->notificationService->create([
            'type' => 'booking_cancelled',
            'title' => 'Booking Cancelled via Request',
            'message' => "Bookings cancelled for {$request->client->user?->name}.",
            'data' => [
                'request_id' => $request->id,
                'client_id' => $request->client?->id,
            ],
            'is_read' => false,
        ]);
    }
}
