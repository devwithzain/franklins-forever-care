@extends('layouts.admin')

@section('admin-content')
    <div class="w-full flex items-center justify-between gap-5">
        <div>
            <div class="text-2xl font-extrabold text-slate-800">Employees / PCA Management</div>
            <div class="text-[13px] text-slate-500 mt-1">
                Personal Care Agents — profiles, assignments, and performance.
            </div>
        </div>
        <button
            class="px-5 py-2.5 bg-[#1a3cdc] text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-[#1230b0] transition-all flex items-center gap-2">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Add New Agent
        </button>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 my-5">
        <div class="bg-white rounded-[14px] p-5 border border-slate-200 shadow-sm">
            <div class="text-slate-400 text-[12px] font-bold uppercase tracking-widest mb-1">Total Agents</div>
            <div class="text-2xl font-extrabold text-slate-800">38</div>
            <div class="mt-2 flex items-center"><span
                    class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10.5px] font-bold">Registered</span>
            </div>
        </div>
        <div class="bg-white rounded-[14px] p-5 border border-slate-200 shadow-sm">
            <div class="text-slate-400 text-[12px] font-bold uppercase tracking-widest mb-1">On Active Duty</div>
            <div class="text-2xl font-extrabold text-slate-800">10</div>
            <div class="mt-2 flex items-center"><span
                    class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10.5px] font-bold">Working</span>
            </div>
        </div>
        <div class="bg-white rounded-[14px] p-5 border border-slate-200 shadow-sm">
            <div class="text-slate-400 text-[12px] font-bold uppercase tracking-widest mb-1">Available</div>
            <div class="text-2xl font-extrabold text-slate-800">22</div>
            <div class="mt-2 flex items-center"><span
                    class="px-2 py-0.5 rounded-full bg-blue-100 text-[#1a3cdc] text-[10.5px] font-bold">Ready</span></div>
        </div>
        <div class="bg-white rounded-[14px] p-5 border border-slate-200 shadow-sm">
            <div class="text-slate-400 text-[12px] font-bold uppercase tracking-widest mb-1">On Leave</div>
            <div class="text-2xl font-extrabold text-slate-800">6</div>
            <div class="mt-2 flex items-center"><span
                    class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-600 text-[10.5px] font-bold">Absent</span></div>
        </div>
    </div>
    <div class="bg-white rounded-[14px] border border-slate-200 overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-[15px] font-extrabold text-slate-800">All Personal Care Agents</h3>
            <div class="flex items-center gap-3">
                <input type="text" placeholder="Search agents..."
                    class="bg-slate-50 border border-slate-200 rounded-[8px] px-4 py-2 text-[12.5px] outline-none focus:border-[#1a3cdc]">
                <select
                    class="bg-white border border-[#1a3cdc] text-[#1a3cdc] rounded-[8px] px-3 py-2 text-[12px] font-bold outline-none cursor-pointer">
                    <option>All Types</option>
                    <option>24/7</option>
                    <option>Part-time</option>
                    <option>Hourly</option>
                </select>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-slate-400 uppercase tracking-widest">#</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-slate-400 uppercase tracking-widest">Agent Name
                        </th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-slate-400 uppercase tracking-widest">Contact</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-slate-400 uppercase tracking-widest">Area</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-slate-400 uppercase tracking-widest">Type</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-slate-400 uppercase tracking-widest">Clients</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-slate-400 uppercase tracking-widest">Rating</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-3 text-[10.5px] font-bold text-slate-400 uppercase tracking-widest text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-[13px] text-slate-500">A-001</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-9 h-9 rounded-full bg-[#dde3f8] text-[#1a3cdc] flex items-center justify-center font-extrabold text-[12px]">
                                    JW</div>
                                <div>
                                    <div class="text-[13.5px] font-bold text-slate-700">James Wilson</div>
                                    <div class="text-[11px] text-slate-400">SSN: ***-**-4521</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-[13px] font-bold text-slate-700">+1 555-1001</div>
                            <div class="text-[11px] text-slate-400">j.wilson@care.com</div>
                        </td>
                        <td class="px-6 py-4 text-[13px] text-slate-600">Austin, TX</td>
                        <td class="px-6 py-4"><span
                                class="px-2 py-0.5 rounded bg-blue-50 text-[#1a3cdc] text-[11px] font-bold">24/7</span></td>
                        <td class="px-6 py-4 text-[13.5px] font-bold text-slate-700 text-center">3</td>
                        <td class="px-6 py-4 text-[13px] text-amber-500 font-bold">⭐ 4.8</td>
                        <td class="px-6 py-4"><span
                                class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10.5px] font-bold">Active</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button
                                    class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all"><svg
                                        class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg></button>
                                <button
                                    class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-600 hover:text-white transition-all"><svg
                                        class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg></button>
                                <button
                                    class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all"><svg
                                        class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                    </svg></button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-[13px] text-slate-500">A-002</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-9 h-9 rounded-full bg-green-50 text-green-600 flex items-center justify-center font-extrabold text-[12px]">
                                    LB</div>
                                <div>
                                    <div class="text-[13.5px] font-bold text-slate-700">Lisa Brown</div>
                                    <div class="text-[11px] text-slate-400">SSN: ***-**-7832</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-[13px] font-bold text-slate-700">+1 555-1002</div>
                            <div class="text-[11px] text-slate-400">l.brown@care.com</div>
                        </td>
                        <td class="px-6 py-4 text-[13px] text-slate-600">Houston, TX</td>
                        <td class="px-6 py-4"><span
                                class="px-2 py-0.5 rounded bg-slate-50 text-slate-500 text-[11px] font-bold">Part-time</span>
                        </td>
                        <td class="px-6 py-4 text-[13.5px] font-bold text-slate-700 text-center">2</td>
                        <td class="px-6 py-4 text-[13px] text-amber-500 font-bold">⭐ 4.6</td>
                        <td class="px-6 py-4"><span
                                class="px-2 py-0.5 rounded-full bg-green-100 text-green-600 text-[10.5px] font-bold">Active</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button
                                    class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all"><svg
                                        class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg></button>
                                <button
                                    class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-600 hover:text-white transition-all"><svg
                                        class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg></button>
                                <button
                                    class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all"><svg
                                        class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                    </svg></button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-[13px] text-slate-500">A-003</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-9 h-9 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center font-extrabold text-[12px]">
                                    TD</div>
                                <div>
                                    <div class="text-[13.5px] font-bold text-slate-700">Tom Davis</div>
                                    <div class="text-[11px] text-slate-400">SSN: ***-**-3317</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-[13px] font-bold text-slate-700">+1 555-1003</div>
                            <div class="text-[11px] text-slate-400">t.davis@care.com</div>
                        </td>
                        <td class="px-6 py-4 text-[13px] text-slate-600">San Antonio, TX</td>
                        <td class="px-6 py-4"><span
                                class="px-2 py-0.5 rounded bg-blue-50 text-[#1a3cdc] text-[11px] font-bold">24/7</span></td>
                        <td class="px-6 py-4 text-[13.5px] font-bold text-slate-700 text-center">1</td>
                        <td class="px-6 py-4 text-[13px] text-amber-500 font-bold">⭐ 4.2</td>
                        <td class="px-6 py-4"><span
                                class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-600 text-[10.5px] font-bold">On
                                Leave</span></td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button
                                    class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all"><svg
                                        class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg></button>
                                <button
                                    class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-600 hover:text-white transition-all"><svg
                                        class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg></button>
                                <button
                                    class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all"><svg
                                        class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                    </svg></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection