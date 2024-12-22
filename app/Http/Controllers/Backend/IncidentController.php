<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Incident;
use App\Models\Backend\Employee;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function index()
    {
        $incidents = Incident::with('employee')->get();
        return view('backend.incidents.index', compact('incidents'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('backend.incidents.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|time',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'severity' => 'required|in:Critical,Hampir Terjadi,Sedang,Rendah',
            'incident_type' => 'required|in:Gangguan,Psikolis,Penyakit,Cedera',
            'injury_consequence' => 'required|in:Tanpa Perawatan,Pertolongan Pertama,Perawatan Medis,Waktu Hil ang',
            'employee_id' => 'required|exists:employees,id',
            'days_of_absence' => 'nullable|integer',
        ]);

        Incident::create($request->all());

        return redirect()->route('incidents.index')->with('success', 'Incident created successfully.');
    }

    public function edit(Incident $incident)
    {
        $employees = Employee::all();
        return view('backend.incidents.edit', compact('incident', 'employees'));
    }

    public function update(Request $request, Incident $incident)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|time',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'severity' => 'required|in:Critical,Hampir Terjadi,Sedang,Rendah',
            'incident_type' => 'required|in:Gangguan,Psikolis,Penyakit,Cedera',
            'injury_consequence' => 'required|in:Tanpa Perawatan,Pertolongan Pertama,Perawatan Medis,Waktu Hilang',
            'employee_id' => 'required|exists:employees,id',
            'days_of_absence' => 'nullable|integer',
        ]);

        $incident->update($request->all());

        return redirect()->route('incidents.index')->with('success', 'Incident updated successfully.');
    }

    public function destroy(Incident $incident)
    {
        $incident->delete();
        return redirect()->route('incidents.index')->with('success', 'Incident deleted successfully.');
    }
}
