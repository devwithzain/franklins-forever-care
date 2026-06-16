<?php

namespace App\Services;

use App\Models\AdminNotification;
use App\Models\User;
use App\Models\ServiceBooking;
use App\Models\EmployeeWorkload;
use Carbon\Carbon;

class NotificationService
{
    /**
     * Create a notification for unassigned booking
     */
    public function notifyUnassignedBooking(ServiceBooking $booking, ?int $userId = null): AdminNotification
    {
        return AdminNotification::create([
            'type' => 'unassigned_booking',
            'title' => 'New Unassigned Booking',
            'message' => "New booking for {$booking->patient_name} requires agent assignment.",
            'data' => [
                'booking_id' => $booking->id,
                'client_name' => $booking->user?->name,
                'patient_name' => $booking->patient_name,
                'service_name' => $booking->service?->name,
                'booking_date' => $booking->preferred_date?->format('Y-m-d'),
                'amount' => $booking->amount,
            ],
            'is_read' => false,
            'user_id' => $userId,
        ]);
    }

    /**
     * Create a notification for pending client request
     */
    public function notifyPendingRequest($request, ?int $userId = null): AdminNotification
    {
        $requestType = match($request->type) {
            'change_agent' => 'Agent Change Request',
            'outdoor_access' => 'Outdoor Access Request',
            'cancellation' => 'Cancellation Request',
            default => 'Client Request',
        };

        return AdminNotification::create([
            'type' => 'pending_request',
            'title' => "New {$requestType}",
            'message' => "{$request->client?->user?->name} has submitted a {$request->type} request.",
            'data' => [
                'request_id' => $request->id,
                'request_type' => $request->type,
                'client_name' => $request->client?->user?->name,
                'details' => $request->details,
            ],
            'is_read' => false,
            'user_id' => $userId,
        ]);
    }

    /**
     * Create a notification for payment overdue
     */
    public function notifyPaymentOverdue(ServiceBooking $booking, ?int $userId = null): AdminNotification
    {
        return AdminNotification::create([
            'type' => 'payment_overdue',
            'title' => 'Payment Overdue',
            'message' => "Payment overdue for {$booking->patient_name}'s booking.",
            'data' => [
                'booking_id' => $booking->id,
                'client_name' => $booking->user?->name,
                'patient_name' => $booking->patient_name,
                'amount' => $booking->amount,
                'payment_status' => $booking->payment_status,
            ],
            'is_read' => false,
            'user_id' => $userId,
        ]);
    }

    /**
     * Create a notification for agent assignment
     */
    public function notifyAgentAssignment(ServiceBooking $booking, User $agent): AdminNotification
    {
        return AdminNotification::create([
            'type' => 'agent_assigned',
            'title' => 'New Booking Assigned',
            'message' => "You have been assigned to {$booking->patient_name}.",
            'data' => [
                'booking_id' => $booking->id,
                'agent_id' => $agent->id,
                'agent_name' => $agent->name,
                'patient_name' => $booking->patient_name,
                'booking_date' => $booking->preferred_date?->format('Y-m-d'),
            ],
            'is_read' => false,
            'user_id' => $agent->id,
        ]);
    }

    /**
     * Create a broadcast notification for all users
     */
    public function notifyBroadcast($broadcast): void
    {
        $audience = $broadcast->audience;
        $usersQuery = User::query();
        
        if ($audience !== 'all') {
            $usersQuery->where('role', $audience);
        }
        
        $users = $usersQuery->get();
        
        foreach ($users as $user) {
            AdminNotification::create([
                'type' => 'broadcast',
                'title' => 'Announcement',
                'message' => $broadcast->message,
                'data' => [
                    'broadcast_id' => $broadcast->id,
                    'sender_id' => $broadcast->sender_id,
                ],
                'is_read' => false,
                'user_id' => $user->id,
            ]);
        }
    }

    /**
     * Get unread notifications count for a specific user
     */
    public function getUnreadCountForUser(?int $userId = null): array
    {
        $query = AdminNotification::unread();
        
        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->whereNull('user_id');
        }
        
        return [
            'total' => (clone $query)->count(),
            'unassigned_bookings' => (clone $query)->byType('unassigned_booking')->count(),
            'pending_requests' => (clone $query)->byType('pending_request')->count(),
            'payment_overdue' => (clone $query)->byType('payment_overdue')->count(),
            'agent_assigned' => (clone $query)->byType('agent_assigned')->count(),
            'broadcast' => (clone $query)->byType('broadcast')->count(),
        ];
    }

    /**
     * Get unread notifications count for admin dashboard
     */
    public function getUnreadCount(): array
    {
        return $this->getUnreadCountForUser();
    }

    /**
     * Get recent unread notifications for a specific user
     */
    public function getRecentUnreadForUser(int $limit = 10, ?int $userId = null)
    {
        $query = AdminNotification::unread();
        
        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->whereNull('user_id');
        }
        
        return $query->latest()->limit($limit)->get();
    }

    /**
     * Get recent unread notifications
     */
    public function getRecentUnread(int $limit = 10)
    {
        return $this->getRecentUnreadForUser($limit);
    }

    /**
     * Get all notifications for a specific user
     */
    public function getAllForUser(?int $userId = null, int $limit = 20)
    {
        $query = AdminNotification::query();
        
        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->whereNull('user_id');
        }
        
        return $query->latest()->paginate($limit);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(int $notificationId, ?int $userId = null): bool
    {
        $query = AdminNotification::where('id', $notificationId);
        
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        $notification = $query->first();
        if ($notification) {
            $notification->markAsRead();
            return true;
        }
        return false;
    }

    /**
     * Mark all notifications as read for a specific user
     */
    public function markAllAsReadForUser(?int $userId = null): int
    {
        $query = AdminNotification::where('is_read', false);
        
        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->whereNull('user_id');
        }
        
        return $query->update(['is_read' => true]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(): int
    {
        return $this->markAllAsReadForUser();
    }
}
