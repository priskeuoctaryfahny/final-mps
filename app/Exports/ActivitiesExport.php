<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ActivitiesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithChunkReading
{
    protected $activities;
    protected $selectedColumns;
    protected $attributes;

    public function __construct($activities, $attributes, $selectedColumns)
    {
        $this->activities = $activities;
        $this->attributes = $attributes;
        $this->selectedColumns = $selectedColumns;
    }

    public function collection()
    {
        return $this->activities->map(function ($acts, $index) {
            $data = [];
            $data['No'] = $index + 1;
            foreach ($this->attributes as $column => $details) {
                if (in_array($column, $this->selectedColumns)) {
                    if ($column === 'user_id') {
                        $data[$column] = $acts->user->email;
                    } elseif ($column === 'created_at') {
                        $data[$column] = $acts->created_at->translatedFormat('d F Y H:i:s');
                    } else {
                        $data[$column] = $acts->{$column};
                    }
                }
            }
            return $data;
        });
    }

    public function headings(): array
    {
        $headings = [];
        $headings[] = 'No';
        foreach ($this->attributes as $column => $details) {
            if (in_array($column, $this->selectedColumns)) {
                $headings[] = $details['label'];
            }
        }

        return $headings;
    }

    public function chunkSize(): int
    {
        return 1000; // Adjust the chunk size as needed
    }
}
