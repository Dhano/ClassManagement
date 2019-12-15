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

/**
 * A group that first authenticates the user and if the user is not authenticated then redirects him/her to the login page.
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;


/*Researched Routes*/
/*Route::get('/mail', 'DashboardController@mail');*/
//Route::redirect('/', '/home');
//Route::get('/home','HomeController@index');
////Route::get('/img/{path}','HomeController@img');
//Route::get('/img/{parameters?}', 'HomeController@img')->where('parameters', '.*');
//
//Route::post('process', function (Request $request) {
//    $path = $request->file('photo')->store('photos');
//
//    dd($path);
//});


Route::middleware(['auth'])->group(function () {

    /** GENERAL ROUTES*/

    Route::redirect('/', '/dashboard');
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

    /** ADMIN ROUTES*/
    Route::group(['middleware'=> ['role:Admin']], function () {

        /*Enquiry*/
        Route::get('/enquiry/get-enquiry', 'EnquiryController@getEnquiry');
        Route::resource('/enquiry', 'EnquiryController');

        Route::get('/publications/get-publications', 'PublicationsController@getPublications');
        Route::resource('/pub', 'PublicationsController');

    });

});
Auth::routes();
