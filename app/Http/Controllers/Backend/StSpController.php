<?php

namespace App\Http\Controllers\Backend;

use App\Models\Backend\StSp;
use Illuminate\Http\Request;
use App\Models\Backend\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class StSpController extends Controller
{
    public function index()
    {
        $title = 'Master Data ST/SP';
        $stsps = StSp::with('employee')->get();
        return view('backend.stsps.index', compact('stsps', 'title'));
    }

    public function create()
    {
        $title = 'Master Data ST/SP';
        $employees = Employee::all();
        return view('backend.stsps.create', compact('employees', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'status' => 'required|in:Open,Close',
            'employee_id' => 'required|exists:employees,id',
        ]);

        StSp::create($request->all());

        return redirect()->route('stsps.index')->with('success', 'ST/SP record created successfully.');
    }

    public function edit(StSp $stSp)
    {
        $title = 'Edit Master Data ST/SP';
        $employees = Employee::all();
        return view('backend.stsps.edit', compact('stSp', 'employees', 'title'));
    }

    public function update(Request $request, StSp $stSp)
    {
        $request->validate([
            ' date' => 'required|date',
            'status' => 'required|in:Open,Close',
            'employee_id' => 'required|exists:employees,id',
        ]);

        $stSp->update($request->all());

        return redirect()->route('stsps.index')->with('success', 'ST/SP record updated successfully.');
    }

    public function destroy(StSp $stSp)
    {
        $stSp->delete();
        return redirect()->route('stsps.index')->with('success', 'ST/SP record deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $stspIds = $request->input('stspIds', []);
        if (!empty($stspIds)) {
            foreach ($stspIds as $stspId) {
                $stsp = StSp::find($stspId);
                if ($stsp) {
                    $description = 'Pengguna ' . Auth::user()->name . ' menghapus ST/SP pada tanggal: ' . $stsp->date;
                    $this->logActivity('stsps', Auth::user(), $stsp->id, $description);
                }
            }

            StSp::whereIn('id', $stspIds)->delete();

            return redirect()->route('stsps.index')
                ->with('success', 'Data ST/SP berhasil dihapus.');
        }

        return redirect()->route('stsps.index')
            ->with('error', 'Data ST/SP tidak ditemukan.');
    }
}
