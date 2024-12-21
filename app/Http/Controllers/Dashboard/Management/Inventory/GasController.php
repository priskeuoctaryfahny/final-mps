<?php

namespace App\Http\Controllers\Dashboard\Management\Inventory;

use App\Models\User;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Models\Dashboard\Gas;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

class GasController extends Controller
{
    use LogsActivity, ValidatesRequests;

    function __construct()
    {
        $this->middleware('permission:gas-list|gas-create|gas-edit|gas-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:gas-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:gas-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:gas-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Master Gas';
        $gases = Gas::all();

        return view('dashboard.inventory.gases.index', compact('gases', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gases = Gas::all();
        $title = 'Tambah Master Gas';
        $users = User::all();

        return view('dashboard.inventory.gases.create', compact('gases', 'title', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255', // Added max length for string
        ]);
        try {
            Gas::create($data);

            return redirect()->route('gases.index')
                ->with('success', 'Data Gas Berhasil Ditambahkan...');
        } catch (\Exception $error) {
            return redirect()->route('gases.index')
                ->with('error', 'Data Gas Gagal Ditambahkan...' . $error->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gas = Gas::findOrFail($id); // Retrieve the gas record or fail with a 404
        $title = 'Edit Master Gas';
        $users = User::all();

        return view('dashboard.inventory.gases.edit', compact('gas', 'title', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255', // Added max length for string
        ]);

        try {
            $gas = Gas::findOrFail($id); // Retrieve the gas record or fail with a 404
            $gas->update($data); // Update the gas record

            return redirect()->route('gases.index')
                ->with('success', 'Data Gas Berhasil Diperbarui...');
        } catch (\Exception $error) {
            return redirect()->route('gases.index')
                ->with('error', 'Data Gas Gagal Diperbarui: ' . $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $gas = Gas::findOrFail($id); // Retrieve the gas record or fail with a 404
            $gas->delete(); // Delete the gas record

            return redirect()->route('gases.index')
                ->with('success', 'Data Gas Berhasil Dihapus...');
        } catch (\Exception $error) {
            return redirect()->route('gases.index')
                ->with('error', 'Data Gas Gagal Dihapus: ' . $error->getMessage());
        }
    }
}
