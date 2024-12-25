<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Models\Backend\Employee;
use App\Models\Backend\Incident;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class IncidentController extends Controller
{
    public function index()
    {
        $title = 'Master Data Insiden';
        $incidents = Incident::with('employee')->get();
        return view('backend.incidents.index', compact('incidents', 'title'));
    }

    public function create()
    {
        $title = 'Tambah Master Data Insiden';
        $employees = Employee::all();
        return view('backend.incidents.create', compact('employees', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'severity' => 'required|in:Critical,Hampir Terjadi,Sedang,Rendah',
            'incident_type' => 'required|in:Gangguan,Psikolis,Penyakit,Cedera',
            'injury_consequence' => 'required|in:Tanpa Perawatan,Pertolongan Pertama,Perawatan Medis,Waktu Hilang',
            'employee_id' => 'required|exists:employees,id',
            'days_of_absence' => 'nullable|integer',
        ]);

        Incident::create($request->all());

        return redirect()->route('incidents.index')->with('success', 'Incident created successfully.');
    }

    public function edit(Incident $incident)
    {
        $title = 'Edit Master Data Insiden';
        $employees = Employee::all();
        return view('backend.incidents.edit', compact('incident', 'employees', 'title'));
    }

    public function update(Request $request, Incident $incident)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
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

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $incidentIds = $request->input('incidentIds', []);
        if (!empty($incidentIds)) {
            foreach ($incidentIds as $incidentId) {
                $incident = Incident::find($incidentId);
                if ($incident) {
                    $description = 'Pengguna ' . Auth::user()->name . ' menghapus insiden pada tanggal: ' . $incident->date;
                    $this->logActivity('incidents', Auth::user(), $incident->id, $description);
                }
            }

            Incident::whereIn('id', $incidentIds)->delete();

            return redirect()->route('incidents.index')
                ->with('success', 'Data insiden berhasil dihapus.');
        }

        return redirect()->route('incidents.index')
            ->with('error', 'Data insiden tidak ditemukan.');
    }
}
