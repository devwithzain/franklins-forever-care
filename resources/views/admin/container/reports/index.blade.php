@extends('layouts.admin')
@section('title', 'Reports')
@section('admin-content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="w-full flex flex-col md:flex-row items-start md:items-center justify-between gap-5 mb-6">
        <div>
            <div class="text-2xl font-extrabold text-theme-text-main">Reports Analytics</div>
            <div class="text-[13px] text-theme-text-muted mt-1">Detailed operational insights, complaint summaries, and growth tracking.</div>
        </div>

        <form id="filterForm" action="{{ route('admin.reports') }}" method="GET" class="flex items-center gap-3">
            <select name="date_range" id="date_range" onchange="toggleCustomDates()" class="bg-theme-card border border-theme-border text-theme-text-main rounded-[10px] text-[13px] font-bold px-4 py-2.5 outline-none">
                <option value="today" {{ $range == 'today' ? 'selected' : '' }}>Today</option>
                <option value="last_7_days" {{ $range == 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                <option value="last_30_days" {{ $range == 'last_30_days' ? 'selected' : '' }}>Last 30 Days</option>
                <option value="this_month" {{ $range == 'this_month' ? 'selected' : '' }}>This Month</option>
                <option value="this_year" {{ $range == 'this_year' ? 'selected' : '' }}>This Year</option>
                <option value="custom" {{ $range == 'custom' ? 'selected' : '' }}>Custom Range</option>
            </select>

            <div id="custom_dates" class="{{ $range == 'custom' ? 'flex' : 'hidden' }} items-center gap-2">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="bg-theme-card border border-theme-border text-theme-text-main rounded-[10px] text-[13px] px-3 py-2">
                <span class="text-theme-text-muted text-[13px]">to</span>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="bg-theme-card border border-theme-border text-theme-text-main rounded-[10px] text-[13px] px-3 py-2">
            </div>

            <button type="submit" class="px-5 py-2.5 bg-[#1a3cdc] text-white rounded-[10px] text-[13px] font-bold shadow-md hover:bg-[#1230b0] transition-all">Filter</button>
        </form>

        <div class="flex gap-3">
            <a href="{{ route('admin.reports.export.csv', request()->all()) }}" class="px-5 py-2.5 bg-theme-card border border-theme-border text-theme-text-main rounded-[10px] text-[13px] font-bold hover:bg-theme-bg transition-all flex items-center gap-2">
                CSV
            </a>
            <a href="{{ route('admin.reports.export.pdf', request()->all()) }}" class="px-5 py-2.5 bg-theme-card border border-theme-border text-theme-text-main rounded-[10px] text-[13px] font-bold hover:bg-theme-bg transition-all flex items-center gap-2">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" y1="15" x2="12" y2="3" />
                </svg>
                PDF
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5 my-5">
        <div class="bg-theme-card rounded-[14px] border border-theme-border p-5 shadow-sm">
            <div class="text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">New Clients</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $summary['total_clients'] }}</div>
        </div>
        <div class="bg-theme-card rounded-[14px] border border-theme-border p-5 shadow-sm">
            <div class="text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">New Employees</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $summary['total_employees'] }}</div>
        </div>
        <div class="bg-theme-card rounded-[14px] border border-theme-border p-5 shadow-sm">
            <div class="text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Active Bookings</div>
            <div class="text-2xl font-extrabold text-theme-text-main text-green-600">{{ $summary['active_bookings'] }}</div>
        </div>
        <div class="bg-theme-card rounded-[14px] border border-theme-border p-5 shadow-sm">
            <div class="text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Unassigned Bookings</div>
            <div class="text-2xl font-extrabold text-red-500">{{ $summary['unassigned_bookings'] }}</div>
        </div>
        <div class="bg-theme-card rounded-[14px] border border-theme-border p-5 shadow-sm">
            <div class="text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Pending Bookings</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $summary['pending_bookings'] }}</div>
        </div>
        <div class="bg-theme-card rounded-[14px] border border-theme-border p-5 shadow-sm">
            <div class="text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Completed Services</div>
            <div class="text-2xl font-extrabold text-theme-text-main">{{ $summary['completed_services'] }}</div>
        </div>
        <div class="bg-theme-card rounded-[14px] border border-theme-border p-5 shadow-sm">
            <div class="text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Open Complaints</div>
            <div class="text-2xl font-extrabold text-red-500">{{ $summary['open_complaints'] }}</div>
        </div>
        <div class="bg-theme-card rounded-[14px] border border-theme-border p-5 shadow-sm">
            <div class="text-[12px] font-bold text-theme-text-muted uppercase tracking-widest mb-2">Resolved Complaints</div>
            <div class="text-2xl font-extrabold text-green-600">{{ $summary['resolved_complaints'] }}</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">
        <!-- User Growth Chart -->
        <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
            <h3 class="text-[15px] font-extrabold text-theme-text-main mb-4">Growth & Activity Over Time</h3>
            <canvas id="growthChart" height="200"></canvas>
        </div>

        <!-- Booking Status Donut Chart -->
        <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
            <h3 class="text-[15px] font-extrabold text-theme-text-main mb-4">Booking Status Breakdown</h3>
            <canvas id="bookingStatusChart" height="200"></canvas>
        </div>
    </div>

    <!-- Lists Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">
        <!-- Employee Workload Distribution -->
        <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
            <h3 class="text-[15px] font-extrabold text-theme-text-main mb-4">Top Employee Workloads (Active Bookings)</h3>
            <div class="space-y-4">
                @forelse($operational['employee_workloads'] as $index => $workload)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-50 text-[#1a3cdc] flex items-center justify-center font-bold text-[11px]">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            <span class="text-[13.5px] font-bold text-theme-text-main">{{ $workload['name'] }}</span>
                        </div>
                        <span class="text-[12px] font-bold text-theme-text-muted">{{ $workload['active_bookings'] }} Bookings</span>
                    </div>
                @empty
                    <div class="text-[13px] text-theme-text-muted">No active assignments in this period.</div>
                @endforelse
            </div>
        </div>

        <!-- PCA Complaints -->
        <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
            <h3 class="text-[15px] font-extrabold text-theme-text-main mb-4">Complaints per PCA</h3>
            <div class="space-y-4">
                @forelse($complaints['pca_complaints'] as $pcaComplaint)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-[13.5px] font-bold text-theme-text-main">{{ $pcaComplaint['employee_name'] }}</span>
                        </div>
                        <span class="text-[12px] font-bold text-red-500">{{ $pcaComplaint['count'] }} Complaint(s)</span>
                    </div>
                @empty
                    <div class="text-[13px] text-theme-text-muted">No PCA-specific complaints in this period.</div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        function toggleCustomDates() {
            const range = document.getElementById('date_range').value;
            const customDates = document.getElementById('custom_dates');
            if (range === 'custom') {
                customDates.classList.remove('hidden');
                customDates.classList.add('flex');
            } else {
                customDates.classList.add('hidden');
                customDates.classList.remove('flex');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Growth Chart
            const ctxGrowth = document.getElementById('growthChart').getContext('2d');
            const growthData = @json($growth);

            new Chart(ctxGrowth, {
                type: 'line',
                data: {
                    labels: growthData.dates,
                    datasets: [
                        {
                            label: 'New Clients',
                            data: growthData.clients,
                            borderColor: '#1a3cdc',
                            tension: 0.4,
                            fill: false
                        },
                        {
                            label: 'New Bookings',
                            data: growthData.bookings,
                            borderColor: '#10b981',
                            tension: 0.4,
                            fill: false
                        },
                        {
                            label: 'Complaints',
                            data: growthData.complaints,
                            borderColor: '#ef4444',
                            tension: 0.4,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });

            // Booking Status Chart
            const ctxStatus = document.getElementById('bookingStatusChart').getContext('2d');
            const statusData = @json($operational['booking_statuses']);

            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(statusData).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                    datasets: [{
                        data: Object.values(statusData),
                        backgroundColor: ['#f59e0b', '#10b981', '#3b82f6', '#ef4444', '#8b5cf6']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });
    </script>
@endsection