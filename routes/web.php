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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
// Route::get('login', 'HomeController@index')->name('login');

Route::get('/mylogin', function () {
    return view('sistem.login');
});

// ajax
Route::get('cek/daftar_barang/{nama_barang}', 'SukuCadangController@CekDaftarBarang');
Route::get('cek/suku_cadang/{nama_barang}', 'SukuCadangController@CekSukuCadang');

// menu sistem
Route::get('dashboard', function () {
    return view('sistem.dashboard');
})->middleware('auth');

Route::get('laporan_penjualan', 'PenjualanController@laporanPenjualan')->name('penjualan.laporan');
Route::get('print_pdf_penjualan', 'PenjualanController@coba_print_pdf');
Route::post('print_to_pdf/{html}', 'PenjualanController@printPdf');

Route::get('laporan_pembelian', 'PembelianController@laporanPembelian')->name('pembelian.laporan');
Route::get('print_pdf_pembelian', 'PembelianController@coba_print_pdf');
Route::post('print_to_pdf/{html}', 'PembelianController@printPdf');

Route::get('laporan_servis', 'ServisController@laporanServis')->name('servis.laporan');
Route::get('print_pdf_servis', 'ServisController@coba_print_pdf');
Route::post('print_to_pdf/{html}', 'ServisController@printPdf');

Route::get('est', 'PenjualanController@getEstimasi')->name('penjualan.est')->middleware('auth');

Route::get('est_pembelian', 'PenjualanController@getEstimasiBeli')->name('penjualan.est')->middleware('auth');

Route::resource('penjualan', 'PenjualanController');

Route::resource('suku_cadang', 'SukuCadangController');

Route::post('variable_suku_cadang/{id}', 'VariableSukuCadangController@saveOrUpdate');
Route::resource('variable_suku_cadang', 'VariableSukuCadangController');

Route::resource('pembelian', 'PembelianController');

Route::resource('servis', 'ServisController');


Route::group(['prefix' => 'suku_cadang', 'middleware' => 'auth'], function () {
	Route::get('/', 'SukuCadangController@index');	
	Route::post('/tambah', 'SukuCadangController@create')->name('suku_cadang.create');	
});

Route::group(['prefix' => 'pembelian', 'middleware' => 'auth'], function () {
	Route::get('/', 'PembelianController@index');	
	Route::post('/tambah', 'PembelianController@create')->name('pembelian.create');	
});

// Route::group(['prefix' => 'penjualan', 'middleware' => 'auth'], function () {
// 	Route::get('/', 'PenjualanController@index');	
// 	Route::post('/tambah', 'PenjualanController@create')->name('penjualan.create');	
// });

Route::group(['prefix' => 'servis', 'middleware' => 'auth'], function () {
	Route::get('/', 'ServisController@index');	
	Route::post('/tambah', 'ServisController@create')->name('servis.create');	
});


// Route::get('transaksi', function () {
//     return view('sistem.transaksi');
// })->middleware('auth');