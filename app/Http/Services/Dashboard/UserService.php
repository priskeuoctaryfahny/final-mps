<?php

namespace App\Http\Services\Dashboard;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserService
{
    public function dataTable($request)
    {
        if ($request->ajax()) {
            try {
                $totalData = User::count();
                $totalFiltered = $totalData;

                $limit = $request->length;
                $start = $request->start;

                if (empty($request->search['value'])) {
                    $data = User::latest()
                        ->with('role:id,name')
                        ->skip($start)
                        ->take($limit)
                        ->get(['id', 'name', 'email']);
                } else {
                    $data = User::filter($request->search['value'])
                        ->latest()
                        ->with('role:id,name')
                        ->skip($start)
                        ->take($limit)
                        ->get(['id', 'name', 'email']);

                    $totalFiltered = $data->count();
                }

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->setOffset($start)
                    ->editColumn('name', function ($data) {
                        return $data->name;
                    })
                    ->editColumn('email', function ($data) {
                        return '<div>
                        <span class="badge bg-secondary">' . $data->email . '</span>
                    </div>';
                    })
                    ->addColumn('action', function ($data) {
                        $actionBtn = '
                    <div class="text-center" width="10%">
                        <div class="btn-group">
                            <a href="' . route('users.show', $data->id) . '"  class="btn btn-sm btn-secondary">
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
                    ->rawColumns(['name', 'email', 'action'])
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

    public function getRole()
    {
        return Role::latest()->get(['id', 'name']);
    }

    public function getFirstBy(string $column, string $value, bool $relation = false)
    {
        return User::where($column, $value)->firstOrFail();
    }

    public function create(array $data)
    {
        $user = User::create($data);
        $user->assignRole($data['roles']);

        return $user;
    }

    public function update(array $data, string $id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $user->update($data);
        $user->assignRole($data['roles']);

        return $user;
    }

    public function delete(string $id)
    {
        $getUser = $this->getFirstBy('id', $id);
        $getUser->delete(); // soft delete

        return $getUser;
    }

    public function restore(string $id)
    {
        $getUser = $this->getFirstBy('id', $id);
        $getUser->restore();

        return $getUser;
    }

    public function forceDelete(string $id)
    {
        $getUser = $this->getFirstBy('id', $id);
        Storage::disk('public')->delete('images/' . $getUser->image);
        $getUser->forceDelete();

        return $getUser;
    }
}
