<?php

namespace App\Services\Dashboard;

use Illuminate\Support\Facades\Schema;

class RoleService
{
    protected $tableName = 'roles';

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
                    $isNullable = app()->make('db')->select("SELECT is_nullable FROM information_schema.columns WHERE table_name = ? AND column_name = ?", [$this->tableName, $column])[0]->is_nullable === 'YES';
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
