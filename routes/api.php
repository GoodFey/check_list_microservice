<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/telegram', [AuthController::class, 'telegramAuth']);

Route::post('/checklist', [CheckListController::class, 'store']);

Route::get('/checklist/edit/{checkListId}', [CheckListController::class, 'edit']);

Route::get('/checklist', [CheckListController::class, 'index']);

Route::patch('/checklist/changePublish/{checkListId}', [CheckListController::class, 'changePublishStatus']);

Route::delete('/checklist/delete/{checkListId}', [CheckListController::class, 'delete']);

Route::patch('/checklist/update/{checkListId}', [CheckListController::class, 'update']);


