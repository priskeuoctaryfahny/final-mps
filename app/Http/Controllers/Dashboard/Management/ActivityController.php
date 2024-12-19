<?php

namespace App\Http\Controllers\Dashboard\Management;

use Carbon\Carbon;
use App\Models\Activity;
use Illuminate\View\View;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Exports\ActivitiesExport;
use Illuminate\Http\JsonResponse;
use App\Charts\UsersActivityChart;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Services\Export\ExportService;
use App\Http\Services\Dashboard\ActivityService;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ActivityController extends Controller
{
    use LogsActivity, ValidatesRequests;

    function __construct(
        private ActivityService $actService,
        private ExportService $exportService,
    ) {
        $this->middleware('permission:activity-list', ['only' => ['index']]);
        $this->middleware('permission:activity-download', ['only' => ['export']]);
        $this->actService = $actService;
        $this->exportService = $exportService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersActivityChart $chart): View
    {
        $columns = $this->actService->columns();

        $columnLabels = $this->actService->columnLabels();

        // Define columns to exclude
        $excludedColumns = $this->actService->columnExclude();

        $columnDetail = $this->actService->getAttributesWithDetails();

        $title = 'Histori Aktivitas Pengguna';
        $activities = Activity::latest()->paginate(10);
        $chart = $chart->build();

        return view('dashboard.activities.index', compact('activities', 'title', 'chart', 'columns', 'columnLabels', 'columnDetail'));
    }

    public function serverside(Request $request): JsonResponse
    {
        return $this->actService->dataTable($request);
    }

    public function export(Request $request, $format)
    {
        $selectedColumns = $request->input('columns', []);
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $exportData = Activity::where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->limit(100)
            ->get($selectedColumns);


        if ($exportData->isEmpty()) {
            return redirect()->back()->with('error', 'Data aktivitas tidak ditemukan.');
        }
        $description = 'Pengguna ' . Auth::user()->name . ' mengunduh data histori aktivitas pengguna dalam format ' . $format;
        $this->logActivity('activities', Auth::user(), null, $description);

        $columns = $this->actService->columns();

        $columnLabels = $this->actService->columnLabels();

        // Define columns to exclude
        $excludedColumns = $this->actService->columnExclude();

        $columnDetail = $this->actService->getAttributesWithDetails();



        $title = 'Histori Aktivitas Pengguna';
        $view = 'dashboard.activities.pdf';
        $fileName = 'Data Histori Aktivitas Pengguna';
        $paperSize = $request->input('paperSize', 'A4');
        $orientation = $request->input('orientation', 'portrait');

        $startDateTranslated = Carbon::parse($request->input('startDate'))->translatedFormat('d F Y');
        $endDateTranslated = Carbon::parse($request->input('endDate'))->translatedFormat('d F Y');
        $dateFilter = $startDateTranslated . ' - ' . $endDateTranslated;

        $data = compact('exportData', 'title', 'view', 'fileName', 'paperSize', 'orientation', 'columnLabels', 'selectedColumns', 'columns', 'dateFilter');

        if ($format === 'pdf') {
            $pdf = $this->exportService->exportPdf($data);
            return $pdf->download($fileName . '.pdf');
        } elseif ($format === 'excel') {
            $exportData = Activity::where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->get($selectedColumns);
            if ($exportData->isEmpty()) {
                return redirect()->back()->with('error', 'Data pengguna tidak ditemukan.');
            }
            return Excel::download(new ActivitiesExport($exportData, $columnDetail, $selectedColumns), 'Aktivitas pengguna.xlsx');
        }

        return redirect()->back()->with('error', 'Format file tidak ditemukan.');
    }
}
