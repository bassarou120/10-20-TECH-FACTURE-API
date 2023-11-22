<?php

use App\Mail\SampleMail;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

    $content = [
        'subject' => 'TEST EMAIL',
        'body' => 'Ceci est test du serveur mail du RESHAOC '
    ];
    $password = Str::random(8);

    error_log($password);

   Mail::to('yacouboubassarou@gmail.com')->send(new SampleMail($content));
    return view('welcome');
});
