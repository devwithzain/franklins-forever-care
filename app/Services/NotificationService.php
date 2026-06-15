<?php

namespace App\Services;

use App\Models\User;
use App\Models\ServiceBooking;
use App\Notifications\SystemNotification;

class NotificationService
{
    /**
     * Create a notification for unassigned booking
     */
    public function notifyUnassignedBooking(ServiceBooking $booking): void
    {
        $admins = User::where('role', 'admin')->get();

        $notification = new SystemNotification(
            'New Unassigned Booking',
            "New booking for {$booking->patient_name} requires agent assignment.",
            'unassigned_booking',
            [
                'booking_id' => $booking->id,
                'client_name' => $booking->user?->name,
                'patient_name' => $booking->patient_name,
                'service_name' => $booking->service?->name,
                'booking_date' => $booking->preferred_date?->format('Y-m-d'),
                'amount' => $booking->amount,
            ]
        );

        foreach ($admins as $admin) {
            $admin->notify($notification);
        }
    }

    /**
     * Create a notification for pending client request
     */
    public function notifyPendingRequest($request): void
    {
        $requestType = match($request->type) {
            'change_agent' => 'Agent Change Request',
            'outdoor_access' => 'Outdoor Access Request',
            'cancellation' => 'Cancellation Request',
            default => 'Client Request',
        };

        $admins = User::where('role', 'admin')->get();

        $notification = new SystemNotification(
            "New {$requestType}",
            "{$request->client?->user?->name} has submitted a {$request->type} request.",
            'pending_request',
            [
                'request_id' => $request->id,
                'request_type' => $request->type,
                'client_name' => $request->client?->user?->name,
                'details' => $request->details,
            ]
        );

        foreach ($admins as $admin) {
            $admin->notify($notification);
        }
    }

    /**
     * Create a notification for payment overdue
     */
    public function notifyPaymentOverdue(ServiceBooking $booking): void
    {
        $admins = User::where('role', 'admin')->get();

        $notification = new SystemNotification(
            'Payment Overdue',
            "Payment overdue for {$booking->patient_name}'s booking.",
            'payment_overdue',
            [
                'booking_id' => $booking->id,
                'client_name' => $booking->user?->name,
                'patient_name' => $booking->patient_name,
                'amount' => $booking->amount,
                'payment_status' => $booking->payment_status,
            ]
        );

        foreach ($admins as $admin) {
            $admin->notify($notification);
        }
    }

    /**
     * Create a notification for agent assignment
     */
    public function notifyAgentAssignment(ServiceBooking $booking, User $agent): void
    {
        $admins = User::where('role', 'admin')->get();

        $notification = new SystemNotification(
            'Agent Assigned to Booking',
            "{$agent->name} has been assigned to {$booking->patient_name}.",
            'agent_assigned',
            [
                'booking_id' => $booking->id,
                'agent_id' => $agent->id,
                'agent_name' => $agent->name,
                'patient_name' => $booking->patient_name,
                'booking_date' => $booking->preferred_date?->format('Y-m-d'),
            ]
        );

        foreach ($admins as $admin) {
            $admin->notify($notification);
        }
    }

    /**
     * Get unread notifications count for admin dashboard
     * We'll need to pass the user here. For AdminHomePageController we use auth()->user().
     */
    public function getUnreadCount(User $user): array
    {
        $unread = $user->unreadNotifications;

        return [
            'total' => $unread->count(),
            'unassigned_bookings' => $unread->filter(fn ($n) => isset($n->data['type']) && $n->data['type'] === 'unassigned_booking')->count(),
            'pending_requests' => $unread->filter(fn ($n) => isset($n->data['type']) && $n->data['type'] === 'pending_request')->count(),
            'payment_overdue' => $unread->filter(fn ($n) => isset($n->data['type']) && $n->data['type'] === 'payment_overdue')->count(),
            'agent_assigned' => $unread->filter(fn ($n) => isset($n->data['type']) && $n->data['type'] === 'agent_assigned')->count(),
        ];
    }

    /**
     * Get recent unread notifications
     */
    public function getRecentUnread(User $user, int $limit = 10)
    {
        return $user->unreadNotifications()->latest()->limit($limit)->get();
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(User $user, string $notificationId): bool
    {
        $notification = $user->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
            return true;
        }
        return false;
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(User $user): void
    {
        $user->unreadNotifications->markAsRead();
    }
}
