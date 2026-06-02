<?php

namespace App\Http\Controllers\Admin\Communication;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ContactSubmissionController extends Controller
{
    /**
     * Display a listing of contact submissions.
     */
    public function index(Request $request): View
    {
        $query = ContactSubmission::with('assignedAdmin');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $submissions = $query->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total' => ContactSubmission::count(),
            'new' => ContactSubmission::where('status', ContactSubmission::STATUS_NEW)->count(),
            'in_progress' => ContactSubmission::where('status', ContactSubmission::STATUS_IN_PROGRESS)->count(),
            'resolved' => ContactSubmission::where('status', ContactSubmission::STATUS_RESOLVED)->count(),
        ];

        return view('admin.container.contact-submissions.index', compact('submissions', 'stats'));
    }

    /**
     * Display the specified contact submission.
     */
    public function show(ContactSubmission $submission): View
    {
        // Mark as read
        $submission->markAsRead();

        $submission->load('assignedAdmin');

        return view('admin.container.contact-submissions.show', compact('submission'));
    }

    /**
     * Assign submission to current admin.
     */
    public function assign(Request $request, ContactSubmission $submission): RedirectResponse
    {
        try {
            $submission->assignTo(Auth::id());
            
            Log::info('Contact submission assigned', [
                'submission_id' => $submission->id,
                'assigned_to' => Auth::id(),
            ]);

            return back()->with('success', 'Submission assigned to you successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to assign submission', [
                'submission_id' => $submission->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Failed to assign submission. Please try again.');
        }
    }

    /**
     * Update the status of a submission.
     */
    public function updateStatus(Request $request, ContactSubmission $submission): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:new,in_progress,resolved,spam',
            'admin_notes' => 'nullable|string|max:5000',
        ]);

        try {
            $updateData = ['status' => $validated['status']];
            
            if (isset($validated['admin_notes'])) {
                $updateData['admin_notes'] = $validated['admin_notes'];
            }

            $submission->update($updateData);

            Log::info('Contact submission status updated', [
                'submission_id' => $submission->id,
                'new_status' => $validated['status'],
            ]);

            return back()->with('success', 'Submission status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update submission status', [
                'submission_id' => $submission->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Failed to update status. Please try again.');
        }
    }

    /**
     * Mark submission as spam.
     */
    public function markAsSpam(ContactSubmission $submission): RedirectResponse
    {
        try {
            $submission->markAsSpam();

            Log::info('Contact submission marked as spam', [
                'submission_id' => $submission->id,
            ]);

            return back()->with('success', 'Submission marked as spam.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to mark as spam. Please try again.');
        }
    }

    /**
     * Resolve the submission.
     */
    public function resolve(Request $request, ContactSubmission $submission): RedirectResponse
    {
        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:5000',
        ]);

        try {
            $submission->resolve($validated['admin_notes'] ?? null);

            Log::info('Contact submission resolved', [
                'submission_id' => $submission->id,
            ]);

            return back()->with('success', 'Submission marked as resolved.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to resolve submission. Please try again.');
        }
    }

    /**
     * Delete a submission (soft delete).
     */
    public function destroy(ContactSubmission $submission): RedirectResponse
    {
        try {
            $submission->delete();

            Log::info('Contact submission deleted', [
                'submission_id' => $submission->id,
            ]);

            return redirect()->route('admin.contact-submissions.index')
                ->with('success', 'Submission deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete submission. Please try again.');
        }
    }
}
