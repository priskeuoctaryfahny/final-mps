<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class TransactionsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithChunkReading
{
    protected $data;
    protected $selectedColumns;
    protected $columnLabels;

    public function __construct($data, $selectedColumns, $columnLabels)
    {
        $this->data = $data;
        $this->selectedColumns = $selectedColumns;
        $this->columnLabels = $columnLabels;
    }

    /**
     * Transforms the data collection by mapping each user to an array of selected column values.
     *
     * @return \Illuminate\Support\Collection A collection of arrays, each containing the 'No' index and the
     * selected column data for each user.
     */

    /******  9ffbeb76-4303-4850-ab1e-0b84b765f347  *******/
    public function collection()
    {
        return $this->data->map(function ($user, $index) {
            $data = [];
            $data['No'] = $index + 1;
            foreach ($this->selectedColumns as $column) {
                $data[$column] = $user->{$column};
            }
            return $data;
        });
    }

    public function headings(): array
    {
        $headings = [];
        $headings[] = 'No';
        foreach ($this->columnLabels as $column => $label) {
            if (in_array($column, $this->selectedColumns)) {
                $headings[] = $label;
            }
        }

        return $headings;
    }

    public function chunkSize(): int
    {
        return 1000; // Adjust the chunk size as needed
    }
}
