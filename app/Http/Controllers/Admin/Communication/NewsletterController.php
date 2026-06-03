<?php

namespace App\Http\Controllers\Admin\Communication;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class NewsletterController extends Controller
{
    /**
     * Display a listing of newsletter subscribers.
     */
    public function index(Request $request): View
    {
        $query = NewsletterSubscriber::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by email or name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $subscribers = $query->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total' => NewsletterSubscriber::count(),
            'active' => NewsletterSubscriber::where('status', NewsletterSubscriber::STATUS_ACTIVE)->count(),
            'pending' => NewsletterSubscriber::where('status', NewsletterSubscriber::STATUS_PENDING)->count(),
            'unsubscribed' => NewsletterSubscriber::where('status', NewsletterSubscriber::STATUS_UNSUBSCRIBED)->count(),
        ];

        return view('admin.container.newsletter.index', compact('subscribers', 'stats'));
    }

    /**
     * Show the form for creating a new subscriber.
     */
    public function create(): View
    {
        return view('admin.container.newsletter.create');
    }

    /**
     * Store a newly created subscriber.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email',
            'name' => 'nullable|string|max:255',
        ]);

        try {
            NewsletterSubscriber::create([
                'email' => $validated['email'],
                'name' => $validated['name'] ?? null,
                'status' => NewsletterSubscriber::STATUS_ACTIVE,
                'confirmed_at' => now(),
            ]);

            Log::info('Newsletter subscriber manually added', [
                'email' => $validated['email'],
            ]);

            return redirect()->route('admin.newsletter.index')
                ->with('success', 'Subscriber added successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to add newsletter subscriber', [
                'email' => $validated['email'] ?? null,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Failed to add subscriber. Please try again.');
        }
    }

    /**
     * Display the specified subscriber.
     */
    public function show(NewsletterSubscriber $subscriber): View
    {
        return view('admin.container.newsletter.show', compact('subscriber'));
    }

    /**
     * Confirm a pending subscription.
     */
    public function confirm(NewsletterSubscriber $subscriber): RedirectResponse
    {
        try {
            $subscriber->confirm();

            Log::info('Newsletter subscription confirmed', [
                'subscriber_id' => $subscriber->id,
                'email' => $subscriber->email,
            ]);

            return back()->with('success', 'Subscription confirmed successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to confirm subscription.');
        }
    }

    /**
     * Unsubscribe a user.
     */
    public function unsubscribe(Request $request, NewsletterSubscriber $subscriber): RedirectResponse
    {
        $validated = $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            $subscriber->unsubscribe($validated['reason'] ?? null);

            Log::info('Newsletter subscriber unsubscribed', [
                'subscriber_id' => $subscriber->id,
                'email' => $subscriber->email,
            ]);

            return back()->with('success', 'Subscriber unsubscribed successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to unsubscribe.');
        }
    }

    /**
     * Reactivate an unsubscribed user.
     */
    public function reactivate(NewsletterSubscriber $subscriber): RedirectResponse
    {
        try {
            $subscriber->update([
                'status' => NewsletterSubscriber::STATUS_ACTIVE,
                'unsubscribed_at' => null,
                'unsubscribe_reason' => null,
            ]);

            Log::info('Newsletter subscriber reactivated', [
                'subscriber_id' => $subscriber->id,
                'email' => $subscriber->email,
            ]);

            return back()->with('success', 'Subscriber reactivated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reactivate subscriber.');
        }
    }

    /**
     * Delete a subscriber permanently.
     */
    public function destroy(NewsletterSubscriber $subscriber): RedirectResponse
    {
        try {
            $subscriber->forceDelete();

            Log::info('Newsletter subscriber permanently deleted', [
                'subscriber_id' => $subscriber->id,
                'email' => $subscriber->email,
            ]);

            return redirect()->route('admin.newsletter.index')
                ->with('success', 'Subscriber deleted permanently.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete subscriber.');
        }
    }

    /**
     * Export subscribers list.
     */
    public function export(Request $request)
    {
        $query = NewsletterSubscriber::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $subscribers = $query->get(['email', 'name', 'status', 'created_at']);

        $csvData = "Email,Name,Status,Subscribed At\n";
        foreach ($subscribers as $subscriber) {
            $csvData .= sprintf(
                '"%s","%s","%s","%s"' . "\n",
                $subscriber->email,
                $subscriber->name ?? '',
                $subscriber->status,
                $subscriber->created_at->format('Y-m-d H:i:s')
            );
        }

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="newsletter_subscribers_' . date('Y-m-d') . '.csv"');
    }
}
