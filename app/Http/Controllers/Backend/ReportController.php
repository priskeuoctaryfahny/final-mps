<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\Backend\Report;
use App\Models\Backend\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class ReportController extends Controller
{
    public function index()
    {
        $title = 'Master Data Laporan';
        $reports = Report::with('employee')->get();
        return view('backend.reports.index', compact('reports', 'title'));
    }

    public function create()
    {
        $title = 'Tambah Master Data Laporan';
        $employees = Employee::all();
        return view('backend.reports.create', compact('employees', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'description' => 'nullable|string',
            'status' => 'required|in:Positive,Warning,Critical',
            'employee_id' => 'required|exists:employees,id',
        ]);

        Report::create($request->all());

        return redirect()->route('reports.index')->with('success', 'Report created successfully.');
    }

    public function edit(Report $report)
    {
        $title = 'Edit Master Data Laporan';
        $employees = Employee::all();
        return view('backend.reports.edit', compact('report', 'employees', 'title'));
    }

    public function update(Request $request, Report $report)
    {
        $request->validate([
            'date' => 'required|date',
            'description' => 'nullable|string',
            'status' => 'required|in:Positive,Warning,Critical',
            'employee_id' => 'required|exists:employees,id',
        ]);

        $report->update($request->all());

        return redirect()->route('reports.index')->with('success', 'Report updated successfully.');
    }

    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $reportIds = $request->input('reportIds', []);
        if (!empty($reportIds)) {
            foreach ($reportIds as $reportId) {
                $report = Report::find($reportId);
                if ($report) {
                    $description = 'Pengguna ' . Auth::user()->name . ' menghapus laporan pada tanggal: ' . $report->date;
                    $this->logActivity('reports', Auth::user(), $report->id, $description);
                }
            }

            Report::whereIn('id', $reportIds)->delete();

            return redirect()->route('reports.index')
                ->with('success', 'Data laporan berhasil dihapus.');
        }

        return redirect()->route('reports.index')
            ->with('error', 'Data laporan tidak ditemukan.');
    }
}
