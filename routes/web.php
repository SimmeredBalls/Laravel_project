<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InvoiceController;

// Public routes
Route::get('/', [AdminController::class, 'home'])->name('home');
Route::get('/home', [AdminController::class, 'index'])->name('admin.home');
Route::get('/room_details/{id}', [HomeController::class, 'room_details'])->name('room.details');
Route::get('/about_details', [HomeController::class, 'about_details'])->name('about.details');
Route::get('/our_room_details', [HomeController::class, 'our_room_details'])->name('our_room.details');
Route::get('/gallery_details', [HomeController::class, 'gallery_details'])->name('gallery.details');
Route::get('/contact_details', [HomeController::class, 'contact_details'])->name('contact.details');
Route::post('/contact', [HomeController::class, 'contact']);

// User-authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/add_booking/{id}', [HomeController::class, 'add_booking'])->name('add.booking');
    Route::get('/payment/{bookingId}', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/pay/{bookingId}', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/my_bookings', [HomeController::class, 'my_bookings'])->name('my.bookings');
    Route::delete('/cancel_booking/{id}', [HomeController::class, 'cancel_booking'])->name('cancel.booking');
    Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('invoice.show');
});

// Admin-only routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/all_messages', [AdminController::class, 'all_messages']);
    Route::get('/send_mail/{id}', [AdminController::class, 'send_mail']);
    Route::post('/mail/{id}', [AdminController::class, 'mail']);

    Route::get('/view_gallery', [AdminController::class, 'view_gallery']);
    Route::post('/upload_gallery', [AdminController::class, 'upload_gallery']);
    Route::get('/delete_gallery/{id}', [AdminController::class, 'delete_gallery']);

    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings.admin');
    Route::get('/delete_booking/{id}', [AdminController::class, 'delete_booking'])->name('delete.booking.admin');
    Route::get('/approve_book/{id}', [AdminController::class, 'approve_book'])->name('approve.booking.admin');
    Route::get('/reject_book/{id}', [AdminController::class, 'reject_book'])->name('reject.booking.admin');

    Route::get('/create_room', [AdminController::class, 'create_room'])->name('create.room');
    Route::post('/add_room', [AdminController::class, 'add_room'])->name('add.room');
    Route::get('/view_room', [AdminController::class, 'view_room'])->name('view.room');
    Route::get('/delete_room/{id}', [AdminController::class, 'delete_room'])->name('delete.room');
    Route::get('/update_room/{id}', [AdminController::class, 'update_room'])->name('update.room');
    Route::post('/edit_room/{id}', [AdminController::class, 'edit_room'])->name('edit.room');

    Route::get('/payments', [AdminController::class, 'payments'])->name('admin.payments');
    Route::post('/admin/payments/{id}/mark-paid', [AdminController::class, 'markPaymentAsPaid'])->name('admin.mark_paid');

    Route::get('/create_staff', [AdminController::class, 'create_staff_form'])->name('admin.create_staff_form');
    Route::post('/create_staff', [AdminController::class, 'create_staff'])->name('admin.create_staff');
    Route::get('/view_staff', [AdminController::class, 'view_staff'])->name('admin.view_staff');
    Route::get('/update_staff/{id}', [AdminController::class, 'update_staff'])->name('admin.update_staff');
    Route::post('/edit_staff/{id}', [AdminController::class, 'edit_staff'])->name('admin.edit_staff');
    Route::get('/delete_staff/{id}', [AdminController::class, 'delete_staff'])->name('admin.delete_staff');
});
