<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Analytics Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1a3cdc; padding-bottom: 10px; }
        .title { font-size: 20px; font-weight: bold; color: #1a3cdc; }
        .subtitle { font-size: 12px; color: #666; margin-top: 5px; }
        .section { margin-bottom: 25px; }
        .section-title { font-size: 14px; font-weight: bold; background: #f0f4f8; padding: 8px; border-left: 4px solid #1a3cdc; margin-bottom: 10px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f8fafc; font-weight: bold; color: #555; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .stat-grid { display: block; width: 100%; }
        .stat-box { display: inline-block; width: 23%; box-sizing: border-box; border: 1px solid #eee; padding: 10px; margin-right: 1%; margin-bottom: 10px; background: #fafafa;}
        .stat-label { font-size: 10px; color: #777; text-transform: uppercase; }
        .stat-value { font-size: 18px; font-weight: bold; margin-top: 5px; color: #1a3cdc; }
    </style>
</head>
<body>

    <div class="header">
        <div class="title">Home Care Service Analytics Report</div>
        <div class="subtitle">Reporting Period: {{ $start->format('M d, Y') }} to {{ $end->format('M d, Y') }}</div>
    </div>

    <!-- Summary Metrics -->
    <div class="section">
        <div class="section-title">Executive Summary</div>
        <div class="stat-grid">
            <div class="stat-box">
                <div class="stat-label">New Clients</div>
                <div class="stat-value">{{ $summary['total_clients'] }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">New Employees</div>
                <div class="stat-value">{{ $summary['total_employees'] }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Active Bookings</div>
                <div class="stat-value">{{ $summary['active_bookings'] }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Completed Services</div>
                <div class="stat-value">{{ $summary['completed_services'] }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Pending Bookings</div>
                <div class="stat-value">{{ $summary['pending_bookings'] }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Unassigned</div>
                <div class="stat-value" style="color: #ef4444">{{ $summary['unassigned_bookings'] }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Open Complaints</div>
                <div class="stat-value" style="color: #ef4444">{{ $summary['open_complaints'] }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Resolved Complaints</div>
                <div class="stat-value" style="color: #10b981">{{ $summary['resolved_complaints'] }}</div>
            </div>
        </div>
    </div>

    <!-- Operational Data -->
    <div class="section">
        <div class="section-title">Operational Distribution</div>

        <table>
            <thead>
                <tr>
                    <th>Top Employee Workloads (PCA)</th>
                    <th class="text-right">Active Bookings</th>
                </tr>
            </thead>
            <tbody>
                @forelse($operational['employee_workloads'] as $workload)
                    <tr>
                        <td>{{ $workload['name'] }}</td>
                        <td class="text-right">{{ $workload['active_bookings'] }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="text-center">No workload data available.</td></tr>
                @endforelse
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <th>Booking Status Breakdown</th>
                    <th class="text-right">Count</th>
                </tr>
            </thead>
            <tbody>
                @forelse($operational['booking_statuses'] as $status => $count)
                    <tr>
                        <td>{{ ucfirst($status) }}</td>
                        <td class="text-right">{{ $count }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="text-center">No bookings recorded.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Complaint Data -->
    <div class="section">
        <div class="section-title">Complaint Summary</div>
        <table>
            <thead>
                <tr>
                    <th>Complaints by PCA</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($complaints['pca_complaints'] as $pca)
                    <tr>
                        <td>{{ $pca['employee_name'] }}</td>
                        <td class="text-right" style="color: #ef4444;">{{ $pca['count'] }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="text-center">No PCA complaints recorded.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="stat-grid" style="margin-top: 15px;">
            <div class="stat-box" style="width: 48%;">
                <div class="stat-label">Total Complaints Filed</div>
                <div class="stat-value">{{ $complaints['total'] }}</div>
            </div>
        </div>
    </div>

</body>
</html>