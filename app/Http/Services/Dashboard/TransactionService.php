<?php

namespace App\Http\Services\Dashboard;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Dashboard\Gas;
use Spatie\Permission\Models\Role;
use App\Models\Dashboard\Transaction;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Container\Attributes\Log;
use Yajra\DataTables\Facades\DataTables;

class TransactionService
{
    protected $tableName = 'transactions';
    public function dataTable($request, $id)
    {
        if ($request->ajax()) {
            try {
                // Count total transactions for the specific gas
                $totalData = Transaction::where('gas_id', $id)->count();
                $totalFiltered = $totalData;

                $limit = $request->length;
                $start = $request->start;

                // Base query for transactions
                $query = Transaction::where('gas_id', $id)
                    ->with(['gas:id,name', 'created_by:id,name', 'updated_by:id,name'])
                    ->latest();

                // Apply search filter if present
                if (!empty($request->search['value'])) {
                    $query->filter($request->search['value']);
                }

                // Get the filtered data
                $data = $query->skip($start)->take($limit)->get(array_merge(['id'], $this->columns()));

                // Update totalFiltered if a search was performed
                if (!empty($request->search['value'])) {
                    $totalFiltered = $query->count();
                }

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->setOffset($start)
                    ->editColumn('type', function ($data) {
                        return $data->type == 'in' ? 'Masuk' : 'Keluar';
                    })
                    ->editColumn('gas_id', function ($data) {
                        return '<span class="badge bg-success">' . $data->gas->name . '</span>';
                    })
                    ->editColumn('total_amount', function ($data) {
                        return '<div class="text-center">
                            <span class="badge bg-primary"> Rp ' . number_format($data->total_amount, 0, ",", ".") .  '</span>
                        </div>';
                    })
                    ->editColumn('transaction_date', function ($data) {
                        return '<div class="text-center">
                            <span class="badge bg-info">' . Carbon::parse($data->transaction_date)->translatedFormat('d F Y') . '</span>
                        </div>';
                    })
                    ->editColumn('created_by', function ($data) {
                        return '<div class="text-center">
                            <span class="badge bg-warning">' . optional(User::where('id', $data->created_by)->first())->name . '</span>
                        </div>';
                    })
                    ->editColumn('updated_by', function ($data) {
                        return '<div class="text-center">
                            <span class="badge bg-warning">' . optional(User::where('id', $data->updated_by)->first())->name . '</span>
                        </div>';
                    })
                    ->editColumn('status', function ($data) {
                        $statusClasses = [
                            'pending' => 'bg-warning',
                            'completed' => 'bg-success',
                            'canceled' => 'bg-danger',
                        ];
                        return '<div class="text-center">
                            <span class="badge ' . $statusClasses[$data->status] . '">' . ucfirst($data->status) . '</span>
                        </div>';
                    })
                    ->addColumn('action', function ($data) {
                        return '
                        <div class="text-center" width="10%">
                            <div class="btn-group mx-1">
                                <a href="' . route('transactions.edit.in', $data->id) . '" class="btn btn-sm btn-success">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteData(this)" data-id="' . $data->id . '">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>';
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


    public function getFirstBy(string $column, string $value, bool $relation = false)
    {
        return Transaction::where($column, $value)->firstOrFail();
    }

    public function create(array $data)
    {
        $gas = Gas::findOrFail($data['gas_id']);
        $data['gas_id'] = $gas->id;
        $transaction = Transaction::create($data);

        return $transaction;
    }

    public function update(array $data, string $id)
    {
        $transaction = Transaction::where('id', $id)->firstOrFail();
        $transaction->update($data);

        return $transaction;
    }

    public function forceDelete(string $id)
    {
        $getTransaction = $this->getFirstBy('id', $id);
        Storage::disk('public')->delete('images/' . $getTransaction->image);
        $getTransaction->forceDelete();

        return $getTransaction;
    }

    public function columnLabels()
    {
        return [
            'type' => 'Tipe Data',
            'gas_id' => 'Tipe Gas',
            'qty' => 'Unit Gas',
            'total_amount' => 'Biaya Keseluruhan',
            'transaction_date' => 'Tgl Transaksi',
            'status' => 'Status',
            'created_by' => 'Dibuat Oleh',
            'updated_by' => 'Diperbarui Oleh',
        ];
    }

    public function columnExclude()
    {
        return [
            'id',
            'amount',
            'description',
            'attachment',
            'reference',
            'optional_amount',
            'created_at',
            'updated_at',
        ];
    }

    public function columnTypes()
    {
        return [
            'type' => 'string',
            'gas_id' => 'option',
            'qty' => 'integer',
            'total_amount' => 'money',
            'transaction_date' => 'date',
            'status' => 'option',
            'created_by' => 'string',
            'updated_by' => 'string',
        ];
    }

    public function columns()
    {
        return array_diff(Schema::getColumnListing((new Transaction())->getTable()), $this->columnExclude());
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
