<?php

namespace App\Models\Backend;

use App\Models\User;
use App\Models\Backend\StSp;
use App\Models\Backend\Unit;
use App\Models\Backend\Report;
use App\Models\Backend\Incident;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'name',
        'employee_identification_number',
        'birth_place',
        'birth_date',
        'position_start_date',
        'position',
        'education_level',
        'education_institution',
        'major',
        'graduation_date',
        'unit_id',
    ];

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'position_start_date' => 'date',
            'graduation_date' => 'date',
        ];
    }
}
