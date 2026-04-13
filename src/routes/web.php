<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Route::middleware(['guest'])->group(function() {
//     //
// });
Route::get('/login', [LoginController::class,'showLoginForm'])->name("login");          // Tela de login
Route::post('/login', [LoginController::class,'login'])->name("validateLogin");         // Validação do login
Route::get('/token', [LoginController::class,'token'])->name("token");                  // Tela do Token
Route::post('/token', [LoginController::class,'validateToken'])->name("validateToken"); // Validação do Token

Route::get('logout', [LoginController::class,'logout'])->name('logout');           // Rota para sair da plataforma
Route::post('logout', [LoginController::class,'logout'])->name('postLogout');      // Rota para sair da plataforma


Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth:cliente,contabil'])->group(function() {
    Route::get('/dashboard/contabil', [HomeController::class, 'contabil'])->name('home_contabil');
    
    Route::get('/dashboard/cliente', [HomeController::class, 'cliente'])->name('home_cliente');
});
