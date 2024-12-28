<?php

namespace App\Http\Services\Dashboard;

use Exception;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserService
{
    protected $tableName = 'users';
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
                        ->get(array_merge(['id'], $this->columns()));
                } else {
                    $data = User::filter($request->search['value'])
                        ->latest()
                        ->with('role:id,name')
                        ->skip($start)
                        ->take($limit)
                        ->get(array_merge(['id'], $this->columns()));

                    $totalFiltered = $data->count();
                }

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->setOffset($start)

                    ->addColumn('action', function ($data) {
                        $actionBtn = '
                    <div class="text-center" width="10%">
                        <div class="btn-group mx-1">

                        <button id="btn-edit" type="button"  class="btn btn-sm btn-warning" data-id="' . $data->id . '">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteData(this)" data-id="' . $data->id . '">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                ';

                        return $actionBtn;
                    })
                    ->rawColumns(array_merge($this->columns(), ['action']))
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

    public function forceDelete(string $id)
    {
        $getUser = $this->getFirstBy('id', $id);
        Storage::disk('public')->delete('images/' . $getUser->image);
        $getUser->forceDelete();

        return $getUser;
    }

    public function columnLabels()
    {
        return [
            'name' => 'Nama Lengkap',
            'email' => 'Alamat Email',
            'gender' => 'Jenis Kelamin',
            'whatsapp' => 'No Whatsapp',
            'date_of_birth' => 'Tanggal Lahir',
            'password' => 'Password',
        ];
    }

    public function columnExclude()
    {
        return ['id', 'password', 'google_id', 'remember_token', 'email_verified_at', 'google_token', 'picture', 'created_at', 'updated_at'];
    }

    public function columnTypes()
    {
        return [
            'name' => 'string',
            'email' => 'email',
            'gender' => 'option',
            'whatsapp' => 'string',
            'date_of_birth' => 'date',
            'password' => 'password',
        ];
    }

    public function columns()
    {
        return array_diff(Schema::getColumnListing((new User())->getTable()), $this->columnExclude());
    }


    public function getAttributesWithDetails()
    {
        // Get the columns from the table, excluding specific columns
        $columns = Schema::getColumnListing($this->tableName);
        $excludedColumns = $this->columnExclude();
        $filteredColumns = array_filter($columns, function ($column) use ($excludedColumns) {
            return !in_array($column, $excludedColumns);
        });

        // Define your labels and data types
        $labels = $this->columnLabels();

        $dataTypes = $this->columnTypes();

        // Create an array with keys, their corresponding labels, data types, and required status
        $attributesWithDetails = [];
        foreach ($filteredColumns as $column) {
            if (array_key_exists($column, $labels) && array_key_exists($column, $dataTypes)) {
                // Check if the column is nullable
                if (app()->make('db')->connection()->getDriverName() === 'sqlite') {
                    // Get column info for SQLite
                    $columnsInfo = app()->make('db')->select("PRAGMA table_info($this->tableName)");
                    $columnInfo = collect($columnsInfo)->firstWhere('name', $column);
                    $isNullable = $columnInfo->notnull == 0; // notnull is 0 if the column is nullable
                } else {
                    // Use information_schema for other databases
                    $result = app()->make('db')->select("SELECT is_nullable FROM information_schema.columns WHERE table_name = ? AND column_name = ?", [$this->tableName, $column]);

                    if (empty($result)) {
                        throw new Exception("No results found for the specified table and column.");
                    }

                    $isNullable = $result[0]->IS_NULLABLE === 'YES';
                }

                $attributesWithDetails[$column] = [
                    'label' => $labels[$column],
                    'type' => $dataTypes[$column],
                    'required' => !$isNullable, // Required if not nullable
                ];
            }
        }

        return $attributesWithDetails;
    }
}
