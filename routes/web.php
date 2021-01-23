<?php
Route::get('/', function(){return redirect()->route('login'); });
Route::get('/mi-perfil', 'UserController@MiPerfil')->name('user.MiPerfil');
Route::post('/mi-perfil', 'UserController@MiPerfilUpdate')->name('user.MiPerfilUpdate');
Route::get('/historial', 'UserController@MiHistorial')->name('user.MiHistorial');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/{id}', 'HomeController@anio')->name('home.anio');
Route::get('/home/{id}/{mun}', 'HomeController@anio_mun')->name('home.anio.mun');


Route::resource('/anio', 'AnioController')->except(['edit', 'update']);
Route::post('/aniob', 'AnioController@block')->name('anio.block');
Route::get('/aniob', function (){return abort(404);});
Route::post('/aniou', 'AnioController@unblock')->name('anio.unblock');
Route::get('/aniou', function (){return abort(404);});

Route::resources([
    '/partido' => 'PartidoController',
    '/coalicion' => 'CoalicionController'
]);

Route::get('/coalicion/detach', function (){return abort(404);});
Route::post('/coalicion/detach', 'CoalicionController@detach')->name('coalicion.detach');


//Route::resource('/partido', 'PartidoController');
//Route::resource('/coalicion', 'CoalicionController');
Route::post('/partidob', 'PartidoController@block')->name('partido.block');
Route::get('/partidob', function (){return abort(404);});
Route::post('/partidou', 'PartidoController@unblock')->name('partido.unblock');
Route::get('/partidou', function (){return abort(404);});

Route::post('/coalicionb', 'CoalicionController@block')->name('coalicion.block');
Route::get('/coalicionb', function (){return abort(404);});
Route::post('/coalicionu', 'CoalicionController@unblock')->name('coalicion.unblock');
Route::get('/coalicionu', function (){return abort(404);});

Route::resource('/municipio', 'MunicipioController');
Route::resource('/seccion', 'SeccionController');

Route::resource('/lider', 'LiderController');

//Route::resource('/militante', 'MilitanteController');


//-----------------------

Route::get('/adscritos', 'AdscritoController@index')->name('adscritos.index');
Route::post('/adscritos', 'AdscritoController@store')->name('adscritos.store');
Route::get('/elecciones', 'EleccionController@index')->name('elecciones.index');
Route::post('/elecciones', 'EleccionController@store')->name('elecciones.store');