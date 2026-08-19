@extends('layouts.admin')

@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5 mb-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Add New Client</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Register a new client profile and assign a
                care plan.</div>
        </div>
        <a href="{{ route('admin.clients.index') }}"
            class="px-5 py-2.5 bg-theme-bg hover:bg-theme-hover text-theme-text-main border border-theme-border rounded-[10px] text-[13px] font-bold transition-all flex items-center gap-2">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
            Back to List
        </a>
    </div>

    <div
        class="bg-theme-card rounded-[14px] border border-theme-border shadow-sm overflow-hidden text-theme-text-main">
        <form action="{{ route('admin.clients.store') }}" method="POST" class="p-8">
            @csrf
            <div class="grid sm:grid-cols-1 grid-cols-2 gap-6">
                <!-- Name -->
                <div class="space-y-1.5">
                    <label class="text-[13px] font-bold text-theme-text-main">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] text-theme-text-main placeholder:text-theme-text-muted outline-none focus:border-theme-primary focus:ring-2 focus:ring-theme-primary-light transition-all"
                        placeholder="e.g. Arthur Morgan">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div class="space-y-1.5">
                    <label class="text-[13px] font-bold text-theme-text-main">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] text-theme-text-main placeholder:text-theme-text-muted outline-none focus:border-theme-primary focus:ring-2 focus:ring-theme-primary-light transition-all"
                        placeholder="a.morgan@email.com">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Phone -->
                <div class="space-y-1.5">
                    <label class="text-[13px] font-bold text-theme-text-main">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] text-theme-text-main placeholder:text-theme-text-muted outline-none focus:border-theme-primary focus:ring-2 focus:ring-theme-primary-light transition-all"
                        placeholder="+1 555-0199">
                </div>

                <!-- DOB -->
                <div class="space-y-1.5">
                    <label class="text-[13px] font-bold text-theme-text-main">Date of Birth</label>
                    <input type="date" name="dob" value="{{ old('dob') }}"
                        class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] text-theme-text-main placeholder:text-theme-text-muted outline-none focus:border-theme-primary focus:ring-2 focus:ring-theme-primary-light transition-all">
                </div>

                <!-- Region -->
                <div class="space-y-1.5">
                    <label class="text-[13px] font-bold text-theme-text-main">Region / City</label>
                    <input type="text" name="region" value="{{ old('region') }}"
                        class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] text-theme-text-main placeholder:text-theme-text-muted outline-none focus:border-theme-primary focus:ring-2 focus:ring-theme-primary-light transition-all"
                        placeholder="e.g. Austin, TX">
                </div>

                <!-- Care Plan -->
                <div class="space-y-1.5">
                    <label class="text-[13px] font-bold text-theme-text-main">Care Plan</label>
                    <select name="care_plan"
                        class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] text-theme-text-main outline-none focus:border-theme-primary focus:ring-2 focus:ring-theme-primary-light cursor-pointer">
                        <option value="Standard">Standard Care</option>
                        <option value="Premium">24/7 Premium</option>
                        <option value="Emergency">Emergency Support</option>
                    </select>
                </div>

                <!-- Agent -->
                <div class="space-y-1.5">
                    <label class="text-[13px] font-bold text-theme-text-main">Assign Agent</label>
                    <select name="agent_id"
                        class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] text-theme-text-main outline-none focus:border-theme-primary focus:ring-2 focus:ring-theme-primary-light cursor-pointer">
                        <option value="">Unassigned</option>
                        @foreach ($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div class="space-y-1.5">
                    <label class="text-[13px] font-bold text-theme-text-main">Initial Status</label>
                    <select name="status"
                        class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] text-theme-text-main outline-none focus:border-theme-primary focus:ring-2 focus:ring-theme-primary-light cursor-pointer">
                        <option value="Active">Active</option>
                        <option value="Pending">Pending</option>
                        <option value="Critical">Critical</option>
                    </select>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-end gap-3 border-t border-theme-border pt-6">
                <button type="reset" class="px-6 py-2.5 text-[13px] font-bold text-theme-text-muted hover:text-theme-text-main transition-colors">
                    Reset Form
                </button>
                <button type="submit"
                    class="px-8 py-2.5 bg-theme-primary text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-theme-primary-hover transition-all">
                    Register Client
                </button>
            </div>
        </form>
    </div>
@endsection