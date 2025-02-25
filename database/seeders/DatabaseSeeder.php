<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WebSetting;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'role-list', 'description' => 'Melihat data Peran'],
            ['name' => 'role-create', 'description' => 'Menambah data Peran'],
            ['name' => 'role-edit', 'description' => 'Mengubah data Peran'],
            ['name' => 'role-delete', 'description' => 'Menghapus data Peran'],
            ['name' => 'role-download', 'description' => 'Mengunduh data Peran'],
            ['name' => 'user-list', 'description' => 'Melihat data Pengguna'],
            ['name' => 'user-create', 'description' => 'Menambah data Pengguna'],
            ['name' => 'user-edit', 'description' => 'Mengubah data Pengguna'],
            ['name' => 'user-delete', 'description' => 'Menghapus data Pengguna'],
            ['name' => 'user-download', 'description' => 'Mengunduh data Pengguna'],
            ['name' => 'incident-list', 'description' => 'Melihat data Master Insiden'],
            ['name' => 'incident-create', 'description' => 'Menambah data Master Insiden'],
            ['name' => 'incident-edit', 'description' => 'Mengubah data Master Insiden'],
            ['name' => 'incident-delete', 'description' => 'Menghapus data Master Insiden'],
            ['name' => 'incident-download', 'description' => 'Mengunduh data Master Insiden'],
            ['name' => 'unit-list', 'description' => 'Melihat data Master Unit'],
            ['name' => 'unit-create', 'description' => 'Menambah data Master Unit'],
            ['name' => 'unit-edit', 'description' => 'Mengubah data Master Unit'],
            ['name' => 'unit-delete', 'description' => 'Menghapus data Master Unit'],
            ['name' => 'unit-download', 'description' => 'Mengunduh data Master Unit'],
            ['name' => 'employee-list', 'description' => 'Melihat data Pegawai'],
            ['name' => 'employee-create', 'description' => 'Menambah data Pegawai'],
            ['name' => 'employee-edit', 'description' => 'Mengubah data Pegawai'],
            ['name' => 'employee-delete', 'description' => 'Menghapus data Pegawai'],
            ['name' => 'employee-download', 'description' => 'Mengunduh data Pegawai'],
            ['name' => 'stsp-list', 'description' => 'Melihat data ST/SP'],
            ['name' => 'stsp-create', 'description' => 'Menambah data ST/SP'],
            ['name' => 'stsp-edit', 'description' => 'Mengubah data ST/SP'],
            ['name' => 'stsp-delete', 'description' => 'Menghapus data ST/SP'],
            ['name' => 'stsp-download', 'description' => 'Mengunduh data ST/SP'],
            ['name' => 'report-list', 'description' => 'Melihat data Laporan'],
            ['name' => 'report-create', 'description' => 'Menambah data Laporan'],
            ['name' => 'report-edit', 'description' => 'Mengubah data Laporan'],
            ['name' => 'report-delete', 'description' => 'Menghapus data Laporan'],
            ['name' => 'report-download', 'description' => 'Mengunduh data Laporan'],
            ['name' => 'activity-list', 'description' => 'Melihat data Aktivitas Pengguna'],
            ['name' => 'activity-download', 'description' => 'Mengunduh data Aktivitas Pengguna'],
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'description' => $permission['description']
            ]);
        }

        $user = User::create([
            'name' => 'Priskeu Octary Fahny',
            'email' => 'priskeuof02@gmail.com',
            'password' => bcrypt('12344321'),
            'email_verified_at' => now(),
        ]);

        $role = Role::create(['name' => 'Super Admin']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        WebSetting::create([
            'web_default_user_role' => 1
        ]);

        for ($i = 0; $i <= 10; $i++) {
            $faker = Faker::create();
            Role::create([
                'name' => $faker->name,
                'guard_name' => 'web',
            ]);
        }

        User::factory()->count(22)->create();
    }
}
