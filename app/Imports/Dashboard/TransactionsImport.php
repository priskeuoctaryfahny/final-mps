<?php

namespace App\Imports\Dashboard;

use Carbon\Carbon;
use App\Models\Dashboard\Gas;
use App\Models\Dashboard\Transaction;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class TransactionsImport implements ToModel, WithChunkReading, WithBatchInserts, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Transaction|null
     */
    public function model(array $row)
    {
        // Check if the required keys exist and are not empty
        if (empty($row['type']) || empty($row['gas_id']) || empty($row['qty']) || empty($row['amount']) || empty($row['transaction_date'])) {
            return null; // Skip this row
        }

        // Validate the type
        if (!in_array($row['type'], ['in', 'out'])) {
            throw new \Exception('Invalid transaction type: "' . $row['type'] . '"');
        }

        // Validate gas_id (you might want to check if the gas_id exists in the gases table)
        if (!Gas::find($row['gas_id'])) {
            throw new \Exception('Gas ID "' . $row['gas_id'] . '" does not exist');
        }

        return new Transaction([
            'type'              => $row['type'],
            'gas_id'           => $row['gas_id'],
            'qty'               => $row['qty'],
            'amount'            => $row['amount'],
            'optional_amount'   => $row['optional_amount'] ?? 0,
            'total_amount'      => $row['total_amount'],
            'description'       => $row['description'] ?? null,
            'reference'         => $row['reference'] ?? null,
            'transaction_date'  => Carbon::parse($row['transaction_date']), // Ensure the date is parsed correctly
            'attachment'        => $row['attachment'] ?? null,
            'status'            => $row['status'] ?? 'completed', // Default to 'completed' if not provided
            'created_by'        => $row['created_by'] ?? null, // Assuming created_by is optional
            'updated_by'        => $row['updated_by'] ?? null, // Assuming updated_by is optional
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
