<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;
use App\Models\Kriteria;
use App\Models\Evaluasi;
use App\Models\EvaluasiDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Akun Kepala Sekolah (Admin)
        User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@tkalazkar.sch.id',
            'password' => Hash::make('AdminAzkar2026!'),
            'role' => 'admin',
        ]);

        // 2. Data Kriteria MOORA (30 Kriteria Baru)
        $kriterias = [
            ['kode_kriteria' => 'C1', 'nama_kriteria' => 'Pengalaman Mengajar & Kualifikasi', 'jenis' => 'Benefit', 'bobot' => 0.03],
            ['kode_kriteria' => 'C2', 'nama_kriteria' => 'Pemahaman Karakter & Relasi dengan Anak', 'jenis' => 'Benefit', 'bobot' => 0.06],
            ['kode_kriteria' => 'C3', 'nama_kriteria' => 'Kreativitas Metode Pembelajaran & APE', 'jenis' => 'Benefit', 'bobot' => 0.06],
            ['kode_kriteria' => 'C4', 'nama_kriteria' => 'Penguasaan Materi (Agama & Calistung Dasar)', 'jenis' => 'Benefit', 'bobot' => 0.07],
            ['kode_kriteria' => 'C5', 'nama_kriteria' => 'Kelengkapan & Ketepatan Administrasi (RPPH, dll)', 'jenis' => 'Benefit', 'bobot' => 0.06],
            ['kode_kriteria' => 'C6', 'nama_kriteria' => 'Problem Solving & Komunikasi Orang Tua', 'jenis' => 'Benefit', 'bobot' => 0.06],
            ['kode_kriteria' => 'C7', 'nama_kriteria' => 'Prestasi & Pengembangan Diri', 'jenis' => 'Benefit', 'bobot' => 0.04],
            ['kode_kriteria' => 'C8', 'nama_kriteria' => 'Kedisiplinan Waktu & Kinerja', 'jenis' => 'Benefit', 'bobot' => 0.05],
            ['kode_kriteria' => 'C9', 'nama_kriteria' => 'Penguasaan Bahasa Asing', 'jenis' => 'Benefit', 'bobot' => 0.05],
            ['kode_kriteria' => 'C10', 'nama_kriteria' => 'Kepribadian / Personality Guru', 'jenis' => 'Benefit', 'bobot' => 0.05],
            ['kode_kriteria' => 'C11', 'nama_kriteria' => 'Kebersihan dan Kerapihan Lingkungan Kelas', 'jenis' => 'Benefit', 'bobot' => 0.02],
            ['kode_kriteria' => 'C12', 'nama_kriteria' => 'Keaktifan dalam Komunikasi Internal Sekolah', 'jenis' => 'Benefit', 'bobot' => 0.02],
            ['kode_kriteria' => 'C13', 'nama_kriteria' => 'Kemampuan Manajemen Kelas', 'jenis' => 'Benefit', 'bobot' => 0.03],
            ['kode_kriteria' => 'C14', 'nama_kriteria' => 'Kemampuan Menggunakan Teknologi Pembelajaran', 'jenis' => 'Benefit', 'bobot' => 0.03],
            ['kode_kriteria' => 'C15', 'nama_kriteria' => 'Inovasi dalam Pembelajaran', 'jenis' => 'Benefit', 'bobot' => 0.03],
            ['kode_kriteria' => 'C16', 'nama_kriteria' => 'Kemampuan Evaluasi dan Penilaian Anak', 'jenis' => 'Benefit', 'bobot' => 0.03],
            ['kode_kriteria' => 'C17', 'nama_kriteria' => 'Kerapihan dan Kesiapan Mengajar', 'jenis' => 'Benefit', 'bobot' => 0.02],
            ['kode_kriteria' => 'C18', 'nama_kriteria' => 'Empati dan Kesabaran terhadap Anak', 'jenis' => 'Benefit', 'bobot' => 0.03],
            ['kode_kriteria' => 'C19', 'nama_kriteria' => 'Kerja Sama dengan Sesama Guru', 'jenis' => 'Benefit', 'bobot' => 0.02],
            ['kode_kriteria' => 'C20', 'nama_kriteria' => 'Keaktifan & Partisipasi Kegiatan Sekolah', 'jenis' => 'Benefit', 'bobot' => 0.02],
            ['kode_kriteria' => 'C21', 'nama_kriteria' => 'Kemampuan Storytelling / Mendongeng', 'jenis' => 'Benefit', 'bobot' => 0.02],
            ['kode_kriteria' => 'C22', 'nama_kriteria' => 'Kemampuan Mengelola Emosi', 'jenis' => 'Benefit', 'bobot' => 0.02],
            ['kode_kriteria' => 'C23', 'nama_kriteria' => 'Tingkat Ketidakhadiran', 'jenis' => 'Cost', 'bobot' => 0.03],
            ['kode_kriteria' => 'C24', 'nama_kriteria' => 'Pelanggaran Tata Tertib & Keluhan', 'jenis' => 'Cost', 'bobot' => 0.03],
            ['kode_kriteria' => 'C25', 'nama_kriteria' => 'Tingkat Keterlambatan Datang', 'jenis' => 'Cost', 'bobot' => 0.02],
            ['kode_kriteria' => 'C26', 'nama_kriteria' => 'Kesulitan Menangani Perilaku Anak (Tantrum)', 'jenis' => 'Cost', 'bobot' => 0.02],
            ['kode_kriteria' => 'C27', 'nama_kriteria' => 'Kelalaian dalam Pengawasan & Keamanan Bermain', 'jenis' => 'Cost', 'bobot' => 0.02],
            ['kode_kriteria' => 'C28', 'nama_kriteria' => 'Keluhan dari Orang Tua (Frekuensi)', 'jenis' => 'Cost', 'bobot' => 0.02],
            ['kode_kriteria' => 'C29', 'nama_kriteria' => 'Ketidaksesuaian Metode dengan Kurikulum', 'jenis' => 'Cost', 'bobot' => 0.02],
            ['kode_kriteria' => 'C30', 'nama_kriteria' => 'Tingkat Burnout / Kelelahan Kerja', 'jenis' => 'Cost', 'bobot' => 0.02],
        ];

        $kriteriaIds = [];
        foreach ($kriterias as $kriteria) {
            $k = Kriteria::create($kriteria);
            $kriteriaIds[] = $k->id;
        }

        // 3. Data 12 Guru & Evaluasi Dummy
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

            // Buat Evaluasi periode bulan ini
            $evaluasi = Evaluasi::create([
                'guru_id' => $guru->id,
                'periode' => date('Y-m'),
                'catatan' => 'Evaluasi Kinerja Bulan ' . date('F Y')
            ]);

            // Isi nilai untuk 30 kriteria
            foreach ($kriteriaIds as $k_idx => $k_id) {
                $jenis = $kriterias[$k_idx]['jenis'];
                
                // Set skenario nilai agar algoritma terlihat berjalan
                if ($index === 0) {
                    // Guru ke-1 (Septi): Sangat Bagus (Benefit 4-5, Cost 1-2)
                    $nilai = ($jenis == 'Benefit') ? rand(4, 5) : rand(1, 2);
                } elseif ($index === 1) {
                    // Guru ke-2 (Dewi): Bagus (Benefit 4, Cost 2)
                    $nilai = ($jenis == 'Benefit') ? 4 : 2;
                } elseif ($index === 11) {
                    // Guru ke-12 (Iyo): Kurang (Benefit 1-2, Cost 4-5)
                    $nilai = ($jenis == 'Benefit') ? rand(1, 2) : rand(4, 5);
                } else {
                    // Guru lainnya: Random Average (Benefit 2-4, Cost 2-4)
                    $nilai = rand(2, 4);
                }

                EvaluasiDetail::create([
                    'evaluasi_id' => $evaluasi->id,
                    'kriteria_id' => $k_id,
                    'nilai' => $nilai
                ]);
            }
        }
    }
}
