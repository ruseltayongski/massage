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

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('/');
    Route::get('/client/dashboard', [App\Http\Controllers\ClientController::class, 'dashboard'])->name('client.dashboard');
    Route::get('/client/services', [App\Http\Controllers\ClientController::class, 'services'])->name('client.services');
    Route::get('/client/therapist', [App\Http\Controllers\ClientController::class, 'therapist'])->name('client.therapist');
    Route::get('/client/profile', [App\Http\Controllers\ClientController::class, 'clientProfile'])->name('client.profile');
    Route::put('/client/update', [App\Http\Controllers\ClientController::class, 'updateProfile'])->name('client.profile.update');
    Route::get('/client/booking', [App\Http\Controllers\ClientController::class, 'booking'])->name('client.booking');
    Route::post('/client/booking/save', [App\Http\Controllers\ClientController::class, 'bookingSave'])->name('client.booking.save');
    Route::get('/client/booking/edit', [App\Http\Controllers\ClientController::class, 'bookingEdit'])->name('client.booking.edit');
    Route::post('/client/booking/edit/save', [App\Http\Controllers\ClientController::class, 'bookingEditSave'])->name('client.booking.edit.save');
    Route::get('/client/booking/history', [App\Http\Controllers\ClientController::class, 'bookingHistory'])->name('client.booking.history');
    Route::get('/client/rate/spa',  [App\Http\Controllers\ClientController::class, 'rateSpa'])->name('client.rate.spa');
    Route::post('/client/rate/spa/save',  [App\Http\Controllers\ClientController::class, 'rateSpaSave'])->name('client.rate.spa.save');
    Route::get('/client/rate/therapist',  [App\Http\Controllers\ClientController::class, 'rateTherapist'])->name('client.rate.therapist');
    Route::post('/client/rate/therapist/save',  [App\Http\Controllers\ClientController::class, 'rateTherapistSave'])->name('client.rate.therapist.save');
    Route::get('/client/testimonial',  [App\Http\Controllers\ClientController::class, 'testimonial'])->name('client.testimonial');
    Route::post('/client/testimonial/save', [App\Http\Controllers\ClientController::class, 'testimonialSave'])->name('client.testimonial.save');
    Route::post('/client/update/booking/status', [App\Http\Controllers\ClientController::class, 'updateBookingStatus'])->name('client.update.booking.status');
    Route::post('/therapist/update/booking/status', [App\Http\Controllers\TherapistController::class, 'updateBookingStatus'])->name('therapist.update.booking.status');
    Route::get('/therapist/profile',  [App\Http\Controllers\TherapistController::class, 'therapistView'])->name('therapist.profile');
    Route::get('/therapist/dashboard/main',  [App\Http\Controllers\TherapistController::class, 'therapistDasboardMain'])->name('therapist.dashboard.main');
    Route::get('/therapist/booking',  [App\Http\Controllers\TherapistController::class, 'booking'])->name('therapist.booking');
    Route::put('therapist/update',  [App\Http\Controllers\TherapistController::class, 'updateTherapist'])->name('therapist.update');
    Route::get('therapist/history',  [App\Http\Controllers\TherapistController::class, 'bookingHistory'])->name('therapist.booking_history');
    Route::get('client/generate/pdf', [App\Http\Controllers\PDFController::class, 'clientGeneratePDF'])->name('client-generate-pdf');
    Route::get('owner/generate/pdf', [App\Http\Controllers\PDFController::class, 'ownerGeneratePDF'])->name('owner-generate-pdf');
    Route::post('user/update/status', [App\Http\Controllers\UserController::class, 'userUpdateStatus'])->name('user.update.status');
    //Services

    Route::group(['middleware' => 'admin'], function () {
        Route::get('admin/dashboard',[App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin/dashboard');
        Route::get('admin/owner',[App\Http\Controllers\AdminController::class, 'owner'])->name('admin/owner');
        Route::post('update/contract', [App\Http\Controllers\AdminController::class, 'updateOwnerStatus'])->name('update.contract.status');
        Route::get('admin/profile', [App\Http\Controllers\AdminController::class, 'ownerProfile'])->name('admin.profile');
        Route::put('admin/update', [App\Http\Controllers\AdminController::class, 'updateProfile'])->name('admin.update');
        Route::get('admin/barchart/profit/excel', [App\Http\Controllers\AdminController::class, 'exportBarchartProfit'])->name('admin.barchart.profit.excel');
    });

    Route::group(['middleware' => 'owner'], function () {
        Route::get('owner/dashboard',[App\Http\Controllers\OwnerController::class, 'dashboard'])->name('owner/dashboard');
        Route::get('owner/spa',[App\Http\Controllers\OwnerController::class, 'spa'])->name('owner/spa');
        Route::get('owner/contract',[App\Http\Controllers\OwnerController::class, 'contract'])->name('owner.contract');
        Route::post('owner/contract/save',[App\Http\Controllers\OwnerController::class, 'contractSave'])->name('owner.contract.save');
        Route::post('owner/spa',[App\Http\Controllers\OwnerController::class, 'addSpa'])->name('owner.spa.save');
        Route::put('owner/spa', [App\Http\Controllers\OwnerController::class, 'updateSpa'])->name('owner.spa.update');
        Route::post('/clear_spa_update_flash', [App\Http\Controllers\OwnerController::class, 'clearSpaUpdateFlash'])->name('clear_spa_update_flash');
        Route::get('owner/therapist',[App\Http\Controllers\OwnerController::class, 'therapist'])->name('owner/therapist');
        Route::post('owner/therapist', [App\Http\Controllers\TherapistController::class, 'addTherapist'])->name('owner.therapist.save');
        Route::get('/get-therapists', [App\Http\Controllers\OwnerController::class, 'getTherapists'])->name('owner.get-therapists');
        Route::get('/get-spa', [App\Http\Controllers\OwnerController::class, 'spaInServices'])->name('get.spa');
        Route::get('owner/profile',[App\Http\Controllers\OwnerController::class, 'ownerProfile'])->name('owner.get.profile');
        Route::put('profile/update',[App\Http\Controllers\OwnerController::class, 'updateProfile'])->name('owner.profile.update');
        Route::post('assign/therapist', [App\Http\Controllers\OwnerController::class, 'assignTherapist'])->name('assigned.therapist.save');
        Route::put('reassign/therapist', [App\Http\Controllers\OwnerController::class, 'reassignTherapist'])->name('reassign.therapist');
        Route::get('owner/services',[App\Http\Controllers\ServicesController::class, 'servicesView'])->name('owner/services');
        Route::put('services/update',[App\Http\Controllers\ServicesController::class, 'updateService'])->name('owner.services.update');
        Route::post('owner/services',[App\Http\Controllers\ServicesController::class, 'addServices'])->name('owner.services.save');
        Route::post('assign/services',[App\Http\Controllers\ServicesController::class, 'assignSpa'])->name('owner.assign.save');
        Route::post('owner/get/spa', [App\Http\Controllers\ServicesController::class, 'getSpa'])->name('owner.get.spa');
        Route::get('owner/transactions', [App\Http\Controllers\OwnerController::class, 'transactionsView'])->name('owner/transactions');
        Route::get('owner/barchart/profit/excel', [App\Http\Controllers\OwnerController::class, 'exportBarchartProfit'])->name('owner.barchart.profit.excel');
    });
});

// Route::get('/{pathMatch}', function() {
//     return view('welcome');
// })->where('pathMatch',".*");
