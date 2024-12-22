<?php

namespace App\Models\Backend;

use App\Models\Backend\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'location',
        'description',
        'severity',
        'incident_type',
        'injury_consequence',
        'employee_id',
        'days_of_absence',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
