<?php

use App\Http\Controllers\LettersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LetterTypesController;
use App\Http\Controllers\ResultsController;
use App\Models\LetterTypes;

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






Route::middleware(['IsLogin', 'IsStaff'])->group(function () {

    Route::get('/home', [UserController::class, 'hitung'])->name('home'); 

    Route::prefix('staff')->name('staff.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('home');
        Route::get('/tambah', [UserController::class, 'tambahStaff'])->name('tambah');
        Route::post('/store', [UserController::class, 'staffStore'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'staffEdit'])->name('edit');
        Route::patch('/update/{id}', [UserController::class, 'staffUpdate'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'staffDelete'])->name('delete');
        Route::get('/search', [UserController::class, 'search'])->name('search');
    });

    Route::prefix('guru')->name('guru.')->group(function () {
        Route::get('/', [UserController::class, 'indexGuru'])->name('home');
        Route::get('/tambah', [UserController::class, 'guruCreate'])->name('create');
        Route::post('/store', [UserController::class, 'guruStore'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'guruEdit'])->name('edit');
        Route::patch('/update/{id}', [UserController::class, 'guruUpdate'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'guruDelete'])->name('delete');
        Route::get('/search', [UserController::class, 'search'])->name('search');
    });

    Route::prefix('klasifikasi')->name('klasifikasi.')->group(function () {
       Route::get('/', [LetterTypesController::class, 'index'])->name('home'); 
       Route::get('/tambah', [LetterTypesController::class, 'create'])->name('create');
        Route::post('/store', [LetterTypesController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [LetterTypesController::class, 'edit'])->name('edit');
        Route::patch('/update/{id}', [LetterTypesController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [LetterTypesController::class, 'destroy'])->name('delete');
        Route::get('/show/{id}', [LetterTypesController::class, 'show'])->name('show');

    });

    Route::prefix('surat')->name('surat.')->group(function () {
        Route::get('/', [LettersController::class, 'index'])->name('home');
        Route::get('/tambah', [LettersController::class, 'create'])->name('create');
        Route::post('/store', [LettersController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [LettersController::class, 'edit'])->name('edit');
        Route::patch('/update/{id}', [LettersController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [LettersController::class, 'destroy'])->name('delete');
        Route::get('/download/{id}', [LettersController::class, 'downloadPDF'])->name('download');
        Route::get('/print/{id}', [LettersController::class, 'show'])->name('print');
        Route::get('/search', [LettersController::class, 'search'])->name('search');
    });
});

Route::middleware(['IsLogin', 'IsGuru'])->group(function () {
    

    Route::prefix('/result')->name('result.')->group(function() {
        Route::get('/results/{id}', [ResultsController::class, 'create'] )->name('results');
        Route::post('/store', [ResultsController::class, 'store'] )->name('store');
        Route::get('/show/{id}', [ResultsController::class, 'show'] )->name('show');
});
    Route::get('/download/{id}', [LettersController::class, 'downloadPDF'])->name('download-pdf');
    Route::get('/home', [UserController::class, 'hitung'] )->name('home');
    Route::get('/data', [LettersController::class, 'index'])->name('data');
});

Route::middleware(['IsLogin'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/home', [UserController::class, 'hitung'])->name('home');
});

Route::middleware(['IsGuest'])->group(function () {
    Route::get('/', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [UserController::class, 'authLogin'])->name('authLogin'); 
});
        
Route::get('/error-permission', function() {
    return view('errors.permission');
})->name('error.permission');

Route::get('/export-excel-klasifikasi', [LetterTypesController::class, 'exportExcel'])->name('export-excel-klasifikasi');

Route::get('/export-excel-surat', [LettersController::class, 'exportExcel'])->name('export-excel-surat');
