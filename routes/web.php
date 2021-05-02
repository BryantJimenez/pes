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

/////////////////////////////////////// AUTH ////////////////////////////////////////////////////
Auth::routes(['register' => false]);
Route::get('/usuarios/email', 'AdminController@emailVerifyAdmin');
Route::post('/colonias/agregar', 'AdminController@addColonies');
Route::post('/secciones/agregar', 'AdminController@addSections');
Route::post('/promotores/agregar', 'AdminController@addPromoters');

/////////////////////////////////////////////// WEB ////////////////////////////////////////////////
Route::get('/', 'WebController@index')->name('home');
Route::get('/promotores/{slug}', 'WebController@promoter')->name('web.promoter');
Route::post('/promotores/{slug}', 'WebController@promoterStore')->name('web.promoter.store');

Route::group(['middleware' => ['auth', 'admin']], function () {
	/////////////////////////////////////// ADMIN ///////////////////////////////////////////////////

	// Inicio
	Route::get('/admin', 'AdminController@index')->name('admin');
	Route::get('/admin/perfil', 'AdminController@profile')->name('profile');
	Route::get('/admin/perfil/editar', 'AdminController@profileEdit')->name('profile.edit');
	Route::put('/admin/perfil/', 'AdminController@profileUpdate')->name('profile.update');

	// Usuarios
	Route::get('/admin/usuarios', 'UserController@index')->name('usuarios.index')->middleware('permission:users.index');
	Route::get('/admin/usuarios/registrar', 'UserController@create')->name('usuarios.create')->middleware('permission:users.create');
	Route::post('/admin/usuarios', 'UserController@store')->name('usuarios.store')->middleware('permission:users.create');
	Route::get('/admin/usuarios/{slug}', 'UserController@show')->name('usuarios.show')->middleware('permission:users.show');
	Route::get('/admin/usuarios/{slug}/editar', 'UserController@edit')->name('usuarios.edit')->middleware('permission:users.edit');
	Route::put('/admin/usuarios/{slug}', 'UserController@update')->name('usuarios.update')->middleware('permission:users.edit');
	Route::delete('/admin/usuarios/{slug}', 'UserController@destroy')->name('usuarios.delete')->middleware('permission:users.delete');
	Route::put('/admin/usuarios/{slug}/activar', 'UserController@activate')->name('usuarios.activate')->middleware('permission:users.active');
	Route::put('/admin/usuarios/{slug}/desactivar', 'UserController@deactivate')->name('usuarios.deactivate')->middleware('permission:users.deactive');

	// Códigos Postales
	Route::get('/admin/postales', 'ZipController@index')->name('postales.index')->middleware('permission:zip.index');
	Route::get('/admin/postales/registrar', 'ZipController@create')->name('postales.create')->middleware('permission:zip.create');
	Route::post('/admin/postales', 'ZipController@store')->name('postales.store')->middleware('permission:zip.create');
	Route::get('/admin/postales/{slug}/editar', 'ZipController@edit')->name('postales.edit')->middleware('permission:zip.edit');
	Route::put('/admin/postales/{slug}', 'ZipController@update')->name('postales.update')->middleware('permission:zip.edit');
	Route::delete('/admin/postales/{slug}', 'ZipController@destroy')->name('postales.delete')->middleware('permission:zip.delete');
	Route::put('/admin/postales/{slug}/activar', 'ZipController@activate')->name('postales.activate')->middleware('permission:zip.active');
	Route::put('/admin/postales/{slug}/desactivar', 'ZipController@deactivate')->name('postales.deactivate')->middleware('permission:zip.deactive');

	// Colonias
	Route::get('/admin/colonias', 'ColonyController@index')->name('colonias.index')->middleware('permission:colonies.index');
	Route::get('/admin/colonias/registrar', 'ColonyController@create')->name('colonias.create')->middleware('permission:colonies.create');
	Route::post('/admin/colonias', 'ColonyController@store')->name('colonias.store')->middleware('permission:colonies.create');
	Route::get('/admin/colonias/{slug}/editar', 'ColonyController@edit')->name('colonias.edit')->middleware('permission:colonies.edit');
	Route::put('/admin/colonias/{slug}', 'ColonyController@update')->name('colonias.update')->middleware('permission:colonies.edit');
	Route::delete('/admin/colonias/{slug}', 'ColonyController@destroy')->name('colonias.delete')->middleware('permission:colonies.delete');
	Route::put('/admin/colonias/{slug}/activar', 'ColonyController@activate')->name('colonias.activate')->middleware('permission:colonies.active');
	Route::put('/admin/colonias/{slug}/desactivar', 'ColonyController@deactivate')->name('colonias.deactivate')->middleware('permission:colonies.deactive');

	// Secciones
	Route::get('/admin/secciones', 'SectionController@index')->name('secciones.index')->middleware('permission:sections.index');
	Route::get('/admin/secciones/registrar', 'SectionController@create')->name('secciones.create')->middleware('permission:sections.create');
	Route::post('/admin/secciones', 'SectionController@store')->name('secciones.store')->middleware('permission:sections.create');
	Route::get('/admin/secciones/{slug}/editar', 'SectionController@edit')->name('secciones.edit')->middleware('permission:sections.edit');
	Route::put('/admin/secciones/{slug}', 'SectionController@update')->name('secciones.update')->middleware('permission:sections.edit');
	Route::delete('/admin/secciones/{slug}', 'SectionController@destroy')->name('secciones.delete')->middleware('permission:sections.delete');
	Route::put('/admin/secciones/{slug}/activar', 'SectionController@activate')->name('secciones.activate')->middleware('permission:sections.active');
	Route::put('/admin/secciones/{slug}/desactivar', 'SectionController@deactivate')->name('secciones.deactivate')->middleware('permission:sections.deactive');

	// Informes
	Route::get('/admin/informes', 'ReportController@index')->name('informes.index')->middleware('permission:reports.index');
});