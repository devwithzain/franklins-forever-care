<?php

namespace App\Http\Controllers\Admin\Complaint;

use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('client.user')->latest()->paginate(10);

        $stats = [
            'total' => Complaint::count(),
            'pending' => Complaint::where('status', 'Pending')->count(),
            'resolved' => Complaint::where('status', 'Resolved')->count(),
            'high_priority' => Complaint::where('priority', 'High')->where('status', 'Pending')->count(),
        ];

        return view('admin.container.complaints.index', compact('complaints', 'stats'));
    }

    public function updateStatus(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:Pending,Resolved',
        ]);

        $complaint->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.complaints.index')->with('success', 'Complaint status updated to ' . $request->status);
    }
}
