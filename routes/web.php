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
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    // categorias
    Route::get('/categorias', 'CategoriasController@index')->name('categorias');
    Route::post('/categorias/store', 'CategoriasController@store')->name('categorias.store');
    // tarefas
    Route::get('/tarefas', 'TarefasController@index')->name('tarefas');
    Route::post('/tarefas/store', 'TarefasController@store')->name('tarefas.store');
    Route::get('/tarefas/{id}/work', 'TarefasController@work')->name('tarefas.play');
    Route::post('/tarefas/upWork', 'TarefasController@upWork')->name('tarefas.update');
    Route::post('/tarefas/cicloWork', 'TarefasController@cicloWork')->name('tarefas.ciclos');
    Route::post('/tarefas/storeComments', 'TarefasController@storeComments')->name('tarefas.storeComments');
    Route::post('/tarefas/finish', 'TarefasController@finish')->name('tarefas.finish');
    Route::post('/tarefas/lixeira', 'TarefasController@lixeira')->name('tarefas.lixeira');

    // tarefas por data
    Route::get('/tarefas/{date}/list', 'TarefasController@listData')->name('tarefas.lista');

    // relatorios
    Route::get('relatorios/workday', 'RelatoriosController@workDay')->name('relatorios.workDay');

});

Route::get('/home', 'HomeController@index')->name('home');
