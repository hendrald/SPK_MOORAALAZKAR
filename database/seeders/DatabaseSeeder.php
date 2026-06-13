<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;
use App\Models\Kriteria;
use App\Models\Evaluasi;
use App\Models\EvaluasiDetail;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Akun Admin (2 Penilai)
        $admin1 = User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@tkalazkar.sch.id',
            'password' => Hash::make('AdminAzkar2026!'),
            'role' => 'admin',
        ]);

        $admin2 = User::create([
            'name' => 'Tim Penilai Kedua',
            'email' => 'penilai@tkalazkar.sch.id',
            'password' => Hash::make('AdminAzkar2026!'),
            'role' => 'admin',
        ]);

        // 2. Data Kriteria MOORA (30 Kriteria - Skala Persentase 1 - 100)
        $kriterias = [
            ['kode_kriteria' => 'C1', 'nama_kriteria' => 'Pengalaman Mengajar & Kualifikasi', 'jenis' => 'Benefit', 'bobot' => 3.0],
            ['kode_kriteria' => 'C2', 'nama_kriteria' => 'Pemahaman Karakter & Relasi dengan Anak', 'jenis' => 'Benefit', 'bobot' => 6.0],
            ['kode_kriteria' => 'C3', 'nama_kriteria' => 'Kreativitas Metode Pembelajaran & APE', 'jenis' => 'Benefit', 'bobot' => 6.0],
            ['kode_kriteria' => 'C4', 'nama_kriteria' => 'Penguasaan Materi (Agama & Calistung Dasar)', 'jenis' => 'Benefit', 'bobot' => 7.0],
            ['kode_kriteria' => 'C5', 'nama_kriteria' => 'Kelengkapan & Ketepatan Administrasi (RPPH, dll)', 'jenis' => 'Benefit', 'bobot' => 6.0],
            ['kode_kriteria' => 'C6', 'nama_kriteria' => 'Problem Solving & Komunikasi Orang Tua', 'jenis' => 'Benefit', 'bobot' => 6.0],
            ['kode_kriteria' => 'C7', 'nama_kriteria' => 'Prestasi & Pengembangan Diri', 'jenis' => 'Benefit', 'bobot' => 4.0],
            ['kode_kriteria' => 'C8', 'nama_kriteria' => 'Kedisiplinan Waktu & Kinerja', 'jenis' => 'Benefit', 'bobot' => 5.0],
            ['kode_kriteria' => 'C9', 'nama_kriteria' => 'Penguasaan Bahasa Asing', 'jenis' => 'Benefit', 'bobot' => 5.0],
            ['kode_kriteria' => 'C10', 'nama_kriteria' => 'Kepribadian / Personality Guru', 'jenis' => 'Benefit', 'bobot' => 5.0],
            ['kode_kriteria' => 'C11', 'nama_kriteria' => 'Kebersihan dan Kerapihan Lingkungan Kelas', 'jenis' => 'Benefit', 'bobot' => 2.0],
            ['kode_kriteria' => 'C12', 'nama_kriteria' => 'Keaktifan dalam Komunikasi Internal Sekolah', 'jenis' => 'Benefit', 'bobot' => 2.0],
            ['kode_kriteria' => 'C13', 'nama_kriteria' => 'Kemampuan Manajemen Kelas', 'jenis' => 'Benefit', 'bobot' => 3.0],
            ['kode_kriteria' => 'C14', 'nama_kriteria' => 'Kemampuan Menggunakan Teknologi Pembelajaran', 'jenis' => 'Benefit', 'bobot' => 3.0],
            ['kode_kriteria' => 'C15', 'nama_kriteria' => 'Inovasi dalam Pembelajaran', 'jenis' => 'Benefit', 'bobot' => 3.0],
            ['kode_kriteria' => 'C16', 'nama_kriteria' => 'Kemampuan Evaluasi dan Penilaian Anak', 'jenis' => 'Benefit', 'bobot' => 3.0],
            ['kode_kriteria' => 'C17', 'nama_kriteria' => 'Kerapihan dan Kesiapan Mengajar', 'jenis' => 'Benefit', 'bobot' => 2.0],
            ['kode_kriteria' => 'C18', 'nama_kriteria' => 'Empati dan Kesabaran terhadap Anak', 'jenis' => 'Benefit', 'bobot' => 3.0],
            ['kode_kriteria' => 'C19', 'nama_kriteria' => 'Kerja Sama dengan Sesama Guru', 'jenis' => 'Benefit', 'bobot' => 2.0],
            ['kode_kriteria' => 'C20', 'nama_kriteria' => 'Keaktifan & Partisipasi Kegiatan Sekolah', 'jenis' => 'Benefit', 'bobot' => 2.0],
            ['kode_kriteria' => 'C21', 'nama_kriteria' => 'Kemampuan Storytelling / Mendongeng', 'jenis' => 'Benefit', 'bobot' => 2.0],
            ['kode_kriteria' => 'C22', 'nama_kriteria' => 'Kemampuan Mengelola Emosi', 'jenis' => 'Benefit', 'bobot' => 2.0],
            ['kode_kriteria' => 'C23', 'nama_kriteria' => 'Tingkat Ketidakhadiran', 'jenis' => 'Cost', 'bobot' => 3.0],
            ['kode_kriteria' => 'C24', 'nama_kriteria' => 'Pelanggaran Tata Tertib & Keluhan', 'jenis' => 'Cost', 'bobot' => 3.0],
            ['kode_kriteria' => 'C25', 'nama_kriteria' => 'Tingkat Keterlambatan Datang', 'jenis' => 'Cost', 'bobot' => 2.0],
            ['kode_kriteria' => 'C26', 'nama_kriteria' => 'Kesulitan Menangani Perilaku Anak (Tantrum)', 'jenis' => 'Cost', 'bobot' => 2.0],
            ['kode_kriteria' => 'C27', 'nama_kriteria' => 'Kelalaian dalam Pengawasan & Keamanan Bermain', 'jenis' => 'Cost', 'bobot' => 2.0],
            ['kode_kriteria' => 'C28', 'nama_kriteria' => 'Keluhan dari Orang Tua (Frekuensi)', 'jenis' => 'Cost', 'bobot' => 2.0],
            ['kode_kriteria' => 'C29', 'nama_kriteria' => 'Ketidaksesuaian Metode dengan Kurikulum', 'jenis' => 'Cost', 'bobot' => 2.0],
            ['kode_kriteria' => 'C30', 'nama_kriteria' => 'Tingkat Burnout / Kelelahan Kerja', 'jenis' => 'Cost', 'bobot' => 2.0],
        ];

        $kriteriaIds = [];
        foreach ($kriterias as $kriteria) {
            $k = Kriteria::create($kriteria);
            $kriteriaIds[] = $k->id;
        }

        // 3. Data 12 Guru
        $gurus = [
            'Septi Asmara Komalasari', 'Dewi Kusumawati', 'Nyai Asmayati', 'Munhanih',
            'Tika Febriana', 'Zakira Zahra Aulia', 'Melani', 'Farida Nur Oktarianti',
            'Azka Azkiya', 'Ragita Cahyantika', 'Rio Susan Hertanto', 'Iyo Sri Wardhana'
        ];

        $nipCounter = 198001012010011000;

        foreach ($gurus as $index => $nama) {
            $nipCounter++;
            $namaDepan = strtolower(explode(' ', trim($nama))[0]);

            $userGuru = User::create([
                'name' => $nama,
                'email' => $namaDepan . '@tkalazkar.sch.id',
                'password' => Hash::make('AlazkarHebat!'),
                'role' => 'guru',
            ]);

            $guru = Guru::create([
                'user_id' => $userGuru->id,
                'nip' => (string) $nipCounter,
                'nama_lengkap' => $nama,
                'no_telp' => '0812' . rand(10000000, 99999999)
            ]);

            // Skenario 1: Evaluasi Semester Ganjil 2025/2026 oleh Penilai 1 (Kepala Sekolah)
            $evaluasiGanjil1 = Evaluasi::create([
                'guru_id' => $guru->id,
                'penilai_id' => $admin1->id,
                'periode' => '2025/2026 - Ganjil',
                'catatan' => 'Evaluasi Semester Ganjil oleh Kepala Sekolah'
            ]);

            // Skenario 2: Evaluasi Semester Ganjil 2025/2026 oleh Penilai 2 (Tim Penilai Kedua)
            $evaluasiGanjil2 = Evaluasi::create([
                'guru_id' => $guru->id,
                'penilai_id' => $admin2->id,
                'periode' => '2025/2026 - Ganjil',
                'catatan' => 'Evaluasi Semester Ganjil oleh Tim Penilai Kedua'
            ]);

            // Skenario 3: Evaluasi Semester Genap 2025/2026 oleh Penilai 1 (Kepala Sekolah)
            $evaluasiGenap1 = Evaluasi::create([
                'guru_id' => $guru->id,
                'penilai_id' => $admin1->id,
                'periode' => '2025/2026 - Genap',
                'catatan' => 'Evaluasi Semester Genap oleh Kepala Sekolah'
            ]);

            // Isi nilai detail
            foreach ($kriteriaIds as $k_idx => $k_id) {
                $jenis = $kriterias[$k_idx]['jenis'];
                
                // Menentukan nilai dasar guru
                if ($index === 0) {
                    // Septi: Bagus
                    $val1 = ($jenis == 'Benefit') ? rand(80, 95) : rand(10, 30);
                    $val2 = ($jenis == 'Benefit') ? rand(85, 95) : rand(10, 20);
                    $val3 = ($jenis == 'Benefit') ? rand(88, 98) : rand(10, 25);
                } elseif ($index === 11) {
                    // Iyo: Kurang
                    $val1 = ($jenis == 'Benefit') ? rand(50, 70) : rand(60, 80);
                    $val2 = ($jenis == 'Benefit') ? rand(55, 65) : rand(50, 70);
                    $val3 = ($jenis == 'Benefit') ? rand(50, 68) : rand(55, 75);
                } else {
                    // Guru lainnya: Sedang
                    $val1 = rand(70, 85);
                    $val2 = rand(70, 85);
                    $val3 = rand(72, 87);
                }

                // Ganjil Penilai 1
                EvaluasiDetail::create([
                    'evaluasi_id' => $evaluasiGanjil1->id,
                    'kriteria_id' => $k_id,
                    'nilai' => $val1
                ]);

                // Ganjil Penilai 2
                EvaluasiDetail::create([
                    'evaluasi_id' => $evaluasiGanjil2->id,
                    'kriteria_id' => $k_id,
                    'nilai' => $val2
                ]);

                // Genap Penilai 1
                EvaluasiDetail::create([
                    'evaluasi_id' => $evaluasiGenap1->id,
                    'kriteria_id' => $k_id,
                    'nilai' => $val3
                ]);
            }
        }
    }
}

