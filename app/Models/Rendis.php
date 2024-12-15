<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rendis extends Model
{
    use HasFactory;

    protected $table = 'renstra_kadis'; // Specify the table name if it doesn't follow Laravel's naming convention

    protected $fillable = [
        'nomor_agenda',
        'nama_agenda_renstra',
        'deskripsi_uraian_renstra',
        'disposisi_diteruskan',
        'tanggal_mulai',
        'tanggal_akhir',
        'status',
        'is_terlaksana',
    ];

    // Define any relationships here if needed
    // For example, if you want to relate it to RenstraBidang
    public function renstraBidangs()
    {
        return $this->hasMany(RenstraBidang::class);
    }
}