<?php

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
    //return view('welcome');
	return redirect('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/cso', 'CsoController@index');

Route::get('/kriteria', 'KriteriaController@index');
Route::post('/tambah/kriteria', 'KriteriaController@tambah');
Route::post('/ubah/kriteria/{id}', 'KriteriaController@ubah');
Route::get('/reset_kriteria', 'KriteriaController@reset');

Route::get('/alternatif', 'AlternatifController@index');
Route::post('/tambah/alternatif', 'AlternatifController@tambah');
Route::post('/ubah/alternatif/{id}', 'AlternatifController@ubah');
Route::get('/reset_alternatif', 'AlternatifController@reset');

Route::get('/nilai_bobot_kriteria', 'Nilai_bobot_kriteriaController@index');
Route::post('/tambah/nilai_bobot_kriteria', 'Nilai_bobot_kriteriaController@tambah');
Route::post('/ubah/nilai_bobot_kriteria', 'Nilai_bobot_kriteriaController@ubah');

Route::get('/nilai_bobot_alternatif', 'Nilai_bobot_alternatifController@index');
Route::post('/tambah/nilai_bobot_alternatif', 'Nilai_bobot_alternatifController@tambah');
Route::post('/ubah/nilai_bobot_alternatif', 'Nilai_bobot_alternatifController@ubah');

Route::get('/perhitungan', 'PerhitunganController@index');

Route::get('/upload', 'UploadController@index');
Route::post('/tambah/upload', 'UploadController@tambah');
