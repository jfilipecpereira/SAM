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
    return view('auth.login');
});

//Rota de roteamento de users e também rota principal
Route::get('/home', 'HomeController@index')->name('home');


Route::get('logout', 'Auth\LoginController@logout', function () {
    return view('auth.login');
});



Auth::routes(['verify' => false]);
Auth::routes(['register' => false]);

//--------------------------------------------------------------------------------------------
//              Rotas de Super Utilizador
//--------------------------------------------------------------------------------------------
Route::middleware(['auth', 'superUser'])->name('SuperUser')->group(function () {

    //Route para ver -> rota principal
    Route::get('/super-user/ver', 'SuperUserController@index')->name('ver');

    //Route para ver -> rota principal
    Route::get('/super-user', 'SuperUserController@index')->name('verp');

    //Route para apagar
    Route::delete('/super-user/apagar/{id}', 'SuperUserController@apagar')->name('apagar');

    //Route para Registar
    Route::get('/super-user/adicionar', 'Auth\RegisterController@showRegistrationForm')->name('adicionar');

    //Route para form de editar
    Route::get('/super-user/editarForm/{id}', 'SuperUserController@showEditForm')->name('formEditar');

    //Route para metodo de atualizar
    Route::patch('/super-user/update/{id}', 'SuperUserController@update')->name('update');


});

//--------------------------------------------------------------------------------------------
//              Rotas de Direção
//--------------------------------------------------------------------------------------------
Route::middleware(['auth', 'Direcao'])->name('Direcao')->group(function () {
    //Route para ver -> rota pricipal
    Route::get('/direcao', 'DirecaoController@index')->name('ver');

    //Routa para o ajax ir buscar a datatable
    Route::get('/direcao/datatable', 'DirecaoController@dataTable')->name('datatable');

    Route::get('/direcao/teste', 'DirecaoController@getTabelaModulos')->name('teste');;

});


//--------------------------------------------------------------------------------------------
//              Rotas de Secretaria
//--------------------------------------------------------------------------------------------
Route::middleware(['auth', 'secretaria'])->name('Secretaria')->group(function () {
    //Route para ver -> rota pricipal
    Route::get('/secretaria', 'SecretariaController@index')->name('indexSecretaria');

    Route::get('/secretaria/ver-alunos', 'SecretariaController@query')->name('perguntar');

    //Route para apagar
    Route::delete('/secretaria/apagar/{id}', 'SecretariaController@apagar')->name('apagar');

    Route::get('/secretaria/editarAluno/{id}', 'SecretariaController@showEditForm')->name('editarAluno');

    Route::get('/secretaria/csv', 'SecretariaController@showCSV')->name('testecsv');

    Route::post('/secretaria/uploadFile/', 'SecretariaController@uploadCSV')->name('uploadCSV');
    Route::get('/secretaria/uploadFile', 'SecretariaController@uploadCSV')->name('uploadCSV');

    //Route para metodo de atualizar
    Route::patch('/secretaria/update/{id_user}', 'SecretariaController@update')->name('update');

    //Routa para o ajax ir buscar a datatable
    Route::get('/secretaria/datatable', 'SecretariaController@dataTable')->name('datatable');

});

//--------------------------------------------------------------------------------------------
//              Rotas de Aluno
//--------------------------------------------------------------------------------------------
Route::middleware(['auth', 'Aluno'])->name('Aluno')->group(function () {
    //Route para ver -> rota pricipal
    Route::get('/aluno/', 'AlunoController@index')->name('inicial');
    //Routa para o ajax ir buscar a datatable
    Route::get('/aluno/datatable/', 'AlunoController@alunodataTable')->name('datatable');
});



