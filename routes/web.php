<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseReportController;
use App\Http\Controllers\ExpenseReportExtraFeeController;

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

Route::resource('report', ExpenseReportController::class);

// Nested Controllers
Route::resource('expenseReports.extraFees', ExpenseReportExtraFeeController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
