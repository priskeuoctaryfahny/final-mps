<?php

namespace App\Charts;

use App\Models\Rendis;
use Spatie\Permission\Models\Role;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class RendisRoleChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build()
    {
        $terlaksana = Rendis::where('is_terlaksana', 1)->count();
        $tidakTerlaksana= Rendis::where('is_terlaksana', 0)->count();

        return $this->chart->pieChart()
            ->setTitle('Grafik Renstra berdasarkan Progres')
            ->addData([$terlaksana, $tidakTerlaksana])
            ->setLabels(['Terlaksana', 'Tidak Terlaksana']);
    }
}
