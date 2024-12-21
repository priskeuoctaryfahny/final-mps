<?php

namespace App\Charts;

use App\Models\User;
use Spatie\Permission\Models\Role;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class UsersActivityChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build()
    {
        $users = User::latest()->limit(100)->get(); // Retrieve all roles as Role model instances

        $chart = $this->chart->barChart()
            ->setTitle('Grafik Aktivitas Pengguna')
            ->setSubtitle('Keseluruhan aktivitas pengguna.');

        foreach ($users as $user) {
            $chart->addData($user->name, [$user->activities()->count()]);
        }

        $chart->setXAxis(['Keseluruhan Aktivitas Pengguna']);

        return $chart;
    }
}
