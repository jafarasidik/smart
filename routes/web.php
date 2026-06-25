<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstansiXJabatanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotulensiController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RapatController;
use App\Http\Controllers\RuanganController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(PublicController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::post('/auth', 'auth')
         ->name('auth');
    Route::get('/absensi/hadir/{uuid}', 'prosesAbsensiHadir')->name('agenda.absensi.hadir');
    Route::post('/absensi/simpan/{uuid}', 'prosesAbsensiSimpan')->name('agenda.absensi.simpan');
});

Route::middleware(['auth'])->group(function () {
    
    Route::prefix('main')->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard');
            Route::post('/logout', 'logout')->name('logout');
            Route::get('/chart-kehadiran', 'chartKehadiran')->name('dashboard.chart-kehadiran');
            Route::get('/pengaturan', 'settings')->name('pengaturan');
            Route::put('/pengaturan/{id}', 'updateProfile')->name('pengaturan.update');
        });
        Route::prefix('laporan')->group(function () {
            Route::controller(LaporanController::class)->group(function () {
                Route::get('/', 'index')->name('laporan');
                Route::get('/export/pdf', 'exportPdf')->name('laporan.pdf');
            });
        });
        Route::prefix('data')->group(function () {
            Route::resource('agenda', RapatController::class)->names([
                'index'     => 'data.agenda',
                'create'    => 'data.agenda.create',
                'store'     => 'data.agenda.store',
                'show'      => 'data.agenda.show',
                'edit'      => 'data.agenda.edit',
                'update'    => 'data.agenda.update',
                'destroy'   => 'data.agenda.delete',
            ]);
            Route::get('/agenda/{id}/json', [RapatController::class, 'getAgendaJson'])->name('data.agenda.json');
            Route::post('/agenda/{id}/kirim-email', [RapatController::class, 'kirimEmailPeserta'])->name('data.agenda.kirim-email');
            Route::resource('peserta', PesertaController::class)->names([
                'index'     => 'data.peserta',
                'create'    => 'data.peserta.create',
                'store'     => 'data.peserta.store',
                'edit'      => 'data.peserta.edit',
                'update'    => 'data.peserta.update',
                'destroy'   => 'data.peserta.delete',
            ]);
            Route::resource('ruangan', RuanganController::class)->names([
                'index'     => 'data.ruangan',
                'create'    => 'data.ruangan.create',
                'store'     => 'data.ruangan.store',
                'edit'      => 'data.ruangan.edit',
                'update'    => 'data.ruangan.update',
                'destroy'   => 'data.ruangan.delete',
            ]);
            Route::resource('instansi-jabatan', InstansiXJabatanController::class)->names([
                'index'     => 'data.ixj',
                'create'    => 'data.ixj.create',
                'store'     => 'data.ixj.store',
                'edit'      => 'data.ixj.edit',
                'update'    => 'data.ixj.update',
                'destroy'   => 'data.ixj.delete',
            ]);
            Route::resource('notulensi', NotulensiController::class)->names([
                'index'     => 'data.notulensi',
                'create'    => 'data.notulensi.create',
                'show'      => 'data.notulensi.show',
                'store'     => 'data.notulensi.store',
                'edit'      => 'data.notulensi.edit',
                'update'    => 'data.notulensi.update',
                'destroy'   => 'data.notulensi.delete',
            ]);
            Route::post('/notulensi/share/{id}', [NotulensiController::class, 'shareNotulensi'])->name('data.notulensi.share');
            Route::resource('admin', AdminController::class)->names([
                'index'     => 'data.admin',
                'create'    => 'data.admin.create',
                'store'     => 'data.admin.store',
                'edit'      => 'data.admin.edit',
                'update'    => 'data.admin.update',
                'destroy'   => 'data.admin.delete',
            ]);
        });
    });
});