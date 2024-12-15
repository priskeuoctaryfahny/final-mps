<?php

namespace Database\Factories;

use App\Models\Rendis;
use Illuminate\Database\Eloquent\Factories\Factory;

class RendisFactory extends Factory
{
    protected $model = Rendis::class;

    public function definition()
    {
        return [
            'nomor_agenda' => $this->faker->unique()->numerify('AGD-#####'),
            'nama_agenda_renstra' => $this->faker->sentence(3),
            'deskripsi_uraian_renstra' => $this->faker->paragraph(),
            'disposisi_diteruskan' => $this->faker->randomElement(['Field P2P', 'Field Kesmas', 'Field Lainnya']),
            'tanggal_mulai' => $this->faker->date(),
            'tanggal_akhir' => $this->faker->date(),
            'status' => $this->faker->randomElement(['Active', 'Inactive','Cancelled']),
            'is_terlaksana' => $this->faker->boolean(),
        ];
    }
}