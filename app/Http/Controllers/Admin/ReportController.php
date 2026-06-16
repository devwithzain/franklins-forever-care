<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ReportService;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    protected ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    private function getDateRange(Request $request)
    {
        $range = $request->input('date_range', 'this_month');
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfDay();

        switch ($range) {
            case 'today':
                $start = Carbon::today();
                break;
            case 'last_7_days':
                $start = Carbon::now()->subDays(6)->startOfDay();
                break;
            case 'last_30_days':
                $start = Carbon::now()->subDays(29)->startOfDay();
                break;
            case 'this_month':
                $start = Carbon::now()->startOfMonth();
                break;
            case 'this_year':
                $start = Carbon::now()->startOfYear();
                break;
            case 'custom':
                if ($request->filled('start_date') && $request->filled('end_date')) {
                    $start = Carbon::parse($request->start_date)->startOfDay();
                    $end = Carbon::parse($request->end_date)->endOfDay();
                }
                break;
        }

        return [$start, $end, $range];
    }

    public function index(Request $request)
    {
        list($start, $end, $range) = $this->getDateRange($request);

        $summary = $this->reportService->getDashboardSummary($start, $end);
        $operational = $this->reportService->getOperationalReports($start, $end);
        $complaints = $this->reportService->getClientAndComplaintReports($start, $end);
        $growth = $this->reportService->getUserGrowthAndActivity($start, $end);

        return view('admin.container.reports.index', compact(
            'summary', 'operational', 'complaints', 'growth', 'start', 'end', 'range'
        ));
    }

    public function exportCsv(Request $request)
    {
        list($start, $end, $range) = $this->getDateRange($request);
        $summary = $this->reportService->getDashboardSummary($start, $end);

        $fileName = 'reports_' . $start->format('Y-m-d') . '_to_' . $end->format('Y-m-d') . '.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Metric', 'Value');

        $callback = function() use($summary, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($summary as $key => $value) {
                $row['Metric']  = ucwords(str_replace('_', ' ', $key));
                $row['Value']    = $value;
                fputcsv($file, array($row['Metric'], $row['Value']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        list($start, $end, $range) = $this->getDateRange($request);

        $summary = $this->reportService->getDashboardSummary($start, $end);
        $operational = $this->reportService->getOperationalReports($start, $end);
        $complaints = $this->reportService->getClientAndComplaintReports($start, $end);

        $pdf = Pdf::loadView('admin.container.reports.pdf', compact('summary', 'operational', 'complaints', 'start', 'end'));

        return $pdf->download('reports_' . $start->format('Y-m-d') . '_to_' . $end->format('Y-m-d') . '.pdf');
    }
}