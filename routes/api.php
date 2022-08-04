<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


// Route::group(['middleware' => ['api'] , 'namespace' => 'Api'], function () {




//cats
Route::get('categories', 'CategoryController@getCats');
Route::post('add-category', 'CategoryController@addCategory');
Route::post('update-category', 'CategoryController@updateCategory');
Route::post('delete-category', 'CategoryController@destroy');


Route::post('advertisements', 'AdvertisementsController@getAdvs');


Route::get('user/{id}/advertisements', 'UsersController@getUserAdvs');

Route::get('semd-email' , 'UsersController@send');


// });




Route::fallback(function () {
   return response()->json([
      'result' => false,
      'err_num' => 404,
      'message' => 'Invalid Route'
   ]);
});
