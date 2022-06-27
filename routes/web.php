<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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
    return view('pages.home');
});

Route::get('/personagens', function () {
    return view('pages.personagens');
});

Route::get('/partida/{id}', function ($id) {
    return view('pages.match', ['id' => $id]);
})->name('match');


// Middleware para proteger rotas de usuários não autenticados
Route::middleware('auth')->group(function () {

    Route::get('/admin', function () {
        return view('pages.admin.home');
    })->name('admin');


    Route::get('/umpires', function () {
        return view('pages.admin.addUmpire');
    })->name('addUmpire');


    Route::get('/match', function () {
        return view('pages.admin.refereeMatch');
    })->name('matchControl');



    Route::get('/importMatches', function () {
        return view('pages.admin.importMatches');
    })->name('importMatches');

});

// Registrando rotas de autenticação
Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);
