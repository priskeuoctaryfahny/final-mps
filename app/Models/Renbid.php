<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renbid extends Model
{
    use HasFactory;

    protected $table = 'renstra_bidang'; // Specify the table name if it doesn't follow Laravel's naming convention

    protected $fillable = [
        'nama_bidang',
        'nama_kepala_bidang',
        'nama_agenda_renstra',
        'deskripsi_uraian_renstra',
        'disposisi_diteruskan',
        'tanggal_mulai',
        'tanggal_akhir',
        'status',
        'is_terlaksana',
    ];

    // Define any relationships here if needed
    public function renstraKadis()
    {
        return $this->belongsTo(RenstraKadis::class);
    }
}