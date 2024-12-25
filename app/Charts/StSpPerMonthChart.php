<?php

namespace App\Charts;

use App\Models\Backend\StSp;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class StSpPerMonthChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build()
    {
        // Get the current date and the date from 12 months ago
        Carbon::setLocale('id');
        $now = Carbon::now();
        $lastYear = $now->subYear();

        // Retrieve ST/SP records from the last 12 months
        $stsps = StSp::where('date', '>=', $lastYear)
            ->get()
            ->groupBy(function ($stsp) {
                return Carbon::parse($stsp->date)->translatedFormat('F'); // Group by month
            });

        // Prepare data for the chart
        $chart = $this->chart->barChart()
            ->setTitle('Statistik ST/SP per Bulan ' . Carbon::now()->format('Y'))
            ->setSubtitle('12 bulan terakhir');

        // Initialize arrays to hold the monthly counts for each status
        $monthlyOpenCounts = [];
        $monthlyCloseCounts = [];

        // Count activities for each month and status
        foreach ($stsps as $month => $activity) {
            foreach ($activity as $stsp) {
                if ($stsp->status === 'Open') {
                    if (!isset($monthlyOpenCounts[$month])) {
                        $monthlyOpenCounts[$month] = 0;
                    }
                    $monthlyOpenCounts[$month]++;
                } elseif ($stsp->status === 'Close') {
                    if (!isset($monthlyCloseCounts[$month])) {
                        $monthlyCloseCounts[$month] = 0;
                    }
                    $monthlyCloseCounts[$month]++;
                }
            }
        }

        // Prepare data for the chart
        $chart->addData('Open', array_values($monthlyOpenCounts));
        $chart->addData('Close', array_values($monthlyCloseCounts));

        // Set the X-axis labels
        $chart->setXAxis(array_keys($monthlyOpenCounts));

        return $chart;
    }
}
