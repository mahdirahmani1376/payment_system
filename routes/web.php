<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Support\Storage\Contracts\StorageInterface;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('basket/clear',function (StorageInterface $storage){
    $storage->clear();
});

Route::controller(ProductsController::class)->group(function (){
   Route::get('/products','index')->name('products.index');
});

Route::controller(BasketController::class)->group(function (){
    Route::get('/basket','index')->name('basket.index');
    Route::get('/basket/add/{product}','add')->name('basket.add');
    Route::post('/basket/update/{product}','update')->name('basket.update');
    Route::get('basket/checkout','checkoutForm')->name('basket.checkout.form')->middleware('auth');
    Route::post('basket/checkout', 'checkout')->name('basket.checkout');
    Route::post('payment/{gateway}/callback','verify')->name('payment.verify');
});

Route::get('/home', 'HomeController@index')->name('home');

