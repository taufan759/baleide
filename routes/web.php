<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\VoucherController;

# Admin Controllers
use App\Http\Controllers\User\MyBookController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\DashboardController as DashboardUser;
use App\Http\Controllers\Admin\DashboardController as DashboardAdmin;
use App\Http\Controllers\Admin\ManageMaster\UserController as UserAdmin;
# Sales Controllers
use App\Http\Controllers\Admin\TransactionController as TransactionAdmin;
use App\Http\Controllers\Admin\ManageMaster\EbookController as EbookAdmin;
use App\Http\Controllers\Admin\ManageMaster\VoucherController as VoucherAdmin;
use App\Http\Controllers\Admin\ManageMaster\CategoryController as CategoryAdmin;

/*
|--------------------------------------------------------------------------
| Web Routes develop by kuli it tecno
|--------------------------------------------------------------------------
*/

# -------------------- AUTH --------------------
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::get('/register', [AuthController::class, 'registerView'])->name('register');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:3,60');

Route::middleware('auth')->group(function () {
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');
});

# -------------------- Guest --------------------
Route::get('/', [GuestController::class, 'home'])->name('home');
Route::get('/ebook', [GuestController::class, 'allBooks'])->name('allBooks');
Route::get('/ebook/{slug}', [GuestController::class, 'showEbook'])->name('ebook.show');
Route::get('/category/{slug}', [GuestController::class, 'showCategory'])->name('category.show');
Route::get('/cart', [GuestController::class, 'showCart'])->name('cart.show');
Route::post('/cart/fetch', [GuestController::class, 'fetchCart'])->name('cart.fetch');
Route::post('/voucher/check', [VoucherController::class, 'checkVoucher'])->name('voucher.check');
Route::post('/checkout', [GuestController::class, 'checkout'])->name('checkout');
Route::get('/checkout/{slug}', [GuestController::class, 'buyNow'])->name('checkout.buyNow')->middleware('auth');
Route::post('/process-direct-checkout', [GuestController::class, 'processDirectCheckout'])->name('checkout.processDirect');
Route::post('/midtrans/callback', [GuestController::class, 'callback'])->name('midtrans.callback')->middleware('auth');
Route::get('/checkout-success', [GuestController::class, 'success'])->name('checkout.success');
Route::get('/contact', [GuestController::class, 'contact'])->name('contact');
Route::post('/contact', [GuestController::class, 'contactSend'])->name('contact.send');

# -------------------- ADMIN --------------------
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    # Dashboard
    Route::get('/', [DashboardAdmin::class, 'index']);

    # Manage Data Member
    Route::prefix('manage-master')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/', [UserAdmin::class, 'index']);
            Route::post('/', [UserAdmin::class, 'create']);
            Route::get('all', [UserAdmin::class, 'getall']);
            Route::post('get', [UserAdmin::class, 'get']);
            Route::post('update', [UserAdmin::class, 'update']);
            Route::delete('/', [UserAdmin::class, 'delete']);
        });
        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryAdmin::class, 'index']);
            Route::post('/', [CategoryAdmin::class, 'create']);
            Route::get('all', [CategoryAdmin::class, 'getall']);
            Route::post('get', [CategoryAdmin::class, 'get']);
            Route::post('update', [CategoryAdmin::class, 'update']);
            Route::delete('/', [CategoryAdmin::class, 'delete']);
        });
        Route::prefix('voucher')->group(function () {
            Route::get('/', [VoucherAdmin::class, 'index']);
            Route::post('/', [VoucherAdmin::class, 'create']);
            Route::get('all', [VoucherAdmin::class, 'getall']);
            Route::post('get', [VoucherAdmin::class, 'get']);
            Route::post('update', [VoucherAdmin::class, 'update']);
            Route::delete('/', [VoucherAdmin::class, 'delete']);
        });
        Route::prefix('ebook')->group(function () {
            Route::get('/', [EbookAdmin::class, 'index']);
            Route::post('/', [EbookAdmin::class, 'create']);
            Route::get('all', [EbookAdmin::class, 'getall']);
            Route::post('get', [EbookAdmin::class, 'get']);
            Route::post('update', [EbookAdmin::class, 'update']);
            Route::delete('/', [EbookAdmin::class, 'delete']);
        });
    });

    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionAdmin::class, 'index']);
        Route::get('all', [TransactionAdmin::class, 'getall']);
        Route::get('print', [TransactionAdmin::class, 'print']);
        Route::get('show/{id}', [TransactionAdmin::class, 'show']);
    });
});

# -------------------- USER DASHBOARD --------------------
Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    
    # Menu Dashboard
    Route::get('/', [DashboardUser::class, 'index']);

    # Menu Buku Saya (My Books)
    Route::prefix('my-books')->group(function () {
        Route::get('/', [MyBookController::class, 'index']);
        Route::get('/{slug}', [MyBookController::class, 'show']);
    });

    # Menu Riwayat Pesanan (Transactions)
    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index']);
        Route::get('/{id}', [TransactionController::class, 'show']);
    });

    # Menu Profil Saya
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index']);
        Route::put('/update', [ProfileController::class, 'update']);
        Route::put('/password', [ProfileController::class, 'updatePassword']);
    });

});