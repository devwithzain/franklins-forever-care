<?php

namespace App\Http\Controllers\Admin;

use App\Models\Package;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $packages = Package::with('service')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.container.packages.index', compact('packages', 'search'));
    }

    public function create()
    {
        $services = Service::where('status', 'active')->get();
        return view('admin.container.packages.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'duration' => 'required|string|max:255',
            'features' => 'required|array',
            'features.*' => 'required|string',
            'color' => 'nullable|string|max:20',
            'text_color' => 'nullable|string|max:20',
            'popular' => 'nullable|boolean',
            'status' => 'required|in:active,inactive',
            'service_id' => 'nullable|exists:services,id',
        ]);

        $validated['popular'] = $request->has('popular');
        
        Package::create($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully.');
    }

    public function edit(Package $package)
    {
        $services = Service::where('status', 'active')->get();
        return view('admin.container.packages.edit', compact('package', 'services'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'duration' => 'required|string|max:255',
            'features' => 'required|array',
            'features.*' => 'required|string',
            'color' => 'nullable|string|max:20',
            'text_color' => 'nullable|string|max:20',
            'popular' => 'nullable|boolean',
            'status' => 'required|in:active,inactive',
            'service_id' => 'nullable|exists:services,id',
        ]);

        $validated['popular'] = $request->has('popular');

        $package->update($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully.');
    }
}
