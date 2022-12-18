<?php

use App\Http\Controllers\ChangePasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GuardiaController;

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


Route::get('home', [HomeController::class, 'index'])->name('home');
Route::get('change-password', [ChangePasswordController::class, 'index']);
Route::post('change-password', [ChangePasswordController::class, 'changePassword'])->name('change.password');
Route::get('guardias/UserPDF', [App\Http\Controllers\GuardiaController::class, 'UserPDF'])->name('UserPDF.pdf');

Auth::routes();

Route::group(['middleware' => ['admin']], function () {
    Route::get('guardias/pdf', [App\Http\Controllers\GuardiaController::class, 'pdf'])->name('guardias.pdf');
    Route::resource('guardias', App\Http\Controllers\GuardiaController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('festivos', App\Http\Controllers\FestivoController::class);
    Route::resource('guardiasPS', App\Http\Controllers\GuardiaControllerPS::class);
    Route::resource('guardiasSS', App\Http\Controllers\GuardiaControllerSS::class);
    Route::get('generar.guardiasPS',[App\Http\Controllers\GuardiaControllerPS::class,'guardias'])->name('generar.guardiasPS');
    Route::get('generar.guardiasSS',[App\Http\Controllers\GuardiaControllerSS::class,'guardias'])->name('generar.guardiasSS');
    Route::get('guardias.truncate', [App\Http\Controllers\GuardiaControllerPS::class,'truncate'])->name('guardias.truncate');
    Route::get('prueba/{semestre}', [ GuardiaController::class, 'generateGuardia' ]);
});
Route::get('/logout', function(){
    Auth::logout();
    return Redirect::to('login');
});
