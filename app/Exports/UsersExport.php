<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithChunkReading
{
    protected $users;
    protected $selectedColumns;
    protected $columnLabels;

    public function __construct($users, $selectedColumns, $columnLabels)
    {
        $this->users = $users;
        $this->selectedColumns = $selectedColumns;
        $this->columnLabels = $columnLabels;
    }

    public function collection()
    {
        return $this->users->map(function ($user, $index) {
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
