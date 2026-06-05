<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstansiXJabatanController;
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
    Route::get('/', 'index')->name('index');
    Route::get('/login', 'login')->name('login');
    Route::post('/auth', 'auth')
         ->name('auth');
});

Route::middleware(['auth'])->group(function () {
    
    Route::prefix('main')->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/', 'index')->name('dashboard');
            Route::post('/logout', 'logout')->name('logout');
            Route::get('/chart-kehadiran', 'chartKehadiran')->name('dashboard.chart-kehadiran');
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
        });
    });
});