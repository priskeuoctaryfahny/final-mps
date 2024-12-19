<?php

namespace App\Http\Services\Dashboard;

use Exception;
use Carbon\Carbon;
use App\Models\Activity;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class ActivityService
{
    protected $tableName = 'activities';
    public function dataTable($request)
    {
        if ($request->ajax()) {
            try {
                $totalData = Activity::count();
                $totalFiltered = $totalData;

                $limit = $request->length;
                $start = $request->start;

                if (empty($request->search['value'])) {
                    $data = Activity::latest()
                        ->with('user:id,name,email')
                        ->skip($start)
                        ->take($limit)
                        ->get(array_merge(['id'], $this->columns()));
                } else {
                    $data = Activity::filter($request->search['value'])
                        ->latest()
                        ->with('user:id,name,email')
                        ->skip($start)
                        ->take($limit)
                        ->get(array_merge(['id'], $this->columns()));

                    $totalFiltered = $data->count();
                }

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->setOffset($start)
                    ->editColumn('user_id', function ($data) {
                        return '<div>
                            <span class="badge bg-primary">' . $data->user->email . '</span>
                        </div>';
                    })->editColumn('created_at', function ($data) {
                        return '<div class="mx-1">
                            <span class="badge bg-info">' . Carbon::parse($data->created_at)->translatedFormat('d F Y H:i:s') . ' WIB</span>
                        </div>';
                    })
                    ->rawColumns($this->columns())
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
        return Activity::where($column, $value)->firstOrFail();
    }


    public function columnLabels()
    {
        return [
            'user_id' => 'Pengguna',
            'title' => 'Jenis Tindakan',
            'description' => 'Deskripsi',
            'ip_address' => 'Alamat IP',
            'created_at' => 'Tanggal Aktivitas',
        ];
    }

    public function columnExclude()
    {
        return ['id', 'key_id', 'user_agent', 'updated_at'];
    }

    public function columns()
    {
        return array_diff(Schema::getColumnListing((new Activity())->getTable()), $this->columnExclude());
    }

    public function columnTypes()
    {
        return [
            'user_id' => 'string',
            'title' => 'string',
            'description' => 'string',
            'ip_address' => 'string',
            'created_at' => 'date',
        ];
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
