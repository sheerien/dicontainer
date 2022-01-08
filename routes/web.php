<?php

use Dic\Container\HTTP\Route;
use App\Controllers\HomeController;

// Route::get('/', function($name){
//     echo "Hello " . $name[1];
// });
// Route::get('/', function(){
//     echo "Hello ";
// });

Route::get('/', [HomeController::class, 'index']);
// Route::get('/home', 'HomeController@index');