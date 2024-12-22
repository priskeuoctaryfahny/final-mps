<?php

namespace App\Models\Backend;

use App\Models\Backend\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StSp extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'status', 'employee_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
