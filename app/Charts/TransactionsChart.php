<?php

namespace App\Charts;

use App\Models\Dashboard\Transaction;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class TransactionsChart
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

        // Retrieve transactions from the last 12 months
        $transactions = Transaction::where('transaction_date', '>=', $lastYear)
            ->with('gas') // Assuming you have a relationship defined in the Transaction model
            ->get()
            ->groupBy(function ($transaction) {
                return Carbon::parse($transaction->transaction_date)->format('F'); // Group by month
            });

        // Prepare data for the chart
        $chart = $this->chart->barChart()
            ->setTitle('Grafik Inventori Gas')
            ->setSubtitle('12 bulan terakhir');

        // Initialize an array to hold the monthly activity counts for each gas type
        $monthlyActivityCounts = [];
        $gasTypes = [];

        // Count activities for each month and gas type
        foreach ($transactions as $month => $activity) {
            foreach ($activity as $transaction) {
                $gasType = $transaction->gas->name; // Assuming 'name' is the field for gas type
                if (!isset($monthlyActivityCounts[$month][$gasType])) {
                    $monthlyActivityCounts[$month][$gasType] = 0;
                }
                $monthlyActivityCounts[$month][$gasType]++;
                $gasTypes[$gasType] = true; // Keep track of gas types
            }
        }

        // Prepare data for the chart
        foreach ($gasTypes as $gasType => $value) {
            $data = [];
            foreach (array_keys($monthlyActivityCounts) as $month) {
                $data[] = $monthlyActivityCounts[$month][$gasType] ?? 0; // Default to 0 if no transactions
            }
            $chart->addData($gasType, $data);
        }

        // Set the X-axis labels
        $chart->setXAxis(array_keys($monthlyActivityCounts));

        return $chart;
    }
}
