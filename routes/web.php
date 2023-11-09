<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

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

// Trasa do wyświetlania panelu pracowników pod adresem /
Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');

Route::resource('employees', EmployeeController::class);
