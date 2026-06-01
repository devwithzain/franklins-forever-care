@extends('layouts.employee')
@section('title', 'Account Settings')
@section('employee-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Account Settings</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Manage your profile information, security, and active sessions.
            </div>
        </div>
    </div>
    <div class="grid sm:grid-cols-1 xm:grid-cols-1 grid-cols-3 gap-5 my-5">
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-theme-card rounded-[14px] border border-theme-border shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-theme-border">
                    <h3 class="text-[15px] font-extrabold text-theme-text-main">Profile Information</h3>
                </div>
                <form action="{{ route('employee.container.setting.update', Auth::user()->id) }}" method="post"
                    class="p-6 space-y-5" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="text-[12px] font-bold text-theme-text-muted uppercase mb-2 block">Full Name</label>
                            <input name="name" value="{{ Auth::user()->name }}"
                                class="w-full bg-theme-bg border border-theme-border rounded-lg px-4 py-2.5 text-[13px] outline-none focus:border-[#1a3cdc]"
                                type="text" />
                        </div>
                        <div>
                            <label class="text-[12px] font-bold text-theme-text-muted uppercase mb-2 block">Email Address</label>
                            <input name="email" value="{{ Auth::user()->email }}"
                                class="w-full bg-theme-bg border border-theme-border rounded-lg px-4 py-2.5 text-[13px] outline-none focus:border-[#1a3cdc]"
                                type="email">
                        </div>
                    </div>
                    <div>
                        <label class="text-[12px] font-bold text-theme-text-muted uppercase mb-2 block">Profile Picture</label>
                        <div class="flex items-center gap-5">
                            <img id="adminImagePreview"
                                src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('assets/placeholder.png') }}"
                                class="w-20 h-20 rounded-xl object-cover border border-theme-border shadow-sm">
                            <input name="image" type="file" onchange="previewImage(event)"
                                class="text-[13px] text-theme-text-muted file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[12px] file:font-bold file:bg-[#eef2ff] file:text-[#1a3cdc] hover:file:bg-[#1a3cdc] hover:file:text-white transition-all cursor-pointer">
                        </div>
                    </div>
                    <div class="pt-4 border-t border-theme-border">
                        <label class="flex items-center justify-between cursor-pointer group">
                            <div>
                                <div class="text-[14px] font-bold text-theme-text-main">Two-Factor Authentication</div>
                                <div class="text-[12px] text-theme-text-muted">Add an extra layer of security to your account.
                                </div>
                            </div>
                            <div class="relative inline-flex items-center">
                                <input type="checkbox" name="two_factor_enabled" value="1" {{ Auth::user()->two_factor_enabled ? 'checked' : '' }} class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#1a3cdc]">
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="pt-4">
                        <button type="submit"
                            class="px-6 py-2.5 bg-[#1a3cdc] text-white rounded-lg text-[13px] font-bold shadow-md hover:bg-[#1230b0] transition-all">Save
                            Changes</button>
                    </div>
                </form>
            </div>
            <div class="bg-theme-card rounded-[14px] border border-theme-border shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-theme-border flex items-center justify-between">
                    <h3 class="text-[15px] font-extrabold text-theme-text-main">Browser Sessions</h3>
                    <span
                        class="px-2 py-0.5 rounded-full bg-blue-50 text-blue-600 text-[10px] font-extrabold uppercase">Security
                        Log</span>
                </div>
                <div class="p-6 space-y-6">
                    @foreach($sessions as $session)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-theme-bg flex items-center justify-center text-theme-text-muted">
                                    @if(str_contains(strtolower($session->user_agent), 'mobile'))
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect width="14" height="20" x="5" y="2" rx="2" ry="2" />
                                            <path d="M12 18h.01" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect width="20" height="14" x="2" y="3" rx="2" />
                                            <line x1="8" x2="16" y1="21" y2="21" />
                                            <line x1="12" x2="12" y1="17" y2="21" />
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-[13.5px] font-bold text-theme-text-main">
                                        {{ $session->ip_address }}
                                        @if($session->is_current_device)
                                            <span class="text-green-600 text-[11px] font-extrabold ml-2">This Device</span>
                                        @endif
                                    </div>
                                    <div class="text-[12px] text-theme-text-muted">Last active {{ $session->last_activity }}</div>
                                </div>
                            </div>
                            @if(!$session->is_current_device)
                                <form action="{{ route('employee.setting.logout-session', $session->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[12px] font-bold text-red-500 hover:underline">Logout</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-theme-card rounded-[14px] border border-theme-border shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-theme-border">
                    <h3 class="text-[15px] font-extrabold text-theme-text-main">Change Password</h3>
                </div>
                <form action="{{ route('employee.container.setting.update', Auth::user()->id) }}" method="post"
                    class="p-6 space-y-5">
                    @method('PUT')
                    @csrf
                    <div>
                        <label class="text-[12px] font-bold text-theme-text-muted uppercase mb-2 block">Current Password</label>
                        <input name="current_password" type="password"
                            class="w-full bg-theme-bg border border-theme-border rounded-lg px-4 py-2.5 text-[13px] outline-none focus:border-[#1a3cdc]"
                            placeholder="••••••••">
                        @error('current_password') <span
                        class="text-red-500 text-[11px] font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="text-[12px] font-bold text-theme-text-muted uppercase mb-2 block">New Password</label>
                            <input name="password" type="password"
                                class="w-full bg-theme-bg border border-theme-border rounded-lg px-4 py-2.5 text-[13px] outline-none focus:border-[#1a3cdc]"
                                placeholder="••••••••">
                            @error('password') <span
                            class="text-red-500 text-[11px] font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="text-[12px] font-bold text-theme-text-muted uppercase mb-2 block">Confirm
                                Password</label>
                            <input name="password_confirmation" type="password"
                                class="w-full bg-theme-bg border border-theme-border rounded-lg px-4 py-2.5 text-[13px] outline-none focus:border-[#1a3cdc]"
                                placeholder="••••••••">
                        </div>
                    </div>
                    <div class="pt-4">
                        <button type="submit"
                            class="px-6 py-2.5 bg-slate-800 text-white rounded-lg text-[13px] font-bold shadow-md hover:bg-black transition-all">Update
                            Password</button>
                    </div>
                </form>
            </div>
        </div>
        <div>
            <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
                <h3 class="text-[14.5px] font-bold text-theme-text-main mb-6">Security Overview</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-[13px] text-theme-text-main font-medium">Two-Factor Auth</span>
                        <span
                            class="px-2 py-0.5 rounded-full {{ Auth::user()->two_factor_enabled ? 'bg-green-100 text-green-600' : 'bg-theme-hover text-theme-text-muted' }} text-[10px] font-extrabold uppercase">
                            {{ Auth::user()->two_factor_enabled ? 'Enabled' : 'Disabled' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[13px] text-theme-text-main font-medium">Last Login</span>
                        <b class="text-theme-text-main text-[13px]">Just Now</b>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[13px] text-theme-text-main font-medium">Active Sessions</span>
                        <b class="text-theme-text-main text-[13px]">{{ count($sessions) }}</b>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('adminImagePreview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) { preview.src = e.target.result; };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection