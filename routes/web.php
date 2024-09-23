<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/persona', 'admin.persona')->name('persona');
Route::view('/cargo', 'admin.cargo')->name('cargo');
Route::view('/vendedor', 'admin.vendedor')->name('vendedor');
Route::view('/visita', 'admin.visita')->name('visita');
Route::view('/cliente', 'admin.cliente')->name('cliente');




