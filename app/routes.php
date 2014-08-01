<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/','BaseController@getIndex');
Route::get('/update-question','BaseController@getUpdateQuestion');
//Route::controller('account','AccountController');
  Route::group(array('prefix'=>'admin','before'=>'admin'),function(){
    Route::get('/','App\Controllers\Admin\ControllerBase@getIndex');
    Route::controller('user','App\Controllers\Admin\UserController');
  });
  // College section
  Route::group(array('prefix'=>'college','before'=>'college'),function(){
    Route::get('/','App\Controllers\College\ControllerBase@getIndex');
    Route::controller('user','App\Controllers\College\UserController');
    Route::controller('question','App\Controllers\College\QuestionController');
    Route::controller('score','App\Controllers\College\ScoreController');
  });
  
  // Student section
  Route::group(array('prefix'=>'student','before'=>'student'),function(){
    Route::get('/','App\Controllers\Student\IndexController@getIndex');
    Route::controller('test','App\Controllers\Student\TestController');
  });

  Route::controller('cases','CasesController');
  Route::get('account/activate/{code}','AccountController@getActivate');
  Route::get('account/ppt','AccountController@getPpt');
  Route::group(array('before'=>'auth'),function(){
  Route::get('account/logout','AccountController@getLogout');
  Route::get('account/change-password','AccountController@getChangePassword');
  Route::post('account/change-password','AccountController@postChangePassword');
  Route::get('account/create-password','AccountController@getCreatePassword');
});
Route::group(array('before'=>'guest'),function(){
   Route::get('account/create','AccountController@getCreate');
   Route::post('account/create','AccountController@postCreate');
   Route::post('account/login','AccountController@postLogin');
   Route::get('account/login','AccountController@getLogin');
   Route::get('account/forget-password','AccountController@getForgetPassword');
   Route::post('account/forget-password','AccountController@postForgetPassword');
   Route::get('account/recover/{code}','AccountController@getRecover');
   Route::get('account/ppt','AccountController@getPpt()');
});
Route::get('/phpinfo',function(){ phpinfo(); });
Route::group(array('before'=>'auth'),function(){

});
Route::get('/sess',function(){print_r(Session::all()); });
Route::get('/sess2',function(){ Session::forget('developers'); });


