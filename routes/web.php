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

Route::get('/','QuestionsController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


Route::get('/test',function (){
//    return url('/home');
//    return route('home');
//    return action('HomeController@index');
});

// 显示当前用户的问题总数
Route::get('/user_questions/show/{id}','UserController@index');


Route::get('/email/verify/{token}','EmailController@verify')->name('verify');


Route::resource('questions','QuestionsController',['names'=>[
    'create' => 'questions.create',
    'question' => 'questions.store',
    'question' => 'questions.index',
    'show' => 'questions.show',
]]);


Route::post('questions/{question}/answer','AnswersController@store');

Route::get('question/{question}/follow','QuestionFollowController@follow');

Route::get('notifications','NotificationsController@index');
Route::get('notifications/{notification}','NotificationsController@show');


Route::get('avatar','UsersController@avatar');
Route::post('avatar','UsersController@changeAvatar');


Route::get('inbox','InboxController@index');
Route::get('inbox/{dialogId}','InboxController@show');
Route::post('inbox/{dialogId}/store','InboxController@store');

Route::get('password','PasswordController@password');
Route::post('password/update','PasswordController@update');

Route::get('settings','SettingsController@index');
Route::post('settings','SettingsController@store');


Route::resource('favorite','FavoriteController');


// githubLogin
Route::get('gitHubLogin','GitHubLoginController@github');
Route::get('github/login','GitHubLoginController@githubLogin');

//validLogin
Route::get('captcha/{random}','CaptchaController@captcha');




//多对多的关系
Route::resource('article','ArticleController');

// 测试分页的Route
Route::get('/fy','testController@show');

// 测试
Route::get('auth',function (){

//    $user = \App\User::all()->where('email','tangwtna@163.com')->first();
//    dd($user);
//    Auth::login($user);

    dd(config('services'));

});
