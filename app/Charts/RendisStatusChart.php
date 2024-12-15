<?php

namespace App\Charts;

use App\Models\Rendis;
use Spatie\Permission\Models\Role;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class RendisStatusChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build()
    {
        $s1 = Rendis::where('status', 'Active')->count();
        $s2= Rendis::where('status', 'Inactive')->count();
        $s3= Rendis::where('status', 'Cancelled')->count();

        return $this->chart->pieChart()
            ->setTitle('Grafik Renstra berdasarkan Status')
            ->addData([$s1, $s2, $s3])
            ->setLabels(['Aktif', 'Tidak Aktif', 'Dibatalkan']);
    }
}
