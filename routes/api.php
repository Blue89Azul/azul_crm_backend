<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\InvitationCode\InvitationCodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('/signup', 'signup');
});

Route::middleware('jwt_auth')->group(function () {
    Route::post('/invitation_codes', [InvitationCodeController::class, 'store']);
});
