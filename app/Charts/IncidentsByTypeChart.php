<?php

namespace App\Charts;

use App\Models\Backend\Incident;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class IncidentsByTypeChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build()
    {
        Carbon::setLocale('id');
        $now = Carbon::now();
        $lastYear = $now->subYear();

        // Retrieve incidents from the last 12 months
        $incidents = Incident::where('date', '>=', $lastYear)
            ->get()
            ->groupBy(function ($incident) {
                return Carbon::parse($incident->date)->translatedFormat('F'); // Group by month
            });

        // Prepare data for the chart
        $chart = $this->chart->barChart()
            ->setTitle('Insiden Berdasarkan Tipe per Bulan ' . Carbon::now()->format('Y'))
            ->setSubtitle('12 bulan terakhir');

        // Initialize arrays to hold the monthly counts for each type
        $monthlyTypeCounts = [
            'Hampir Terjadi' => [],
            'Gangguan' => [],
            'Psikologis' => [],
            'Penyakit' => [],
            'Cedera' => [],
        ];

        // Count incidents for each month and type
        foreach ($incidents as $month => $activity) {
            foreach ($activity as $incident) {
                $type = $incident->incident_type;
                if (isset($monthlyTypeCounts[$type][$month])) {
                    $monthlyTypeCounts[$type][$month]++;
                } else {
                    $monthlyTypeCounts[$type][$month] = 1;
                }
            }
        }

        // Prepare data for the chart
        foreach ($monthlyTypeCounts as $type => $counts) {
            $chart->addData($type, array_values($counts));
        }

        // Set the X-axis labels
        $chart->setXAxis(array_keys($monthlyTypeCounts['Hampir Terjadi']));

        return $chart;
    }
}
