@extends('layouts.admin')

@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5 mb-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Edit Client: {{ $client->user->name }}</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Update client profile details and service status.</div>
        </div>
        <a href="{{ route('admin.clients.index') }}"
            class="px-5 py-2.5 bg-theme-hover text-theme-text-main rounded-[10px] text-[13px] font-bold hover:bg-theme-hover transition-all flex items-center gap-2">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
            Back to List
        </a>
    </div>

    <div class="bg-theme-card rounded-[14px] border border-theme-border shadow-sm overflow-hidden">
        <form action="{{ route('admin.clients.update', $client->id) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="space-y-1.5">
                    <label class="text-[13px] font-bold text-theme-text-main">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $client->user->name) }}" required
                        class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] focus:ring-2 focus:ring-theme-primary-light transition-all">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div class="space-y-1.5">
                    <label class="text-[13px] font-bold text-theme-text-main">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $client->user->email) }}" required
                        class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] focus:ring-2 focus:ring-theme-primary-light transition-all">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Phone -->
                <div class="space-y-1.5">
                    <label class="text-[13px] font-bold text-theme-text-main">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $client->phone) }}"
                        class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] focus:ring-2 focus:ring-theme-primary-light transition-all">
                </div>

                <!-- DOB -->
                <div class="space-y-1.5">
                    <label class="text-[13px] font-bold text-theme-text-main">Date of Birth</label>
                    <input type="date" name="dob" value="{{ old('dob', $client->dob?->format('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] focus:ring-2 focus:ring-theme-primary-light transition-all">
                </div>

                <!-- Region -->
                <div class="space-y-1.5">
                    <label class="text-[13px] font-bold text-theme-text-main">Region / City</label>
                    <input type="text" name="region" value="{{ old('region', $client->region) }}"
                        class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] focus:ring-2 focus:ring-theme-primary-light transition-all">
                </div>

                <!-- Care Plan -->
                <div class="space-y-1.5">
                    <label class="text-[13px] font-bold text-theme-text-main">Care Plan</label>
                    <select name="care_plan"
                        class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] cursor-pointer">
                        <option value="Standard" {{ $client->care_plan == 'Standard' ? 'selected' : '' }}>Standard Care
                        </option>
                        <option value="24/7 Premium" {{ $client->care_plan == '24/7 Premium' ? 'selected' : '' }}>24/7 Premium
                        </option>
                        <option value="Emergency" {{ $client->care_plan == 'Emergency' ? 'selected' : '' }}>Emergency Support
                        </option>
                    </select>
                </div>

                <!-- Agent -->
                <div class="space-y-1.5">
                    <label class="text-[13px] font-bold text-theme-text-main">Assign Agent</label>
                    <select name="agent_id"
                        class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] cursor-pointer">
                        <option value="">Unassigned</option>
                        @foreach ($agents as $agent)
                            <option value="{{ $agent->id }}" {{ $client->agent_id == $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div class="space-y-1.5">
                    <label class="text-[13px] font-bold text-theme-text-main">Status</label>
                    <select name="status"
                        class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] cursor-pointer">
                        <option value="Active" {{ $client->status == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Pending" {{ $client->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Critical" {{ $client->status == 'Critical' ? 'selected' : '' }}>Critical</option>
                        <option value="Inactive" {{ $client->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-end gap-3 border-t border-theme-border pt-6">
                <button type="submit"
                    class="px-8 py-2.5 bg-[#1a3cdc] text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-[#1230b0] transition-all">
                    Update Client Profile
                </button>
            </div>
        </form>
    </div>
@endsection