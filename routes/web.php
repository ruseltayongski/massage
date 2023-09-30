<?php

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

Route::group(['middleware' => 'prevent-back-history'],function() {
	Auth::routes();
	Route::get('/{page}', [App\Http\Controllers\HomeController::class, 'index'])
    ->where('page', 'home|about|account')
    ->name('home');

    Route::get('/', [App\Http\Controllers\ClientController::class, 'dashboard'])->name('client');
    Route::get('/client', [App\Http\Controllers\ClientController::class, 'dashboard'])->name('client');
    
    Route::group(['middleware' => 'admin'], function () {
        Route::get('admin/dashboard',[App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin/dashboard');
        Route::get('admin/owner',[App\Http\Controllers\AdminController::class, 'owner'])->name('admin/owner');
    });

    Route::group(['middleware' => 'owner'], function () {
        Route::get('owner/dashboard',[App\Http\Controllers\OwnerController::class, 'dashboard'])->name('owner/dashboard');
        Route::get('owner/spa',[App\Http\Controllers\OwnerController::class, 'spa'])->name('owner/spa');
        Route::get('owner/contract',[App\Http\Controllers\OwnerController::class, 'contract'])->name('owner/contract');
        Route::post('owner/contract/save',[App\Http\Controllers\OwnerController::class, 'contractSave'])->name('owner.contract.save');
        Route::post('owner/spa',[App\Http\Controllers\OwnerController::class, 'addSpa'])->name('owner.spa.save');
        Route::put('owner/spa', [App\Http\Controllers\OwnerController::class, 'updateSpa'])->name('owner.spa.update');
        Route::post('/clear_spa_update_flash', [App\Http\Controllers\OwnerController::class, 'clearSpaUpdateFlash'])->name('clear_spa_update_flash');
    });
});

// Route::get('/{pathMatch}', function() {
//     return view('welcome');
// })->where('pathMatch',".*");
