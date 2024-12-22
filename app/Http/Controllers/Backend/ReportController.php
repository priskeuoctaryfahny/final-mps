<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Report;
use App\Models\Backend\Employee;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with('employee')->get();
        return view('backend.reports.index', compact('reports'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('backend.reports.create', compact('employees'));
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
        $employees = Employee::all();
        return view('backend.reports.edit', compact('report', 'employees'));
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
}
