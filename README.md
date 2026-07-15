# 🏫 SPK MOORA - Sistem Pendukung Keputusan Evaluasi Kinerja Guru (TK Al Azkar)

Aplikasi **Sistem Pendukung Keputusan (SPK) / Decision Support System (DSS)** berbasis web yang dirancang khusus untuk **TK Al Azkar** guna mengevaluasi kinerja guru secara objektif, transparan, dan efisien menggunakan metode **MOORA (Multi-Objective Optimization on the Basis of Ratio Analysis)** dengan dukungan penilaian multi-evaluator (kolaboratif).

---

## 🌟 Fitur Utama Aplikasi

### 🔑 Autentikasi & Multi-Role
* **Kepala Sekolah (Evaluator Utama):** Memiliki hak penuh untuk mengelola kriteria, guru, admin penilai, melakukan input evaluasi, melihat proses perhitungan MOORA, dan mengunduh laporan.
* **Tim Penilai Kedua (Evaluator Tambahan):** Memiliki hak untuk menginput nilai evaluasi guru versi penilaian mereka. Sistem akan secara otomatis menghitung rata-rata (agregat) nilai dari semua penilai sebelum diproses dengan algoritma MOORA.
* **Guru (Alternatif):** Memiliki akses ke portal mandiri dengan visual ramah anak bertema **Mint & Coral** untuk memantau performa evaluasi diri, melihat perbandingan kinerja antar-semester, menerima catatan Kepala Sekolah, serta mengunduh Rapor Evaluasi Kinerja.

### 📐 Modul Manajemen SPK
* **Kelola Kriteria & Bobot:** Pengelolaan 30 kriteria penilaian yang dibagi menjadi aspek **Benefit** (22 kriteria seperti kreativitas, kelengkapan RPPH) dan **Cost** (8 kriteria seperti tingkat ketidakhadiran, frekuensi keluhan orang tua) dengan total bobot akumulasi 100%.
* **Kelola Guru (Alternatif):** CRUD data guru lengkap beserta data akun login untuk guru bersangkutan.
* **Input Nilai Evaluasi:** Form penilaian interaktif dengan skala 1 - 100 untuk setiap kriteria.

### 🧮 Engine Perhitungan MOORA Multi-Penilai
* **Agregasi Nilai:** Menghitung rata-rata nilai dari Kepala Sekolah dan Tim Penilai Kedua.
* **Normalisasi Matriks:** Mengubah nilai mentah menjadi matriks ternormalisasi untuk menghilangkan perbedaan satuan.
* **Optimasi Terbobot:** Mengalikan hasil normalisasi dengan bobot masing-masing kriteria.
* **Nilai Optimasi ($Yi$):** Menghitung nilai akhir dengan mengurangi total nilai benefit dengan total nilai cost.
* **Perangkingan:** Menghasilkan urutan guru terbaik secara *real-time* berdasarkan nilai $Yi$ tertinggi.

### 📈 Portal Guru (Mint & Coral Theme)
* **Visual Premium:** Antarmuka responsif dengan skema warna cerah khas anak-anak, menggunakan bubble UI yang modern dan bersih.
* **Grafik Analisis:** Visualisasi grafik perkembangan nilai kriteria guru.
* **Perbandingan Periode:** Membandingkan nilai kinerja antar-semester (Ganjil vs Genap) guna melihat perkembangan profesionalisme guru.
* **Cetak Rapor:** Fitur cetak rapor penilaian kinerja resmi yang ramah printer.

### 🔒 Keamanan & Fitur Ekstra
* **Show/Hide Password:** Fitur toggle mata pada semua kolom input password (Login, Profil Admin, Pengaturan Guru) untuk kenyamanan dan keamanan pengguna.
* **Protection from Leaks:** Database seeder dikonfigurasi dengan aman menggunakan pendeteksian environment `local` agar data simulasi tidak merusak/mengotori database asli saat dideploy.

---

## 🛠️ Tech Stack & Arsitektur

* **Framework Utama:** Laravel 11 (PHP 8.2+)
* **Database:** MySQL / PostgreSQL
* **Desain UI/UX:** HTML5, Vanilla CSS, TailwindCSS (Portal Guru), SB Admin 2 (Panel Admin), Remix Icons, FontAwesome 5
* **Interaktivitas:** JavaScript (ES6+), Chart.js (Grafik Analisis Guru), SweetAlert2 (Notifikasi & Konfirmasi Cantik)

---

## 📐 Algoritma MOORA di Sistem Ini

Metode MOORA digunakan karena memiliki tingkat fleksibilitas dan akurasi yang tinggi dalam memecahkan masalah multi-kriteria. Berikut adalah alur rumus yang diimplementasikan di dalam sistem:

1. **Matriks Keputusan ($X$):**
   Merepresentasikan nilai alternatif guru ($i$) pada setiap kriteria ($j$). Jika ada multi-penilai, nilai $x_{ij}$ merupakan rata-rata dari semua penilai.
2. **Normalisasi Matriks ($x^*_{ij}$):**
   Membagi setiap nilai dengan akar kuadrat dari penjumlahan kuadrat nilai per kriteria:
   $$x^*_{ij} = \frac{x_{ij}}{\sqrt{\sum_{i=1}^{m} x_{ij}^2}}$$
3. **Matriks Normalisasi Terbobot ($y_{ij}$):**
   Mengalikan matriks ternormalisasi dengan bobot kriteria ($W_j$):
   $$y_{ij} = x^*_{ij} \times W_j$$
4. **Nilai Optimasi Alternatif ($Yi$):**
   Mengurangi nilai kriteria bertipe Benefit dengan tipe Cost:
   $$Yi = \sum_{j=1}^{g} y_{ij} - \sum_{j=g+1}^{n} y_{ij}$$
   *Alternatif dengan nilai $Yi$ tertinggi adalah guru dengan kinerja terbaik.*

---

## 📸 Dokumentasi & Antarmuka Aplikasi

*Ganti gambar di bawah ini dengan screenshot aplikasi Anda untuk mempercantik tampilan portofolio GitHub Anda.*

### 1. Halaman Login (Show/Hide Password)
> Halaman masuk dengan desain rounded bubble UI yang modern dilengkapi toggle tampilkan sandi.
> ![Login Page](https://via.placeholder.com/800x450.png?text=Screenshot+Halaman+Login)

### 2. Dashboard Admin & Ringkasan Perangkingan
> Panel utama Kepala Sekolah yang menampilkan ringkasan performa guru dan rangking 5 besar teratas.
> ![Dashboard Admin](https://via.placeholder.com/800x450.png?text=Screenshot+Dashboard+Admin)

### 3. Matriks Hasil Perhitungan MOORA
> Halaman transparansi perhitungan rumus MOORA mulai dari matriks keputusan, normalisasi, hingga nilai akhir Yi.
> ![Perhitungan MOORA](https://via.placeholder.com/800x450.png?text=Screenshot+Perhitungan+MOORA)

### 4. Portal Mandiri Guru (Mint & Coral Theme)
> Tampilan dashboard guru yang ramah anak, menampilkan grafik nilai kriteria dan perbandingan perkembangan antar-semester.
> ![Portal Guru](https://via.placeholder.com/800x450.png?text=Screenshot+Portal+Guru)

---

## 🚀 Panduan Instalasi Lokal (Setup Development)

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal Anda:

### 1. Persiapan Awal
Pastikan komputer Anda sudah terinstall **PHP 8.2+**, **Composer**, dan database server (**MySQL** seperti XAMPP/Laragon).

### 2. Clone Repositori
```bash
git clone https://github.com/hendrald/SPK_MOORAALAZKAR.git
cd SPK_MOORAALAZKAR
```

### 3. Install Dependensi PHP
```bash
composer install
```

### 4. Setup Environment File (`.env`)
Duplikat file template konfigurasi:
* **Windows CMD:** `copy .env.example .env`
* **Linux/Mac/Git Bash:** `cp .env.example .env`

Buka file `.env` baru Anda, lalu sesuaikan koneksi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_lokal_anda
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Application Key & Link Storage
```bash
php artisan key:generate
php artisan storage:link
```

### 6. Migrasi & Seeding Data Simulasi
Jalankan perintah berikut untuk membuat struktur database dan otomatis mengisi data simulasi (karena dideteksi berjalan di `APP_ENV=local`):
```bash
php artisan migrate --seed
```
*Setelah seeder berhasil dijalankan, Anda dapat login menggunakan akun simulasi bawaan:*
* **Admin (Kepala Sekolah):** `kepsek@tkalazkar.sch.id` | Password: `AdminAzkar2026!`
* **Guru Contoh:** `septi@tkalazkar.sch.id` | Password: `AlazkarHebat!`

### 7. Jalankan Server
```bash
php artisan serve
```
Akses aplikasi melalui browser di alamat: [http://127.0.0.1:8000](http://127.0.0.1:8000).

---
*Dikembangkan secara profesional untuk mendukung peningkatan mutu pendidikan di TK Al Azkar.*
