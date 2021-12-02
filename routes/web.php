<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResultFileController;
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

Route::get('/', function () {return view('welcome');});
Auth::routes();
$user=Auth::User();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
->name('home')->middleware('verified');;


Route::get('/program/index', [ProgramController::class,'index']);
Route::get('/program/show/{program}', [ProgramController::class,'show']);
Route::get('/program/create', [ProgramController::class,'create']);
Route::post('/program/store', [ProgramController::class,'store']);


Route::get('/block/create/{program}', [BlockController::class,'create']);
Route::post('/block/store/{program}', [BlockController::class,'store']);



Route::get('/result/index', [ResultController::class, 'index']);
Route::get('/result/show/{result}', [ResultController::class, 'show']);
Route::get('/result/create/{event}', [ResultController::class, 'create']);
Route::post('/result/store', [ResultController::class, 'store']);
Route::get('/result/edit/{result}', [ResultController::class, 'edit']);
Route::get('/result/editinfo/{result}', [ResultController::class, 'editInfo']);
Route::get('/result/search', [ResultController::class, 'search']);
Route::get('/result/mail', [ResultController::class, 'mail']);
Route::patch('/result/updateinfo/{result}', [ResultController::class, 'updateInfo']);
Route::patch('/result/update/{result}', [ResultController::class, 'updateResult']);



Route::get('/event/show/{event}', [EventController::class, 'show']);
Route::get('/event/create', [EventController::class, 'create']);
Route::post('/event/store', [EventController::class, 'store']);
Route::get('/event/edit/{event}', [EventController::class, 'edit']);
Route::patch('/event/update/{event}', [EventController::class, 'update']);
Route::post('/event/lastresult/{event}', [EventController::class, 'getLastResult']);
Route::get('/event/export/{event}', [ResultFileController::class, 'exportResultExcel']);

Route::get('/user/create', [UserController::class, 'create']);


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');



Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

Route::get('/mail', function () {
    $result = App\Models\Result::find(1);

    return new App\Mail\NewResultMail($result);
});


Route::get('/lang/{locale}',function($lang){
       Session::put('locale',$lang);
       return redirect()->back();   
});
