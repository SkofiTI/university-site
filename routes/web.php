<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/", [MainController::class, 'index']);
Route::get("/about", [MainController::class, 'aboutPage']);
Route::get("/interests", [MainController::class, 'interestPage']);
Route::get("/education", [MainController::class, 'educationPage']);
Route::get("/photo-album", [MainController::class, 'photoAlbumPage']);
Route::get("/contact", [MainController::class, 'contactPage']);
Route::get("/test", [MainController::class, 'testPage']);
Route::get("/history", [MainController::class, 'historyPage']);

Route::post("/interests", [MainController::class, 'createInterest'])->name('interest.store');
Route::post("/contact", [MainController::class, 'sendEmail'])->name('contact.send');
Route::post("/test", [MainController::class, 'sendTest'])->name('test.send');