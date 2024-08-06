<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Mail\JobPosted;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

Route::view('/', 'home');
Route::view('/about', 'about');
Route::view('/contact', 'contact');

Route::get('/register', [RegisterUserController::class, 'create']);
Route::post('/register', [RegisterUserController::class, 'store']);
Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);

use App\Http\Controllers\BankingController;



Route::middleware('auth')->group(function () {
    Route::get('/usermenu', [BankingController::class, 'index'])->name('home');
    Route::get('/deposit', [BankingController::class, 'depositView'])->name('depositView');
    Route::post('/deposit', [BankingController::class, 'deposit'])->name('deposit');
    Route::get('/withdraw', [BankingController::class, 'withdrawView'])->name('withdrawView');
    Route::post('/withdraw', [BankingController::class, 'withdraw'])->name('withdraw');
    Route::post('/transfer', [BankingController::class, 'transfer'])->name('transfer');
    Route::get('/statement', [BankingController::class, 'statement'])->name('statement');
});
