<?php

use App\Http\Controllers\StripeController;
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
Route::post('/setup', [StripeController::class, 'setup'])->name('setup');
Route::get('/setup', [StripeController::class, 'form'])->name('form');
Route::get('/stripe', [StripeController::class, 'index'])->name('stripe');
Route::get('/process', [StripeController::class, 'process'])->name('process');
