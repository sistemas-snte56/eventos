<?php

use App\Livewire\ShowHome;
use App\Livewire\CastillaMujeres;
use App\Livewire\ShearchParticipante;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', ShowHome::class)->name('home');
Route::get('/search-participante', ShearchParticipante::class)->name('search-participante');
Route::get('/cartilla-mujeres', CastillaMujeres::class)->name('cartilla-mujeres');