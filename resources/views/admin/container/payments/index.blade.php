@extends('layouts.admin')

@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Payments & Billing</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Manage invoices, monthly billing cycles, and payment receipts.
            </div>
        </div>
        <div class="flex gap-3">
            <button
                class="px-5 py-2.5 bg-theme-card border border-[#1a3cdc] text-[#1a3cdc] rounded-[10px] text-[13px] font-bold hover:bg-[#eef2ff] transition-all">Send
                Invoice</button>
            <button
                class="px-5 py-2.5 bg-[#1a3cdc] text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-[#1230b0] transition-all">Billing
                Adjustment</button>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 my-5">
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Total Billed (Oct)</div>
            <div class="text-2xl font-extrabold text-theme-text-main">$48,250</div>
            <div class="mt-2 flex items-center"><span
                    class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10.5px] font-bold">↑ 8% from last
                    month</span></div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Collected</div>
            <div class="text-2xl font-extrabold text-theme-text-main">$41,800</div>
            <div class="mt-2 flex items-center"><span
                    class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10.5px] font-bold">86.6% Rate</span>
            </div>
        </div>
        <div class="bg-[#1a3cdc] rounded-[14px] p-5 shadow-lg text-white">
            <div class="text-white/70 text-[12px] font-bold uppercase tracking-widest mb-1">Outstanding</div>
            <div class="text-2xl font-extrabold text-white">$6,450</div>
            <div class="mt-2 flex items-center"><span
                    class="px-2 py-0.5 rounded-full bg-white/20 text-white text-[10.5px] font-bold">Pending
                    Collection</span></div>
        </div>
        <div class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm">
            <div class="text-theme-text-muted text-[12px] font-bold uppercase tracking-widest mb-1">Overdue</div>
            <div class="text-2xl font-extrabold text-theme-text-main">$1,200</div>
            <div class="mt-2 flex items-center"><span
                    class="px-2 py-0.5 rounded-full bg-red-100 text-red-600 text-[10.5px] font-bold">⚠ Urgent Action</span>
            </div>
        </div>
    </div>
    <div class="bg-theme-card rounded-[14px] border border-theme-border overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-theme-border flex items-center justify-between flex-wrap gap-4">
            <h3 class="text-[15px] font-extrabold text-theme-text-main">Recent Billing Records</h3>
            <div class="flex items-center gap-3">
                <input type="text" placeholder="Search invoices..."
                    class="bg-theme-bg border border-theme-border rounded-[8px] px-4 py-2 text-[12.5px] outline-none focus:border-[#1a3cdc]">
                <select
                    class="bg-theme-card border border-theme-border rounded-[8px] px-3 py-2 text-[12px] font-bold outline-none cursor-pointer">
                    <option>All Status</option>
                    <option>Paid</option>
                    <option>Pending</option>
                    <option>Overdue</option>
                </select>
                <button
                    class="px-4 py-2 bg-slate-800 text-white rounded-[8px] text-[12px] font-bold hover:bg-black transition-all">Export
                    CSV</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-theme-bg border-b border-theme-border">
                    <tr>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Invoice #
                        </th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Client</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Service</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Period</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Amount</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Due Date</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest">Status</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-theme-text-muted uppercase tracking-widest text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-theme-border">
                    <tr class="hover:bg-theme-bg transition-colors">
                        <td class="px-6 py-4"><span
                                class="px-2 py-0.5 rounded bg-blue-50 text-[#1a3cdc] text-[11px] font-extrabold">INV-1024</span>
                        </td>
                        <td class="px-6 py-4 text-[13.5px] font-bold text-theme-text-main">Arthur Morgan</td>
                        <td class="px-6 py-4 text-[13px] text-theme-text-main">24/7 Premium Care</td>
                        <td class="px-6 py-4 text-[13px] text-theme-text-muted">Oct 1–31</td>
                        <td class="px-6 py-4 text-[13.5px] font-extrabold text-theme-text-main">$3,200</td>
                        <td class="px-6 py-4 text-[13px] text-theme-text-main">Oct 31, 2023</td>
                        <td class="px-6 py-4"><span
                                class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10.5px] font-bold">Paid</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button
                                class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection