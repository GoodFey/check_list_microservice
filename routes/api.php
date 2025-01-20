<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckListController;
use App\Http\Middleware\AuthenticateToken;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware([AuthenticateToken::class, 'auth:sanctum'])->group(function () {
    Route::get('/checklist', [CheckListController::class, 'index']);

    Route::post('/checklist', [CheckListController::class, 'store']);
    Route::get('/checklist/edit/{checkListId}', [CheckListController::class, 'edit']);
    Route::patch('/checklist/update/{checkListId}', [CheckListController::class, 'update']);
    Route::get('/test', [CheckListController::class, 'test']);
});

Route::middleware([AuthenticateToken::class, 'auth:sanctum', CheckAdmin::class])->group(function () {
    Route::get('/checklist/admin', [CheckListController::class, 'adminIndex']);
    Route::patch('/checklist/changePublish/{checkListId}', [CheckListController::class, 'changePublishStatus']);
    Route::delete('/checklist/delete/{checkListId}', [CheckListController::class, 'delete']);
});

Route::post('/auth/telegram', [AuthController::class, 'telegramAuth']);

Route::get('/auth/validate-token', function (Request $request) {
    return response()->json(['message' => 'Token is valid', 'user' => Auth::user()]);
})->middleware([AuthenticateToken::class, 'auth:sanctum']);

