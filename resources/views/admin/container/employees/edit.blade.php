@extends('layouts.admin')

@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5 mb-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Edit Agent: {{ $employee->user->name }}</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Update professional profile and account settings for this agent.</div>
        </div>
        <a href="{{ route('admin.employees.index') }}"
            class="px-5 py-2.5 bg-theme-hover text-theme-text-main rounded-[10px] text-[13px] font-bold hover:bg-theme-hover transition-all">
            Back to List
        </a>
    </div>

    <div class="bg-theme-card rounded-[14px] border border-theme-border shadow-sm overflow-hidden">
        <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Info -->
                <div class="space-y-4">
                    <h4 class="text-[14px] font-bold text-theme-text-main border-b border-theme-border pb-2">Account Information</h4>
                    <div>
                        <label class="text-[13px] font-bold text-theme-text-main">Full Name</label>
                        <input type="text" name="name" required value="{{ $employee->user->name }}"
                            class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] mt-1">
                    </div>
                    <div>
                        <label class="text-[13px] font-bold text-theme-text-main">Email Address</label>
                        <input type="email" name="email" required value="{{ $employee->user->email }}"
                            class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] mt-1">
                    </div>
                </div>

                <!-- Agent Profile -->
                <div class="space-y-4">
                    <h4 class="text-[14px] font-bold text-theme-text-main border-b border-theme-border pb-2">Professional Details</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[13px] font-bold text-theme-text-main">Agent ID</label>
                            <input type="text" value="{{ $employee->agent_custom_id }}" disabled
                                class="w-full px-4 py-2.5 bg-slate-200 border border-theme-border rounded-[10px] text-[13.5px] outline-none mt-1 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="text-[13px] font-bold text-theme-text-main">Phone</label>
                            <input type="text" name="phone" value="{{ $employee->phone }}"
                                class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] mt-1">
                        </div>
                    </div>
                    <div>
                        <label class="text-[13px] font-bold text-theme-text-main">SSN (Social Security Number)</label>
                        <input type="text" name="ssn" value="{{ $employee->ssn }}"
                            class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] mt-1">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[13px] font-bold text-theme-text-main">Region/Area</label>
                            <select name="region"
                                class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] mt-1">
                                <option value="Austin, TX" {{ $employee->region == 'Austin, TX' ? 'selected' : '' }}>Austin, TX</option>
                                <option value="Houston, TX" {{ $employee->region == 'Houston, TX' ? 'selected' : '' }}>Houston, TX</option>
                                <option value="Dallas, TX" {{ $employee->region == 'Dallas, TX' ? 'selected' : '' }}>Dallas, TX</option>
                                <option value="San Antonio, TX" {{ $employee->region == 'San Antonio, TX' ? 'selected' : '' }}>San Antonio, TX</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[13px] font-bold text-theme-text-main">Employment Type</label>
                            <select name="type"
                                class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] mt-1">
                                <option value="Full-time" {{ $employee->type == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                <option value="24/7" {{ $employee->type == '24/7' ? 'selected' : '' }}>24/7</option>
                                <option value="Part-time" {{ $employee->type == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                <option value="Hourly" {{ $employee->type == 'Hourly' ? 'selected' : '' }}>Hourly</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-[13px] font-bold text-theme-text-main">Employment Status</label>
                        <select name="status"
                            class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-[10px] text-[13.5px] outline-none focus:border-[#1a3cdc] mt-1">
                            <option value="Active" {{ $employee->status == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="On Leave" {{ $employee->status == 'On Leave' ? 'selected' : '' }}>On Leave</option>
                            <option value="Inactive" {{ $employee->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-theme-border flex justify-end gap-3">
                <a href="{{ route('admin.employees.index') }}" class="px-6 py-2.5 text-[13px] font-bold text-theme-text-muted hover:text-theme-text-main transition-all">Cancel</a>
                <button type="submit" class="px-8 py-2.5 bg-[#1a3cdc] text-white rounded-[10px] text-[13px] font-bold shadow-lg hover:bg-[#1230b0] transition-all">Update Agent Profile</button>
            </div>
        </form>
    </div>
@endsection
