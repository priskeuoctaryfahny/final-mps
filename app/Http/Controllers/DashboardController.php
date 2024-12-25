<?php

namespace App\Http\Controllers;

use App\Models\Backend\StSp;
use App\Models\Backend\Unit;
use App\Models\Backend\Employee;
use App\Models\Backend\Incident;
use App\Charts\StSpPerMonthChart;
use App\Charts\IncidentsByTypeChart;
use App\Charts\IncidentsBySeverityChart;
use App\Charts\IncidentsByInjuryConsequenceChart;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index(StSpPerMonthChart $stSpChart, IncidentsBySeverityChart $severityChart, IncidentsByTypeChart $typeChart, IncidentsByInjuryConsequenceChart $consequenceChart)
    {
        $title = 'Dashboard';

        $employees = Employee::count();
        $units = Unit::count();
        $incidents = Incident::count();
        $stsps = StSp::count();

        // Build the charts
        $stSpChart = $stSpChart->build();
        $severityChart = $severityChart->build();
        $typeChart = $typeChart->build();
        $consequenceChart = $consequenceChart->build();

        return view('dashboard.index', compact('title', 'employees', 'units', 'incidents', 'stsps', 'stSpChart', 'severityChart', 'typeChart', 'consequenceChart'));
    }
}
