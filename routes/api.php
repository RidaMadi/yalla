<?php
use Illuminate\Support\Facades\Route;

Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::post('/sendCode', [\App\Http\Controllers\Auth\SendCodeController::class, 'sendCode']);
Route::post('/verifyCode', [\App\Http\Controllers\Auth\VerifyCodeController::class, 'verifyCode']);
Route::post('/logout', [\App\Http\Controllers\Auth\LogOutController::class, 'logout']);
Route::post('/refresh', [\App\Http\Controllers\Auth\RefreshTokenController::class, 'refresh']);

Route::get('/cities',[\App\Http\Controllers\Address\AddressController::class,'getCities']);
