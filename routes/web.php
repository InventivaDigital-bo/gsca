<?php

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

Route::get('/', "MainController@index")->name('index');

Route::get('/tour', "MainController@tour360")->name('tour360');
Route::get('/tour/{model}', "MainController@tour")->name('tour');
Route::get('/modelo/{model}', "MainController@model")->name('modelo');

Route::get('/por-que-chery', "MainController@chery")->name('chery');

Route::get('/experiencia-chery', "MainController@experiencia")->name('experiencia');
Route::get('/experiencia-chery/{blog}', "MainController@experienciaBlog")->name('experienciaBlog');

Route::get('/contacto', "MainController@contacto")->name('contacto');

Route::get('/concesionarios', "MainController@concesionarios")->name('concesionario');

Route::get('/servicio-tecnico', "MainController@servicio")->name('servicio');


Route::get('/loader', function(){
    return view('loader');
});
