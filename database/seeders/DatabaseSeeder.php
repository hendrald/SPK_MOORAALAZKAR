<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;
use App\Models\Kriteria;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents; // Added standard import just in case

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Akun Kepala Sekolah (Admin)
        User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@alazkar.tk',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Contoh Akun Guru
        $userGuru = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.guru@alazkar.tk',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        Guru::create([
            'user_id' => $userGuru->id,
            'nip' => '198201012010011001',
            'nama_lengkap' => 'Budi Santoso, S.Pd.',
            'no_telp' => '081234567890'
        ]);

        // 3. Data Kriteria MOORA
        $kriterias = [
            ['kode_kriteria' => 'C1', 'nama_kriteria' => 'Pengalaman Mengajar & Kualifikasi', 'jenis' => 'Benefit', 'bobot' => 0.15],
            ['kode_kriteria' => 'C2', 'nama_kriteria' => 'Pemahaman Karakter & Relasi', 'jenis' => 'Benefit', 'bobot' => 0.10],
            ['kode_kriteria' => 'C3', 'nama_kriteria' => 'Kreativitas Metode Pembelajaran & APE', 'jenis' => 'Benefit', 'bobot' => 0.15],
            ['kode_kriteria' => 'C4', 'nama_kriteria' => 'Penguasaan Materi', 'jenis' => 'Benefit', 'bobot' => 0.10],
            ['kode_kriteria' => 'C5', 'nama_kriteria' => 'Tanggung Jawab Administrasi', 'jenis' => 'Benefit', 'bobot' => 0.10],
            ['kode_kriteria' => 'C6', 'nama_kriteria' => 'Problem Solving & Komunikasi Ortu', 'jenis' => 'Benefit', 'bobot' => 0.10],
            ['kode_kriteria' => 'C7', 'nama_kriteria' => 'Prestasi & Pengembangan Diri', 'jenis' => 'Benefit', 'bobot' => 0.05],
            ['kode_kriteria' => 'C8', 'nama_kriteria' => 'Kedisiplinan Waktu & Kinerja', 'jenis' => 'Benefit', 'bobot' => 0.10],
            ['kode_kriteria' => 'C9', 'nama_kriteria' => 'Tingkat Ketidakhadiran', 'jenis' => 'Cost', 'bobot' => 0.08],
            ['kode_kriteria' => 'C10', 'nama_kriteria' => 'Pelanggaran Tata Tertib & Keluhan', 'jenis' => 'Cost', 'bobot' => 0.07],
        ];

        foreach ($kriterias as $kriteria) {
            Kriteria::create($kriteria);
        }
    }
}
