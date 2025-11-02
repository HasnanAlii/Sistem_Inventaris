<?php

use App\Http\Controllers\{
    AsetController,
    AsetLoanController,
    AsetLogController,
    AssessmentController,
    AtkController,
    AtkLogController,
    AtkProcurementController,
    AtkRequestController,
    DashboardController,
    KategoriController,
    LokasiController,
    MaintenanceLogController,
    ProfileController
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// =========================
// 🔹 PUBLIC ROUTES
// =========================
Route::get('/', fn() => view('welcome'));



Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// =========================
// 🔹 PROFILE ROUTES (AUTH)
// =========================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =========================
// 🔹 ROUTES UNTUK SEMUA USER (Pegawai & Petugas)
// =========================
Route::middleware('auth')->group(function () {

        Route::get('/aset-loans', [AsetLoanController::class, 'index'])->name('aset_loans.index');
        Route::get('/aset-loans/create', [AsetLoanController::class, 'create'])->name('aset_loans.create');
        Route::post('/aset-loans', [AsetLoanController::class, 'store'])->name('aset_loans.store');
        Route::post('aset_loans/{asetLoan}/return', [AsetLoanController::class, 'return'])->name('aset_loans.return');
        Route::get('/aset-loans/{asetLoan}/edit', [AsetLoanController::class, 'edit'])->name('aset_loans.edit');
        Route::put('/aset-loans/{asetLoan}', [AsetLoanController::class, 'updateStatus'])->name('aset_loans.update');
        

    Route::prefix('asets')->group(function () {
        Route::get('/assessments', [AssessmentController::class, 'index'])->name('assessments.index');
        Route::get('/maintenance', [MaintenanceLogController::class, 'index'])->name('maintenance.index');
        Route::get('/', [AsetController::class, 'index'])->name('asets.index');
        Route::get('/create', [AsetController::class, 'create'])->name('asets.create');
        Route::post('/', [AsetController::class, 'store'])->name('asets.store');
        Route::get('/{aset}', [AsetController::class, 'show'])->name('asets.show');
        Route::get('/{aset}/edit', [AsetController::class, 'edit'])->name('asets.edit');
        Route::put('/{aset}', [AsetController::class, 'update'])->name('asets.update');
        Route::delete('/{aset}', [AsetController::class, 'destroy'])->name('asets.destroy');

        // Maintenance per aset
        Route::get('/{aset}/maintenance', [MaintenanceLogController::class, 'byAset'])->name('maintenance.Aset');

        // Assess
        Route::get('/{aset}/assess', [AsetController::class, 'assess'])->name('asets.assess');
    });

    // ---------- KATEGORI & LOKASI ----------
    Route::prefix('kategoris')->group(function () {
        Route::get('/lokasis', [LokasiController::class, 'index'])->name('lokasis.index');
        Route::get('/', [KategoriController::class, 'index'])->name('kategoris.index');
        Route::get('/create', [KategoriController::class, 'create'])->name('kategoris.create');
        Route::post('/', [KategoriController::class, 'store'])->name('kategoris.store');
        Route::get('/{kategori}', [KategoriController::class, 'show'])->name('kategoris.show');
        Route::get('/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategoris.edit');
        Route::put('/{kategori}', [KategoriController::class, 'update'])->name('kategoris.update');
        Route::delete('/{kategori}', [KategoriController::class, 'destroy'])->name('kategoris.destroy');

        // Lokasi (nested)
    });

    Route::prefix('lokasis')->group(function () {
        Route::get('/create', [LokasiController::class, 'create'])->name('lokasis.create');
        Route::post('/', [LokasiController::class, 'store'])->name('lokasis.store');
        Route::get('/{lokasi}', [LokasiController::class, 'show'])->name('lokasis.show');
        Route::get('/{lokasi}/edit', [LokasiController::class, 'edit'])->name('lokasis.edit');
        Route::put('/{lokasi}', [LokasiController::class, 'update'])->name('lokasis.update');
        Route::delete('/{lokasi}', [LokasiController::class, 'destroy'])->name('lokasis.destroy');
    });
    Route::prefix('aset-logs')->group(function () {
        Route::get('/', [AsetLogController::class, 'index'])->name('aset_logs.index');
        Route::get('/create', [AsetLogController::class, 'create'])->name('aset_logs.create');
        Route::post('/store', [AsetLogController::class, 'store'])->name('aset_logs.store');
        Route::get('/{asetLog}', [AsetLogController::class, 'show'])->name('aset_logs.show');
        Route::get('/{id}/print', [AsetLogController::class, 'print'])->name('aset_logs.print');


    });
    // ---------- ATK ----------
    Route::prefix('atks')->group(function () {
        // Request & pengambilan ATK
        Route::get('/list', [AtkLogController::class, 'list'])->name('logs.list');
        Route::get('/request', [AtkController::class, 'requestForm'])->name('atks.take');
        Route::post('/request', [AtkController::class, 'storeRequest'])->name('atks.request.store');
        Route::get('/', [AtkController::class, 'index'])->name('atks.index');
        Route::get('/create', [AtkController::class, 'create'])->name('atks.create');
        Route::post('/', [AtkController::class, 'store'])->name('atks.store');
        Route::get('/{atk}', [AtkController::class, 'show'])->name('atks.show');
        Route::get('/{atk}/edit', [AtkController::class, 'edit'])->name('atks.edit');
        Route::put('/{atk}', [AtkController::class, 'update'])->name('atks.update');
        Route::delete('/{atk}', [AtkController::class, 'destroy'])->name('atks.destroy');

    });
    Route::prefix('atkprocurements')->name('atkprocurements.')->group(function () {
        Route::get('/create', [AtkProcurementController::class, 'create'])->name('create');
        Route::post('/store', [AtkProcurementController::class, 'store'])->name('store');
        Route::get('/{atkProcurement}', [AtkProcurementController::class, 'show'])->name('show');
        Route::get('/{atkProcurement}/print', [AtkProcurementController::class, 'print'])->name('print');

    });
    // ---------- LOGS ----------
    Route::prefix('logs')->group(function () {
        // ATK Logs
        Route::get('addatk', [AtkProcurementController::class, 'index'])->name('logs.addatk');
        Route::get('/atk', [AtkLogController::class, 'allLogs'])->name('logs.atk');
        Route::get('/atk/{atkLog}', [AtkLogController::class, 'show'])->name('logs.atk.show');
        Route::post('/{atkLog}/approve', [AtkLogController::class, 'approve'])->name('atk_logs.approve');
        Route::post('/{atkLog}/reject', [AtkLogController::class, 'reject'])->name('atk_logs.reject');
        Route::post('/atk/return', [AtkLogController::class, 'returnItem'])->name('atk_logs.return');
        Route::post('/atk/return', [AtkLogController::class, 'returnAtk'])->name('logs.atk.return');

        // Aset Logs
        Route::get('/aset', [AsetLogController::class, 'index'])->name('logs.aset');
    });

    // ---------- MAINTENANCE ----------
    Route::prefix('maintenance')->group(function () {
        Route::get('/create', [MaintenanceLogController::class, 'create'])->name('maintenance.create');
        Route::post('/', [MaintenanceLogController::class, 'store'])->name('maintenance.store');
        Route::get('/{maintenanceLog}', [MaintenanceLogController::class, 'show'])->name('maintenance.show');
        Route::get('/{maintenanceLog}/edit', [MaintenanceLogController::class, 'edit'])->name('maintenance.edit');
        Route::put('/{maintenanceLog}', [MaintenanceLogController::class, 'update'])->name('maintenance.update');
        Route::delete('/{maintenanceLog}', [MaintenanceLogController::class, 'destroy'])->name('maintenance.destroy');
    });

    // ---------- ASSESSMENT ----------
    Route::prefix('assessments')->group(function () {
        Route::get('/create', [AssessmentController::class, 'create'])->name('assessments.create');
        Route::post('/', [AssessmentController::class, 'store'])->name('assessments.store');
        Route::get('/{assessment}', [AssessmentController::class, 'show'])->name('assessments.show');
        Route::get('/{assessment}/edit', [AssessmentController::class, 'edit'])->name('assessments.edit');
        Route::put('/{assessment}', [AssessmentController::class, 'update'])->name('assessments.update');
        Route::delete('/{assessment}', [AssessmentController::class, 'destroy'])->name('assessments.destroy');
    });
});

require __DIR__.'/auth.php';
