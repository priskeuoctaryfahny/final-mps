<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Models\Backend\Unit;
use Illuminate\Http\Request;
use App\Models\Backend\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class EmployeeController extends Controller
{
    public function index()
    {
        $title = 'Data Karyawan';
        $employees = Employee::with('unit')->get();
        return view('backend.employees.index', compact('employees', 'title'));
    }

    public function create()
    {
        $title = 'Tambah Data Karyawan';
        $users = User::all();
        $units = Unit::all();
        return view('backend.employees.create', compact('units', 'title', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|email|unique:employees',
            'name' => 'required|string|max:255',
            'employee_identification_number' => 'required|string|unique:employees',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'position_start_date' => 'required|date',
            'position' => 'nullable|string|max:255',
            'education_level' => 'nullable|in:Tidak Sekolah,SD,SMP,SMA,Diploma 3,Diploma 4 / Sarjana,Magister,Doktor,Profesional',
            'education_institution' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'graduation_date' => 'nullable|date',
            'unit_id' => 'required|exists:units,id',
        ]);

        Employee::create($request->all());

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function edit(Employee $employee)
    {
        $title = 'Edit Data Karyawan';
        $users = User::all();
        $units = Unit::all();
        return view('backend.employees.edit', compact('employee', 'units', 'title', 'users'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'name' => 'required|string|max:255',
            'employee_identification_number' => 'required|string|unique:employees,employee_identification_number,' . $employee->id,
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'position_start_date' => 'required|date',
            'position' => 'nullable|string|max:255',
            'education_level' => 'nullable|in:Tidak Sekolah,SD,SMP,SMA,Diploma 3,Diploma 4 / Sarjana,Magister,Doktor,Profesional',
            'education_institution' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'graduation_date' => 'nullable|date',
            'unit_id' => 'required|exists:units,id',
        ]);

        $employee->update($request->all());

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $employeeIds = explode(',', $request->input('employeeIds', ''));
        if (!empty($employeeIds)) {
            $employeeNips = Employee::whereIn('id', $employeeIds)
                ->pluck('employee_identification_number')
                ->toArray();

            foreach ($employeeIds as $employeeId) {
                $employee = Employee::find($employeeId);
                if ($employee) {
                    $description = 'Pengguna ' . Auth::user()->name . ' menghapus data pegawai dengan NIP: ' . $employee->employee_identification_number;
                    $this->logActivity('employees', Auth::user(), $employee->id, $description);
                }
            }

            Employee::whereIn('id', $employeeIds)->delete();

            return redirect()->route('employees.index')
                ->with('success', 'Data pegawai berhasil dihapus.');
        }

        return redirect()->route('employees.index')
            ->with('error', 'Data pegawai tidak ditemukan.');
    }

    public function disconnect($id): RedirectResponse
    {
        $employee = Employee::findOrFail($id);
        $employee->user_id = null;
        $employee->save();

        return redirect()->route('employees.edit', $employee->id)
            ->with('success', 'Koneksi akun berhasil diputuskan.');
    }
}
