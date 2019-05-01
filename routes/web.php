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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::user()){

        return redirect()->route('dashboard');
    }
    return view('signinUser');
})->name('userhome');

Route::get('/signupUser', function () {
    return view('signupUser');
})->name('signupUser');

Route::post('/signup',[
    'uses' => 'UserController@postSignUp',
    'as'   => 'signup'
]);

Route::post('/signin',[
    'uses' => 'UserController@postSignIn',
    'as'   => 'signin'
]);

Route::get('/dashboard',[
    'uses' => 'contactController@getDashboard',
    'as'   => 'dashboard',
    'middleware' => 'auth'
]);

Route::post('/createcontact',[
    'uses' => 'contactController@createContact',
    'as' => 'contact.create',
    'middleware' => 'auth'
]);

Route::post('/updatecontact',[
    'uses' => 'contactController@updateContact',
    'as' => 'update',
    'middleware' => 'auth'
]);

Route::post('/updateaccount', [
    'uses' => 'UserController@updateAccount',
    'as' => 'account.save'
]);

Route::get('/userimage/{filename}',[
    'uses' => 'UserController@userImage',
    'as' => 'account.image',
    'middleware' => 'auth'
]);


Route::get('/delete-contact/{contact_id}',[
    'uses' => 'contactController@deleteContact',
    'as' => 'contact.delete',
    'middleware' => 'auth'
]);

Route::get('/logout',[
    'uses' => 'UserController@getLogout',
    'as' => 'logingout'
]);

Route::get('/account',[
    'uses' => 'UserController@getAccount',
    'as' => 'account'
]);

Route::get('/user/verify/{token}',[
    'uses' => 'UserController@verifyUser',
    'as' => 'verify.user'
]);

Route::get('/contactfile',[
    'uses' => 'contactController@userContacts',
    'as' => 'user.contacts',
    'middleware' => 'auth'
]);

Route::post('/changepassword', [
    'uses' => 'UserController@changePassword',
    'as' => 'change.password',
    'middleware' => 'auth'
]);







Route::get('/user/passreset',function (){
    return view('passReset');
})->name('resetpass');

Route::post('/passresetlink', [
    'uses' => 'UserController@passresetLink',
    'as' => 'passreset.link'
]);

Route::get('/user/passreset/{token}',[
    'uses' => 'UserController@passresetToken',
    'as' => 'pass.reset'
]);

Route::post('/user/passreset', [
    'uses' => 'UserController@resetPassword',
    'as' => 'reset.pass'
]);

Route::post('/import/contacts',[
    'uses' => 'contactController@importContacts',
    'as' => 'import.contacts'
]);

Route::get('/aboutMe',function (){
    return view('contactUs');
})->name('about.me');




Route::any('{all}', function(){
    return view('notfound');
})->where('all', '.*');