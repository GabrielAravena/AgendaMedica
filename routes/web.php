<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;

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

Route::get('/admin/calendar/', [CalendarController::class, 'index'])->name('calendar.index');
Route::get('/admin/services/getDoctors/especialidadId/{id}', [CalendarController::class, 'getDoctors']);
Route::get('/admin/services/getHorasDisponibles/doctorId/{id}', [CalendarController::class, 'getHorasDisponibles']);
Route::post('/admin/calendar/store', [CalendarController::class, 'store'])->name('calendar.store');
Route::get('/admin/services/getEvents', [CalendarController::class, 'getEvents']);


