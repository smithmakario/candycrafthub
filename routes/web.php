<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\MembershipPlanController;
use App\Http\Controllers\NewsletterSubscriberController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', WelcomeController::class)->name('home');

Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::post('/newsletter', [NewsletterSubscriberController::class, 'store'])->name('newsletter.store');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/orders/{order}/pay', [PaymentController::class, 'initiate'])->name('payment.initiate');
Route::get('/orders/{order}', [PaymentController::class, 'show'])->name('orders.show');

Route::view('/event-services', 'event-services.index')->name('event-services');

Route::view('/our-story', 'story.index')->name('our-story');

Route::post('/event-services/inquiries', [BookingController::class, 'storePublic'])
    ->name('bookings.store-public');

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::resource('inventory', InventoryItemController::class)
        ->parameters(['inventory' => 'inventoryItem']);
    Route::resource('bookings', BookingController::class);
    Route::resource('membership-plans', MembershipPlanController::class)
        ->parameters(['membership-plans' => 'membershipPlan']);
    Route::get('/newsletter', [NewsletterSubscriberController::class, 'index'])->name('newsletter.index');
});

Route::middleware(['auth', 'verified', 'customer'])->group(function () {
    Route::get('/account', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
