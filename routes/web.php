<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        // Coba kalkulasi top 5 untuk bulan terakhir jika ada evaluasi
        $latestPeriod = \App\Models\Evaluasi::max('periode');
        $top5 = [];
        if ($latestPeriod) {
            $kriterias = \App\Models\Kriteria::orderBy('kode_kriteria', 'asc')->get();
            $evaluasis = \App\Models\Evaluasi::with(['guru', 'details'])->where('periode', $latestPeriod)->get();
            
            // Re-run MOORA logic briefly for dashboard
            $matriksX = [];
            foreach ($evaluasis as $evaluasi) {
                foreach ($kriterias as $kriteria) {
                    $detail = $evaluasi->details->firstWhere('kriteria_id', $kriteria->id);
                    $matriksX[$evaluasi->id][$kriteria->id] = $detail ? $detail->nilai : 0;
                }
            }

            $pembagi_kriteria = [];
            foreach ($kriterias as $kriteria) {
                $sum_kuadrat = 0;
                foreach ($evaluasis as $evaluasi) {
                    $sum_kuadrat += pow($matriksX[$evaluasi->id][$kriteria->id], 2);
                }
                $pembagi_kriteria[$kriteria->id] = sqrt($sum_kuadrat) ?: 1;
            }

            foreach ($evaluasis as $evaluasi) {
                $sumBenefit = 0; $sumCost = 0;
                foreach ($kriterias as $kriteria) {
                    $nilaiBobot = ($matriksX[$evaluasi->id][$kriteria->id] / $pembagi_kriteria[$kriteria->id]) * $kriteria->bobot;
                    if ($kriteria->jenis === 'Benefit') $sumBenefit += $nilaiBobot;
                    else $sumCost += $nilaiBobot;
                }
                $top5[] = [
                    'guru' => $evaluasi->guru->nama_lengkap,
                    'nilai_yi' => $sumBenefit - $sumCost
                ];
            }
            usort($top5, fn($a, $b) => $b['nilai_yi'] <=> $a['nilai_yi']);
            $top5 = array_slice($top5, 0, 5);
        }

        return view('admin.dashboard', compact('top5', 'latestPeriod'));
    })->name('dashboard');

    Route::resource('guru', \App\Http\Controllers\GuruController::class);
    Route::resource('kriteria', \App\Http\Controllers\KriteriaController::class);
    Route::resource('evaluasi', \App\Http\Controllers\EvaluasiController::class);

    Route::get('moora', [\App\Http\Controllers\MooraController::class, 'index'])->name('moora.index');
    Route::post('moora/hitung', [\App\Http\Controllers\MooraController::class, 'hitungMoora'])->name('moora.hitung');

    Route::get('profile', [\App\Http\Controllers\AdminProfileController::class, 'index'])->name('profile');
    Route::put('profile', [\App\Http\Controllers\AdminProfileController::class, 'update'])->name('profile.update');
});

// Guru Routes
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\GuruDashboardController::class, 'index'])->name('dashboard');
    Route::get('/riwayat', [\App\Http\Controllers\GuruDashboardController::class, 'riwayat'])->name('riwayat');
    Route::get('/settings', [\App\Http\Controllers\GuruDashboardController::class, 'settings'])->name('settings');
    Route::post('/settings', [\App\Http\Controllers\GuruDashboardController::class, 'updateSettings'])->name('settings.update');
    Route::get('/cetak-rapor/{periode}', [\App\Http\Controllers\GuruDashboardController::class, 'cetakRapor'])->name('cetak_rapor');
});

