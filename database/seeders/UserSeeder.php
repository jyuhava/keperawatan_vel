<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@nursecare.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Dosen (Teacher) user
        User::create([
            'name' => 'Dr. Siti Nurhaliza',
            'email' => 'dosen@nursecare.com',
            'password' => Hash::make('dosen123'),
            'role' => 'dosen',
            'phone' => '081234567890',
            'address' => 'Jl. Pendidikan No. 123, Jakarta',
            'email_verified_at' => now(),
        ]);

        // Create additional teachers
        User::create([
            'name' => 'Ns. Ahmad Wijaya, S.Kep',
            'email' => 'ahmad.wijaya@nursecare.com',
            'password' => Hash::make('dosen123'),
            'role' => 'dosen',
            'phone' => '081987654321',
            'address' => 'Jl. Kesehatan No. 456, Jakarta',
            'email_verified_at' => now(),
        ]);

        // Create Mahasiswa (Student) users
        User::create([
            'name' => 'Andi Pratama',
            'email' => 'andi.pratama@student.nursecare.com',
            'password' => Hash::make('student123'),
            'role' => 'mahasiswa',
            'student_id' => 'NUR2024001',
            'phone' => '082123456789',
            'address' => 'Jl. Mahasiswa No. 789, Jakarta',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Bella Safitri',
            'email' => 'bella.safitri@student.nursecare.com',
            'password' => Hash::make('student123'),
            'role' => 'mahasiswa',
            'student_id' => 'NUR2024002',
            'phone' => '082987654321',
            'address' => 'Jl. Pelajar No. 012, Jakarta',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Citra Dewi',
            'email' => 'citra.dewi@student.nursecare.com',
            'password' => Hash::make('student123'),
            'role' => 'mahasiswa',
            'student_id' => 'NUR2024003',
            'phone' => '083123456789',
            'address' => 'Jl. Kampus No. 345, Jakarta',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Dedi Kurniawan',
            'email' => 'dedi.kurniawan@student.nursecare.com',
            'password' => Hash::make('student123'),
            'role' => 'mahasiswa',
            'student_id' => 'NUR2024004',
            'phone' => '083987654321',
            'address' => 'Jl. Universitas No. 678, Jakarta',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Eka Putri',
            'email' => 'eka.putri@student.nursecare.com',
            'password' => Hash::make('student123'),
            'role' => 'mahasiswa',
            'student_id' => 'NUR2024005',
            'phone' => '084123456789',
            'address' => 'Jl. Akademik No. 901, Jakarta',
            'email_verified_at' => now(),
        ]);
    }
}
