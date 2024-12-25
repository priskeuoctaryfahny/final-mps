<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name')->required();
            $table->timestamps();
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // ID Karyawan
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // Foreign key constraint
            $table->string('email')->unique(); // Email
            $table->string('name'); // Nama Lengkap
            $table->string('employee_identification_number')->unique(); // Nomor Induk Pegawai (NIP)
            $table->string('birth_place'); // Tempat Lahir
            $table->date('birth_date'); // Tanggal Lahir
            $table->date('position_start_date'); // Tanggal Mulai Jabatan
            $table->string('position')->nullable(); // Jabatan
            $table->enum('education_level', [
                'Tidak Sekolah',
                'SD',
                'SMP',
                'SMA',
                'Diploma 3',
                'Diploma 4 / Sarjana',
                'Magister',
                'Doktor',
                'Profesional'
            ])->nullable(); // Pendidikan Terakhir
            $table->string('education_institution')->nullable(); // Nama Perguruan Tinggi
            $table->string('major')->nullable(); // Jurusan
            $table->date('graduation_date')->nullable(); // Tanggal Lulus
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade'); // Foreign key constraint
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
        });

        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->date('date')->required();
            $table->time('time')->required();
            $table->string('location')->nullable();
            $table->string('description')->nullable();
            $table->enum('severity', ['Critical', 'Hampir Terjadi', 'Sedang', 'Rendah'])->required();
            $table->enum('incident_type', ['Gangguan', 'Psikolis', 'Penyakit', 'Cedera'])->required();
            $table->enum('injury_consequence', ['Tanpa Perawatan', 'Pertolongan Pertama', 'Perawatan Medis', 'Waktu Hilang'])->required();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->integer('days_of_absence')->nullable();
            $table->timestamps();
        });

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->date('date')->required();
            $table->string('description')->nullable();
            $table->enum('status', ['Positive', 'Warning', 'Critical'])->required();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('st_sp', function (Blueprint $table) {
            $table->id();
            $table->date('date')->required();
            $table->enum('status', ['Open', 'Close'])->required();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('st_sp');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('incidents');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('units');
    }
};
