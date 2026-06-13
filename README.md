# SPK MOORA - Teacher Performance Decision Support System

A Decision Support System (DSS) / Sistem Pendukung Keputusan (SPK) application built with Laravel and MySQL using the MOORA (Multi-Objective Optimization on the Basis of Ratio Analysis) algorithm to evaluate teacher performance effectively and objectively.

## 🌟 Fitur Utama
- **Autentikasi Multi-Role**: Sistem role berbasis hak akses (Superadmin/Kepala Sekolah, Admin/Penilai Tambahan, Guru).
- **Dashboard Admin & Kelola Admin**: Mengelola data kriteria, bobot, alternatif (guru), penilai tambahan, dan evaluasi.
- **Implementasi MOORA Multi-Penilai**: Proses perhitungan normalisasi matriks, optimalisasi, hingga penentuan ranking secara otomatis menggunakan nilai agregat/rata-rata dari seluruh penilai.
- **Laporan & Ekspor Data**: Hasil penilaian dapat dilihat secara komprehensif, bisa dicetak, dan diekspor ke Excel (CSV).
- **Portal Guru (Mint & Coral Aesthetic)**: Dashboard interaktif untuk guru dilengkapi notifikasi performa, statistik pencapaian, dan unduh rapor evaluasi periode tertentu.
- **Perbandingan Nilai Antar Periode**: Membandingkan nilai kinerja dari dua semester yang berbeda baik di panel admin maupun di portal guru.

---

## 🔑 Akun Uji Coba (Seeded Accounts)
Setelah menjalankan seeder, gunakan akun berikut untuk masuk ke sistem:

### 1. Peran: Admin / Kepala Sekolah (Evaluator Utama)
- **Email:** `kepsek@tkalazkar.sch.id`
- **Password:** `AdminAzkar2026!`

### 2. Peran: Admin / Tim Penilai Kedua (Evaluator Tambahan)
- **Email:** `penilai@tkalazkar.sch.id`
- **Password:** `AdminAzkar2026!`

### 3. Peran: Guru (Contoh Guru)
- **Email:** `septi@tkalazkar.sch.id` (atau nama depan guru lainnya seperti `dewi@tkalazkar.sch.id`)
- **Password:** `AlazkarHebat!`

---

## 🚀 Alur Instalasi (Cara Clone & Setup Project)

Jika Anda atau tim ingin men-*clone* (meng-copy) project ini di laptop atau device baru, ikuti langkah-langkah *best practice* berikut.

### 1. Clone Repository
Buka terminal/CMD/Git Bash di folder lokal tujuan Anda (misalnya di `C:\laragon\www`), lalu jalankan:
```bash
git clone https://github.com/hendrald/SPK_MOORAALAZKAR.git
```

### 2. Masuk ke Direktori Project
```bash
cd SPK_MOORAALAZKAR
```

### 3. Install Dependencies PHP (Composer)
Folder `vendor` tidak diinput ke dalam GitHub, jadi Anda harus mengunduh library yang dibutuhkan aplikasi dengan perintah berikut:
```bash
composer install
```

### 4. Setup File Konfigurasi Environment (`.env`)
File utama konfigurasi `.env` sifatnya rahasia, jadi yang masuk ke GitHub hanya template `.env.example`. Silakan duplikasi file tersebut:
- **Di Windows:**
  ```cmd
  copy .env.example .env
  ```
- **Di Mac/Linux/Git Bash:**
  ```bash
  cp .env.example .env
  ```

### 5. Konfigurasi Database
Buka file `.env` di text editor (seperti VSCode), cari konfigurasi database, dan sesuaikan nilainya (pastikan Anda sudah membuat databasenya di server database lokal Anda, misal MySQL di Laragon/XAMPP):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spk_moora
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Generate Application Key
Untuk mengamankan session dan hashing password pada aplikasi Laravel:
```bash
php artisan key:generate
```

### 7. Jalankan Migrasi & Database Seeder
Langkah ini menyiapkan ulang seluruh tabel di database dan mengisi akun awal (seperti akun penilai dan data awal guru, kriteria, & evaluasi):
```bash
php artisan migrate --seed
```

### 8. Hubungkan Public Storage
Dibutuhkan jika project mengelola file media seperti upload foto profil dari direktori penyimpanan:
```bash
php artisan storage:link
```

### 9. Jalankan Aplikasi
Jika menggunakan Laragon, aplikasi sudah bisa diakses melalui link lokal otomatis (contoh: `http://spk_mooraalazkar.test`).
Namun, jika Anda tidak menggunakan Laragon, nyalakan *server local* milik Laravel dengan perintah:
```bash
php artisan serve
```
Buka browser dan buka `http://127.0.0.1:8000`

---
*Developed with Laravel & Custom Responsive Theme*
