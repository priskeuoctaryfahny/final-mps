<?php

namespace App\Charts;

use App\Models\Backend\Incident;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class IncidentsByInjuryConsequenceChart
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
            ->setTitle('Insiden Berdasarkan Konsekuensi Cedera per Bulan ' . Carbon::now()->format('Y'))
            ->setSubtitle('12 bulan terakhir');

        // Initialize arrays to hold the monthly counts for each consequence
        $monthlyConsequenceCounts = [
            'Tanpa Perawatan' => [],
            'Pertolongan Pertama' => [],
            'Perawatan Medis' => [],
            'Waktu Hilang' => [],
        ];

        // Count incidents for each month and consequence
        foreach ($incidents as $month => $activity) {
            foreach ($activity as $incident) {
                $consequence = $incident->injury_consequence;
                if (isset($monthlyConsequenceCounts[$consequence][$month])) {
                    $monthlyConsequenceCounts[$consequence][$month]++;
                } else {
                    $monthlyConsequenceCounts[$consequence][$month] = 1;
                }
            }
        }

        // Prepare data for the chart
        foreach ($monthlyConsequenceCounts as $consequence => $counts) {
            $chart->addData($consequence, array_values($counts));
        }

        // Set the X-axis labels
        $chart->setXAxis(array_keys($monthlyConsequenceCounts['Tanpa Perawatan']));

        return $chart;
    }
}
