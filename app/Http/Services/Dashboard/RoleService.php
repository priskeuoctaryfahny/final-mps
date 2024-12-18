<?php

namespace App\Http\Services\Dashboard;

use Exception;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class RoleService
{
    protected $tableName = 'roles';

    public function dataTable($request)
    {
        if ($request->ajax()) {
            try {
                $totalData = Role::count();
                $totalFiltered = $totalData;

                $limit = $request->length;
                $start = $request->start;

                $data = Role::latest()
                    ->skip($start)
                    ->take($limit)
                    ->get(['id', 'name']);

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->setOffset($start)
                    ->addColumn('action', function ($data) {
                        $actionBtn = '
                    <div class="text-center" width="10%">
                        <div class="btn-group">
                            <a href="' . route('roles.edit', $data->id) . '"  class="btn btn-sm btn-success">
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
                    ->rawColumns(['name', 'action'])
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

    public function getAttributesWithDetails()
    {
        // Get the columns from the table, excluding specific columns
        $columns = Schema::getColumnListing($this->tableName);
        $excludedColumns = ['id', 'created_at', 'updated_at', 'deleted_at', 'guard_name'];
        $filteredColumns = array_filter($columns, function ($column) use ($excludedColumns) {
            return !in_array($column, $excludedColumns);
        });

        // Define your labels and data types
        $labels = [
            'name' => 'Nama Peran',
        ];

        $dataTypes = [
            'name' => 'string',
        ];

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

    public function getColumns()
    {
        // Get the columns from the table, excluding specific columns
        $columns = Schema::getColumnListing($this->tableName);
        $excludedColumns = ['id', 'created_at', 'updated_at', 'deleted_at'];
        $filteredColumns = array_filter($columns, function ($column) use ($excludedColumns) {
            return !in_array($column, $excludedColumns);
        });

        return $filteredColumns;
    }

    public function getFirstBy(string $column, string $value, bool $relation = false)
    {
        return Role::where($column, $value)->firstOrFail();
    }

    public function create(array $data)
    {
        $role = Role::create($data);
        $role->assignRole($data['roles']);

        return $role;
    }

    public function update(array $data, string $id)
    {
        $role = Role::where('id', $id)->firstOrFail();
        $role->update($data);

        return $role;
    }

    public function forceDelete(string $id)
    {
        $getRole = $this->getFirstBy('id', $id);
        $getRole->forceDelete();

        return $getRole;
    }
}
