<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChurnController; // <-- Ini sudah ditambahkan
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Route Dashboard bawaan Laravel
Route::get('/dashboard', function () {
    return redirect()->route('churn.index'); 
})->middleware(['auth', 'verified'])->name('dashboard');

// Route khusus untuk Halaman Churn Prediction kamu
// Route khusus untuk Halaman Churn Prediction kamu
Route::middleware('auth')->group(function () {
    // 1. Halaman Utama Prediksi ( single & bulk predictor )
    Route::get('/churn-prediction', [ChurnController::class, 'index'])->name('churn.index');
    
    // 2. Fungsi untuk memproses data prediksi ke Flask API (Single)
    Route::post('/churn-prediction/predict', [ChurnController::class, 'predict'])->name('churn.predict');
    
    // INI YANG HARUS DITAMBAHKAN (Untuk upload file massal/bulk)
    Route::post('/churn-prediction/bulk', [ChurnController::class, 'predictBulk'])->name('churn.bulk');
    
    // 3. Halaman Riwayat/History Prediksi
    Route::get('/churn-history', [ChurnController::class, 'history'])->name('churn.history');
    
    // Route bawaan untuk Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';