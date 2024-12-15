<?php

namespace App\Http\Services\Dashboard;

use App\Models\Rendis;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class RendisService
{
    public function dataTable($request)
    {
        if ($request->ajax()) {
            try {
                $totalData = Rendis::count();
                $totalFiltered = $totalData;

                $limit = $request->length;
                $start = $request->start;

                if (empty($request->search['value'])) {
                    $data = Rendis::latest()
                        ->skip($start)
                        ->take($limit)
                        ->get();
                } else {
                    $data = User::filter($request->search['value'])
                        ->latest()
                        ->skip($start)
                        ->take($limit)
                        ->get();

                    $totalFiltered = $data->count();
                }

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->setOffset($start)
                    ->editColumn('nomor_agenda', function ($data) {
                        return $data->nomor_agenda;
                    })
                    ->editColumn('nama_agenda_renstra', function ($data) {
                        return '<div>
                        <span class="badge bg-secondary">' . $data->nama_agenda_renstra . '</span>
                    </div>';
                    })
                    ->addColumn('action', function ($data) {
                        $actionBtn = '
                    <div class="text-center" width="10%">
                        <div class="btn-group">
                            <a href="' . route('rendis.show', $data->id) . '"  class="btn btn-sm btn-secondary">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="' . route('users.edit', $data->id) . '"  class="btn btn-sm btn-success">
                                <i class="fas fa-edit"></i>
                            </a>

                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteData(this)" data-id="' . $data->id . '">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                ';

                        return $actionBtn;
                    })
                    ->rawColumns(['nomor_agenda', 'nama_agenda_renstra', 'action'])
                    ->with([
                        'recordsTotal' => $totalData,
                        'recordsFiltered' => $totalFiltered,
                        'start' => $start
                    ])
                    ->make();
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }


    public function getFirstBy(string $column, string $value, bool $relation = false)
    {
        return Rendis::where($column, $value)->firstOrFail();
    }

    public function create(array $data)
    {
        $Rendis = Rendis::create($data);
        $Rendis->assignRole($data['roles']);

        return $Rendis;
    }

    public function update(array $data, string $id)
    {
        $Rendis = Rendis::where('id', $id)->firstOrFail();
        $Rendis->update($data);
        $Rendis->assignRole($data['roles']);

        return $Rendis;
    }

    public function delete(string $id)
    {
        $getRendis = $this->getFirstBy('id', $id);
        $getRendis->delete(); // soft delete

        return $getRendis;
    }

    public function restore(string $id)
    {
        $getRendis = $this->getFirstBy('id', $id);
        $getRendis->restore();

        return $getRendis;
    }

    public function forceDelete(string $id)
    {
        $getRendis = $this->getFirstBy('id', $id);
        Storage::disk('public')->delete('images/' . $getRendis->image);
        $getRendis->forceDelete();

        return $getRendis;
    }
}
