<?php

namespace App\Imports\Dashboard;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class UsersImport implements ToModel, WithChunkReading, WithBatchInserts, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        // Check if the required keys exist and are not empty
        if (empty($row['nama']) || empty($row['email'])) {
            return null; // Skip this row
        }

        // Check if the email already exists
        if (User::where('email', $row['email'])->exists()) {
            throw new \Exception('Alamat email "' . $row['email'] . '" sudah terdaftar ');
        }

        return new User([
            'name'     => $row['nama'],
            'email'    => $row['email'],
            'password' => Hash::make($row['email']),
            'gender'   => 'Male',
            'email_verified_at' => now(),
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
