<?php

use App\Http\Controllers\AdminBukuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BukuApiController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\UserController;
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



//public
// Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
// Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/', [BukuController::class, 'index'])->middleware('auth');
Route::resource('pemesanan', PemesananController::class)->names('pemesanan');

//admin
Route::get('/admin', [AdminController::class, 'index']);
Route::resource('admin/kategori', KategoriController::class)->names('kategori');
// Route::resource('admin/buku', AdminBukuController::class)->names('aminbuku')->middleware('auth');
Route::resource('admin/buku', AdminBukuController::class)->names('adminbuku');

//Login
Route::get('/login', function () {return view('public.login');})->name("login");
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/ceklogin', [LoginController::class, 'login'])->name('ceklogin');
Route::resource('admin/user', UserController::class)->names('users');

// Api
Route::apiResource('api/buku', BukuApiController::class)->names('api.buku');
Route::get('/api/buku/getone/(:segment)', [BukuApiController::class, 'show']);
Route::post('api/buku/store', [BukuApiController::class, 'store'])->withoutMiddleware(['web', 'auth']);
Route::post('api/buku/update', [BukuApiController::class, 'update']);
Route::post('api/buku/delete', [BukuApiController::class, 'destroy'])->withoutMiddleware(['web', 'auth']);
Route::post('/api/login', [LoginController::class, 'loginAPI']);
Route::get('/api/login', [LoginController::class, 'loginAPI']);

Route::post('/api/pemesanan', [PemesananController::class, 'storeApi'])->withoutMiddleware(['web', 'auth']);
Route::post('/api/pemesanandelete', [PemesananController::class, 'apiDestroy'])->withoutMiddleware(['web', 'auth']);
Route::get('/api/pemesanangetone', [PemesananController::class, 'dataPemesanan'])->withoutMiddleware(['web', 'auth']);

// Route::apiResource('api/kategori', KategoriController::class)->names('api.kategori');
// Route::apiResource('api/user', UserController::class)->names('api.user');
