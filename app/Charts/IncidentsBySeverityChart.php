<?php

namespace App\Charts;

use App\Models\Backend\Incident;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class IncidentsBySeverityChart
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
            ->setTitle('Insiden Berdasarkan Severity per Bulan ' . Carbon::now()->format('Y'))
            ->setSubtitle('12 bulan terakhir');

        // Initialize arrays to hold the monthly counts for each severity
        $monthlySeverityCounts = [
            'Critical' => [],
            'Hampir Terjadi' => [],
            'Sedang' => [],
            'Rendah' => [],
        ];

        // Count incidents for each month and severity
        foreach ($incidents as $month => $activity) {
            foreach ($activity as $incident) {
                $severity = $incident->severity;
                if (isset($monthlySeverityCounts[$severity][$month])) {
                    $monthlySeverityCounts[$severity][$month]++;
                } else {
                    $monthlySeverityCounts[$severity][$month] = 1;
                }
            }
        }

        // Prepare data for the chart
        foreach ($monthlySeverityCounts as $severity => $counts) {
            $chart->addData($severity, array_values($counts));
        }

        // Set the X-axis labels
        $chart->setXAxis(array_keys($monthlySeverityCounts['Critical']));

        return $chart;
    }
}
