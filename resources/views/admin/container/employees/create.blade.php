@extends('layouts.admin')

@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5 mb-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Add New PCA Agent</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Register a new Personal Care Agent to the system.</div>
        </div>
        <a href="{{ route('admin.employees.index') }}"
            class="px-5 py-2.5 bg-theme-hover text-theme-text-main rounded-[10px] text-[13px] font-bold hover:bg-theme-hover transition-all">
            Back to List
        </a>
    </div>

    <div class="bg-theme-card rounded-[14px] border border-theme-border shadow-sm overflow-hidden">
        <form action="{{ route('admin.employees.store') }}" method="POST" class="p-8">
            @csrf
            <div class="grid sm:grid-cols-1 grid-cols-2 gap-6">
                <!-- Basic Info -->
                <div class="space-y-4">
                    <h4 class="text-[14px] font-bold text-theme-text-main border-b border-theme-border pb-2">Account Information</h4>
                    <div>
                        <label class="text-[13px] font-bold text-theme-text-main">Full Name</label>
                        <input type="text" name="name" required placeholder="e.g. James Wilson"
                            class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] mt-1">
                    </div>
                    <div>
                        <label class="text-[13px] font-bold text-theme-text-main">Email Address</label>
                        <input type="email" name="email" required placeholder="j.wilson@care.com"
                            class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] mt-1">
                    </div>
                    <div>
                        <label class="text-[13px] font-bold text-theme-text-main">Password (Default: password123)</label>
                        <input type="password" name="password" placeholder="Leave blank for default"
                            class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] mt-1">
                    </div>
                </div>

                <!-- Agent Profile -->
                <div class="space-y-4">
                    <h4 class="text-[14px] font-bold text-theme-text-main border-b border-theme-border pb-2">Professional Details</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[13px] font-bold text-theme-text-main">Agent ID</label>
                            <input type="text" name="agent_custom_id" required placeholder="e.g. A-001"
                                class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] mt-1">
                        </div>
                        <div>
                            <label class="text-[13px] font-bold text-theme-text-main">Phone</label>
                            <input type="text" name="phone" placeholder="+1 555-0000"
                                class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] mt-1">
                        </div>
                    </div>
                    <div>
                        <label class="text-[13px] font-bold text-theme-text-main">SSN (Social Security Number)</label>
                        <input type="text" name="ssn" placeholder="***-**-0000"
                            class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] mt-1">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[13px] font-bold text-theme-text-main">Region/Area</label>
                            <select name="region"
                                class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] mt-1">
                                <option value="Austin, TX">Austin, TX</option>
                                <option value="Houston, TX">Houston, TX</option>
                                <option value="Dallas, TX">Dallas, TX</option>
                                <option value="San Antonio, TX">San Antonio, TX</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[13px] font-bold text-theme-text-main">Employment Type</label>
                            <select name="type"
                                class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] mt-1">
                                <option value="Full-time">Full-time</option>
                                <option value="24/7">24/7</option>
                                <option value="Part-time">Part-time</option>
                                <option value="Hourly">Hourly</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-[13px] font-bold text-theme-text-main">Initial Status</label>
                        <select name="status"
                            class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] mt-1">
                            <option value="Active">Active</option>
                            <option value="On Leave">On Leave</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-theme-border flex justify-end gap-3">
                <button type="reset" class="px-6 py-2.5 text-[13px] font-bold text-theme-text-muted hover:text-theme-text-main transition-all">Reset Form</button>
                <button type="submit" class="px-8 py-2.5 bg-[#1a3cdc] text-white rounded-[10px] text-[13px] font-bold shadow-lg hover:bg-[#1230b0] transition-all">Save Agent Profile</button>
            </div>
        </form>
    </div>
@endsection
