<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Employee;
use App\Models\Backend\Unit;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('unit')->get();
        return view('backend.employees.index', compact('employees'));
    }

    public function create()
    {
        $units = Unit::all();
        return view('backend.employees.create', compact('units'));
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
        $units = Unit::all();
        return view('backend.employees.edit', compact('employee', 'units'));
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
}
