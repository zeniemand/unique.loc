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


//Маршруты для вывода страниц админки:
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function (){

    //Главная страница админки:
    Route::get('/', function (){
        if(view()->exists('admin.index')){
            $data = ['title' => 'Главная панель администратора'];
            return view('admin.index', $data);
        }
    });

    //Раздел редактирования страниц:
    Route::group(['prefix' => 'pages'], function (){

        Route::get('/',['uses' => 'PagesController@execute','as' => 'pages']);

        //Добавление страницы:
        Route::match(['get', 'post'], '/add', ['uses' => 'PagesAddController@execute', 'as' => 'pagesAdd']);

        //Редактирование страницы:
        Route::match(['get', 'post', 'delete'], '/edit/{page}', ['uses' => 'PagesEditController@execute', 'as' => 'pagesEdit']);

    });

    //Раздел редактирования портфолио:
    Route::group(['prefix'=> 'portfolios'], function(){

        Route::get('/', ['uses' => 'PortfolioController@execute', 'as' => 'portfolio']);

        //Добавление портфолио:
        Route::match(['get','post'], '/add', ['uses' => 'PortfolioAddController@execute', 'as' => 'portfolioAdd']);

        //Редактирвоание портфйолио:
        Route::match(['get', 'post', 'delete'], '/edit/{portfolio}', ['uses' => 'PortfolioEditController@execute', 'as' => 'portfolioEdit']);

    });



});

//Маршруты для вывода внешней части веб приложения:
Route::group([], function (){

    Route::match(['get', 'post'], '/', ['uses' => 'IndexController@execute', 'as' => 'home'] );

    Route::get('/page/{alias}',['uses'=>'PageController@execute','as'=>'page']);

    Auth::routes();
});



Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

