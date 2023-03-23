<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('buy/{cookies}', function ($cookies) {
    $wallet = Auth::user()->wallet;
    if ($cookies > $wallet) {
        return "We donot have enough cookies to sell";
    }
    if ($wallet > 0) {
        Auth::user()->update(['wallet' => $wallet - $cookies * 1]);
        Log:info('User ' . Auth::user()->email . ' have bought ' . $cookies . ' cookies'); // we need to log who ordered and how much
        return 'Success, you have bought ' . $cookies . ' cookies!';
    }
        return 'No cookie left';
});