<?php

use App\Http\Controllers\{
    DashboardController,
    FrontController,
    KategoriController,
    ProdukController,
    SatuanController
};
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

Route::get('/', [FrontController::class, 'index']);

Route::group([
    'middleware' => ['auth', 'role:admin,pembeli'],
], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::group([
        'middleware' => 'role:admin'
    ], function () {

        Route::get('satuan/data', [SatuanController::class, 'data'])->name('satuan.data');
        Route::get('ajax/satuan/search', [SatuanController::class, 'ajaxSearch'])->name('satuan.search');
        Route::resource('satuan', SatuanController::class);

        Route::get('kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
        Route::get('ajax/categories/search', [KategoriController::class, 'ajaxSearch'])->name('kategori.search');
        Route::resource('kategori', KategoriController::class);

        Route::get('produk/data', [ProdukController::class, 'data'])->name('produk.data');
        Route::resource('produk', ProdukController::class);
    });
});
