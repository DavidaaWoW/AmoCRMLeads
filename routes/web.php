<?php

use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\TokenController;

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

Route::name('user.')->group(function (){
    Route::get('/registration', function (){
        if(Auth::check()){
            return redirect(\route('leads'));
        }
        return view('auth.registration');
    })->name('registration');
    Route::get('/login', function (){
        if(Auth::check()){
            return redirect(\route('leads'));
        }
        return view('auth.login');
    })->name('login');
    Route::post('/registration', [RegistrationController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
});

Route::view('/', 'get_token')->middleware('auth')->name('homepage');

Route::get('/leads', [LeadsController::class, 'leads'])->middleware('auth')->middleware('token')->name('leads');
Route::get('/company/{id}', [CompaniesController::class, 'getCompany'])->middleware('auth')->middleware('token')->name('company');

Route::get('/getLeads', [LeadsController::class, 'getLeads'])->middleware('auth')->middleware('token')->name('getLeads');

Route::post('/getToken', [TokenController::class, 'getToken'])->middleware('auth')->name('getToken');
