<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Halaman Admin
Route::get('/admin', [PetController::class, 'index'])->name('admin.app');
Route::get('/admin/pet/create', [PetController::class, 'create'])->name('admin.pet.create');
Route::post('/admin/pet', [PetController::class, 'store'])->name('admin.pet.store');
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('pet/{pet}/edit', [PetController::class, 'edit'])->name('pet.edit');
    Route::put('pet/{pet}', [PetController::class, 'update'])->name('pet.update');
    Route::delete('pet/{pet}', [PetController::class, 'destroy'])->name('pet.destroy');
    Route::post('pet/{pet}/sold', [PetController::class, 'sold'])->name('pet.sold');
});





// Halaman Pembeli
Route::get('/shop', [\App\Http\Controllers\ShopController::class, 'index']);