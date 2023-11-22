<?php


use App\Http\Controllers\Api\ActualiteController;
use App\Http\Controllers\Api\AdherantController;
use App\Http\Controllers\Api\CotisationAdherantController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\HopitalController;
use App\Http\Controllers\Api\ParamettreController;
use App\Http\Controllers\Api\ParamImageController;
use App\Http\Controllers\Api\PayMomoController;
use App\Http\Controllers\Api\PaysMembreController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\ReshaocController;

use Illuminate\Support\Facades\Route;


Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::get('me', 'getAuthenticadUser');
});


//posts
Route::apiResource('/posts', App\Http\Controllers\Api\PostController::class);

//actualite
Route::apiResource('/actualites',  ActualiteController::class);

Route::controller( ActualiteController::class)->group(function(){
    Route::get('getActuByType', 'getByType');
    Route::get('getLastActualite', 'lastActualiate');
    Route::get('getListeEvent', 'getListeEvent');
    Route::get('getActuVedetteByType', 'getActuVedetteByType');
    Route::get('getActuVedetteByType2', 'getActuVedetteByType2');
    Route::post('updateIsVedete', 'updateIsVedete');
});


Route::apiResource('/reshaoc', ReshaocController::class);


Route::controller( ParamImageController::class)->group(function(){

    Route::post('updateOrSaveImage', 'updateOrSaveImage');
    Route::get('getAllImage', 'index');
    Route::get('getImageByType', 'getImageByType');
});


Route::apiResource('/adherant',  AdherantController::class);

Route::controller( AdherantController::class)->group(function(){
    Route::post('adherant-login', 'login');

});

Route::controller( PayMomoController::class)->group(function(){

    Route::post('addPayMomo', 'addPayMomo');
    Route::get('getAllPayMomo', 'index');

});


Route::apiResource('/paramettre',  ParamettreController::class);

Route::controller( ParamettreController::class)->group(function(){

    Route::get('getStatistque', 'getStatistque');
    Route::get('getParamettreByKey/{key}', 'getParamettreByKey');
    Route::post('updatParamettreByKey', 'updatParamettreByKey');
    Route::post('saveParamettreSite', 'saveParamettreSite');

});


Route::controller(  PaysMembreController::class)->group(function(){

    Route::get('listPays', 'listPays');
    Route::get('getPaysMembre', 'getPaysMembre');
    Route::get('getPaysByCode/{code}', 'getPaysByCode');
    Route::post('updateStatusPays', 'updateStatusPays');


});


Route::controller(   HopitalController::class)->group(function(){

    Route::post('addhopital', 'addhopital');

    Route::get('gethoptalByPays/{id}', 'gethoptalByPays');


});



Route::controller(    ReservationController::class)->group(function(){

    Route::post('addReservation', 'store');

    Route::get('getReservationByEvent/{id}', 'getReservationByEvent');
    Route::get('listReservation', 'index');


});


Route::controller(     DocumentController::class)->group(function(){

    Route::post('saveDocument', 'saveDocument');
    Route::get('listDocument', 'index');
    Route::get('listDocumentByType', 'listDocumentByType');


});


Route::controller(    CotisationAdherantController::class)->group(function(){

    Route::post('addCotisation', 'store');
    Route::get('getCotisationByAdherant/{id}', 'getCotisationByAdherant');
    Route::get('listCotisation', 'index');
    Route::get('listCotisationByAdherant', 'listCotisationByAdherant');


});

