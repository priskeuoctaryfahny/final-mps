<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\StSp;
use App\Models\Backend\Employee;
use Illuminate\Http\Request;

class StSpController extends Controller
{
    public function index()
    {
        $stSpRecords = StSp::with('employee')->get();
        return view('backend.st_sp.index', compact('stSpRecords'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('backend.st_sp.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'status' => 'required|in:Open,Close',
            'employee_id' => 'required|exists:employees,id',
        ]);

        StSp::create($request->all());

        return redirect()->route('st_sp.index')->with('success', 'ST/SP record created successfully.');
    }

    public function edit(StSp $stSp)
    {
        $employees = Employee::all();
        return view('backend.st_sp.edit', compact('stSp', 'employees'));
    }

    public function update(Request $request, StSp $stSp)
    {
        $request->validate([
            ' date' => 'required|date',
            'status' => 'required|in:Open,Close',
            'employee_id' => 'required|exists:employees,id',
        ]);

        $stSp->update($request->all());

        return redirect()->route('st_sp.index')->with('success', 'ST/SP record updated successfully.');
    }

    public function destroy(StSp $stSp)
    {
        $stSp->delete();
        return redirect()->route('st_sp.index')->with('success', 'ST/SP record deleted successfully.');
    }
}
