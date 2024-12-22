<?php

namespace App\Models\Backend;

use App\Models\Backend\StSp;
use App\Models\Backend\Unit;
use App\Models\Backend\Report;
use App\Models\Backend\Incident;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'department', 'unit_id'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function stSp()
    {
        return $this->hasMany(StSp::class);
    }
}
