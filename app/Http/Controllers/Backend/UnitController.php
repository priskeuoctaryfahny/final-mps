<?php

namespace App\Http\Controllers\Backend;

use App\Models\Backend\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class UnitController extends Controller
{
    public function index()
    {
        $title = 'Master Data Unit';
        $units = Unit::all();
        return view('backend.units.index', compact('units', 'title'));
    }

    public function create()
    {
        $title = 'Tambah Unit';
        return view('backend.units.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Unit::create($request->all());

        return redirect()->route('units.index')->with('success', 'Unit created successfully.');
    }

    public function edit(Unit $unit)
    {
        $title = 'Edit Unit';
        return view('backend.units.edit', compact('unit', 'title'));
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $unit->update($request->all());

        return redirect()->route('units.index')->with('success', 'Unit updated successfully.');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('units.index')->with('success', 'Unit deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $unitIds = $request->input('unitIds', []);
        if (!empty($unitIds)) {
            foreach ($unitIds as $unitId) {
                $unit = Unit::find($unitId);
                if ($unit) {
                    $description = 'Pengguna ' . Auth::user()->name . ' menghapus unit: ' . $unit->name;
                    $this->logActivity('units', Auth::user(), $unit->id, $description);
                }
            }

            Unit::whereIn('id', $unitIds)->delete();

            return redirect()->route('units.index')
                ->with('success', 'Data unit berhasil dihapus.');
        }

        return redirect()->route('units.index')
            ->with('error', 'Data unit tidak ditemukan.');
    }
}
