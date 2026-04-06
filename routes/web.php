<?php

use Illuminate\Support\Facades\Route;

// ====================
// Controllers User
// ====================
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ChatController;

// ====================
// Controllers Admin
// ====================
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BannerController;

use App\Http\Controllers\PetugasController;

use App\Http\Controllers\Petugas\LaporanController;

// ====================
// HOME
// ====================
Route::get('/', [HomeController::class, 'index'])->name('home');


// ====================
// ADMIN
// ====================
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

       Route::get('/dashboard', [DashboardController::class, 'index'])
   ->name('dashboard');
   
        Route::resource('categories', CategoryController::class);
        Route::resource('brands', BrandController::class);
        Route::resource('products', AdminProductController::class);
        // ORDERS ADMIN
        // ORDERS ADMIN (hanya untuk memantau)
Route::get('/orders', [\App\Http\Controllers\Admin\AdminOrderController::class, 'index'])
    ->name('orders');
    });
   


// ====================
// USER PRODUCTS
// ====================
Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/kategori/{slug}', [ProductController::class, 'showCategory'])
    ->name('kategori.show');

Route::get('/produk/{id}', [ProductController::class, 'show'])
    ->name('products.show');


// ====================
// SEMUA YANG BUTUH LOGIN
// ====================
Route::middleware('auth')->group(function () {

    // ====================
    // TRANSAKSI / PINJAM
    // ====================
    Route::get('/transaksi/{id}', [TransaksiController::class, 'create'])
        ->name('transaksi.create');

    Route::post('/transaksi', [TransaksiController::class, 'store'])
        ->name('transaksi.store');

    Route::get('/transaksi/{id}/invoice', [TransaksiController::class, 'invoice'])
        ->name('transaksi.invoice');


    // ====================
    // CART
    // ====================
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    Route::match(['post', 'delete'], '/cart/checkout-selected',
        [CartController::class, 'checkoutSelected'])
        ->name('cart.checkoutSelected');


    // ====================
    // CHECKOUT
    // ====================
    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout/process', [CheckoutController::class, 'process'])
        ->name('checkout.process');

    Route::get('/checkout/success', fn () => view('checkout-success'))
        ->name('checkout.success');


    // ====================
    // ORDERS
    // ====================
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/orders/{id}', [OrderController::class, 'show'])
        ->name('orders.show');


    // ====================
    // PROFILE
    // ====================
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])
        ->name('profile.update-photo');

    Route::get('/account', fn () => view('profile.account'))
        ->name('account');
});

// ====================
/// ====================
// PETUGAS
// ====================
Route::middleware(['auth','petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {

Route::get('/dashboard', [PetugasController::class, 'dashboard'])
    ->name('dashboard');

       Route::get('/orders', [PetugasController::class, 'orders'])
    ->name('orders');
           
Route::put('/orders/{id}/status', [PetugasController::class, 'updateStatus'])
    ->name('orders.updateStatus'); // <<< ini yang bener

    Route::put('/transaksi/{id}/update-status', [PetugasController::class, 'updateStatus'])
        ->name('transaksi.updateStatus');

        // ✅ LIST CHAT
        Route::get('/chat', [\App\Http\Controllers\PetugasChatController::class, 'index'])
            ->name('chat.index');

        // ✅ DETAIL CHAT (INI YANG DIPINDAH)
        Route::get('/chat/{user}', [\App\Http\Controllers\PetugasChatController::class, 'show'])
            ->name('chat.show');

        // ✅ KIRIM PESAN
        Route::post('/chat/store', [\App\Http\Controllers\PetugasChatController::class, 'store'])
            ->name('chat.store');

        // 🔥 Route Laporan
     Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan'); // <-- pastikan cuma 'laporan', bukan 'petugas.laporan'
        

           
    });
// ====================
// CHAT USER
// ====================
Route::get('/chat-user', [ChatController::class, 'userChat'])->name('chat.user');
Route::post('/chat-user/send', [ChatController::class, 'sendUser'])->name('chat.user.send');



Route::prefix('admin')->group(function () {
    Route::get('/banner', [BannerController::class, 'index'])->name('admin.banner');
    Route::post('/banner/store', [BannerController::class, 'store'])->name('admin.banner.store');
    Route::delete('/banner/{id}', [BannerController::class, 'destroy'])->name('admin.banner.delete');
});

// Halaman scan QR / invoice
Route::get('/scan/{kode}', [TransaksiController::class, 'scan'])
    ->name('transaksi.scan')
    ->middleware('auth');

// Halaman invoice normal
Route::get('/transaksi/{invoice_code}/invoice', [TransaksiController::class, 'invoice'])
    ->name('transaksi.invoice')
    ->middleware('auth');
// ====================
// AUTH (BREEZE)
// ====================
require __DIR__.'/auth.php';