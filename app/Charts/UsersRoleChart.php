<?php

namespace App\Charts;

use Spatie\Permission\Models\Role;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class UsersRoleChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build()
    {
        $roles = Role::all(); // Retrieve all roles as Role model instances
        $totalUsers = [];

        // Count users for each role
        foreach ($roles as $role) {
            $totalUsers[] = $role->users()->count();
        }

        // Extract role names into an array for labels
        $roleNames = $roles->pluck('name')->all();

        $chart = $this->chart->barChart()
            ->setTitle(__('chart.title.all-users-role'))
            ->setSubtitle(__('chart.subtitle.all-users-role'));


        // Add data for each role
        foreach ($roleNames as $index => $roleName) {
            $chart->addData($roleName, [$totalUsers[$index]]);
        }
        $chart->setXAxis(['Keseluruhan Pengguna']);

        return $chart;
    }
}
