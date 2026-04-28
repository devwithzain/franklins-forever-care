@extends('layouts.user')

@section('client-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Notifications Center</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Manage system-wide broadcasts and personalized alerts.</div>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 my-5">
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-theme-card rounded-[14px] border border-theme-border overflow-hidden shadow-sm">
                <div class="px-6 py-5 border-b border-theme-border flex items-center justify-between">
                    <h3 class="text-[15px] font-extrabold text-theme-text-main">Recent Notifications</h3>
                    <button class="text-[12px] font-bold text-[#1a3cdc] hover:underline">Mark all as read</button>
                </div>
                <div class="divide-y divide-theme-border">
                    <div class="p-6 flex gap-4 hover:bg-theme-bg transition-colors">
                        <div
                            class="w-10 h-10 rounded-full bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-[14px] font-bold text-theme-text-main">Critical Alert: Agent Unassigned</span>
                                <span class="text-[11px] text-theme-text-muted">2 mins ago</span>
                            </div>
                            <p class="text-[13px] text-theme-text-muted leading-relaxed">Arthur Morgan's agent (James Wilson) is
                                currently offline during a scheduled 24/7 care window.</p>
                            <div class="mt-3 flex gap-2">
                                <button class="px-3 py-1 bg-[#1a3cdc] text-white rounded-[6px] text-[11px] font-bold">Assign
                                    Now</button>
                                <button
                                    class="px-3 py-1 bg-theme-hover text-theme-text-main rounded-[6px] text-[11px] font-bold">Ignore</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
                <h3 class="text-[14.5px] font-bold text-theme-text-main mb-6">Send Quick Broadcast</h3>
                <form class="space-y-4">
                    <div>
                        <label
                            class="text-[11px] font-bold text-theme-text-muted uppercase tracking-widest block mb-2">Audience</label>
                        <select
                            class="w-full bg-theme-bg border border-theme-border rounded-lg px-4 py-2 text-[13px] font-medium outline-none">
                            <option>All Users</option>
                            <option>Clients Only</option>
                            <option>Agents Only</option>
                        </select>
                    </div>
                    <div>
                        <label
                            class="text-[11px] font-bold text-theme-text-muted uppercase tracking-widest block mb-2">Message</label>
                        <textarea
                            class="w-full bg-theme-bg border border-theme-border rounded-lg px-4 py-3 text-[13px] h-32 outline-none focus:border-[#1a3cdc]"
                            placeholder="Type your broadcast message..."></textarea>
                    </div>
                    <button type="submit"
                        class="w-full py-2.5 bg-[#1a3cdc] text-white rounded-lg text-[13px] font-bold shadow-md hover:bg-[#1230b0] transition-all">Send
                        Notification</button>
                </form>
            </div>
        </div>
    </div>
@endsection