<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithChunkReading
{
    protected $users;
    protected $selectedColumns;

    public function __construct($users, $selectedColumns)
    {
        $this->users = $users;
        $this->selectedColumns = $selectedColumns;
    }

    public function collection()
    {
        return $this->users->map(function ($user, $index) {
            $data = [];
            $data['No'] = $index + 1;
            if (in_array('name', $this->selectedColumns)) {
                $data['name'] = $user->name;
            }
            if (in_array('email', $this->selectedColumns)) {
                $data['email'] = $user->email;
            }

            return $data;
        });
    }

    public function headings(): array
    {
        $headings = [];
        $headings[] = 'No';
        if (in_array('name', $this->selectedColumns)) {
            $headings[] = 'Nama Lengkap';
        }
        if (in_array('email', $this->selectedColumns)) {
            $headings[] = 'Alamat Email';
        }

        return $headings;
    }

    public function chunkSize(): int
    {
        return 1000; // Adjust the chunk size as needed
    }
}
