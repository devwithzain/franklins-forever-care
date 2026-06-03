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
    public function notifyUnassignedBooking(ServiceBooking $booking): AdminNotification
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
        ]);
    }

    /**
     * Create a notification for pending client request
     */
    public function notifyPendingRequest($request): AdminNotification
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
        ]);
    }

    /**
     * Create a notification for payment overdue
     */
    public function notifyPaymentOverdue(ServiceBooking $booking): AdminNotification
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
        ]);
    }

    /**
     * Create a notification for agent assignment
     */
    public function notifyAgentAssignment(ServiceBooking $booking, User $agent): AdminNotification
    {
        return AdminNotification::create([
            'type' => 'agent_assigned',
            'title' => 'Agent Assigned to Booking',
            'message' => "{$agent->name} has been assigned to {$booking->patient_name}.",
            'data' => [
                'booking_id' => $booking->id,
                'agent_id' => $agent->id,
                'agent_name' => $agent->name,
                'patient_name' => $booking->patient_name,
                'booking_date' => $booking->preferred_date?->format('Y-m-d'),
            ],
            'is_read' => false,
        ]);
    }

    /**
     * Get unread notifications count for admin dashboard
     */
    public function getUnreadCount(): array
    {
        return [
            'total' => AdminNotification::unread()->count(),
            'unassigned_bookings' => AdminNotification::unread()->byType('unassigned_booking')->count(),
            'pending_requests' => AdminNotification::unread()->byType('pending_request')->count(),
            'payment_overdue' => AdminNotification::unread()->byType('payment_overdue')->count(),
            'agent_assigned' => AdminNotification::unread()->byType('agent_assigned')->count(),
        ];
    }

    /**
     * Get recent unread notifications
     */
    public function getRecentUnread(int $limit = 10)
    {
        return AdminNotification::unread()
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(int $notificationId): bool
    {
        $notification = AdminNotification::find($notificationId);
        if ($notification) {
            $notification->markAsRead();
            return true;
        }
        return false;
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(): int
    {
        return AdminNotification::where('is_read', false)->update(['is_read' => true]);
    }
}
