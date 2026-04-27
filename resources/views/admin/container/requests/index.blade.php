@extends('layouts.admin')

@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-slate-800">Client Requests</div>
            <div class="text-[13px] text-slate-500 mt-1">Review and approve service changes, outdoor requests, and
                cancellations.</div>
        </div>
    </div>
    <div class="flex gap-4 my-5 overflow-x-auto pb-2 custom-scrollbar">
        <button
            class="px-5 py-2.5 bg-[#1a3cdc] text-white rounded-[10px] text-[13px] font-bold shadow-md shadow-blue-100 whitespace-nowrap">All
            Requests (12)</button>
        <button
            class="px-5 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-[10px] text-[13px] font-bold hover:bg-slate-50 whitespace-nowrap">Change
            Agent (4)</button>
        <button
            class="px-5 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-[10px] text-[13px] font-bold hover:bg-slate-50 whitespace-nowrap">Outdoor
            Access (5)</button>
        <button
            class="px-5 py-2.5 bg-white border border-slate-200 text-slate-500 rounded-[10px] text-[13px] font-bold hover:bg-slate-50 whitespace-nowrap">Cancellations
            (3)</button>
    </div>
    <div class="bg-white rounded-[14px] border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-slate-400 uppercase tracking-widest">Client</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-slate-400 uppercase tracking-widest">Type</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-slate-400 uppercase tracking-widest">Date
                            Submitted</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-slate-400 uppercase tracking-widest">Priority</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-slate-400 uppercase tracking-widest text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-[13.5px] font-bold text-slate-700">Arthur Morgan</div>
                            <div class="text-[11px] text-slate-400">#REQ-8821</div>
                        </td>
                        <td class="px-6 py-4"><span
                                class="px-2 py-0.5 rounded bg-amber-50 text-amber-600 text-[11px] font-bold">Change
                                Agent</span></td>
                        <td class="px-6 py-4 text-[13px] text-slate-600">Oct 23, 2023</td>
                        <td class="px-6 py-4"><span
                                class="px-2 py-0.5 rounded bg-red-50 text-red-600 text-[11px] font-bold">High</span></td>
                        <td class="px-6 py-4"><span
                                class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[10.5px] font-bold">Pending</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button
                                    class="px-3 py-1.5 bg-green-500 text-white rounded-lg text-[11px] font-bold hover:bg-green-600 shadow-sm">Approve</button>
                                <button
                                    class="px-3 py-1.5 bg-white border border-slate-200 text-slate-600 rounded-lg text-[11px] font-bold hover:bg-slate-50 shadow-sm">Reject</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection