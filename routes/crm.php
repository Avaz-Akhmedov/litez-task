<?php

use App\Http\Controllers\Crm\ClientController;
use App\Http\Controllers\Crm\TaskController;
use Illuminate\Support\Facades\Route;


Route::patch( 'tasks/{task}/status', [TaskController::class, 'updateStatus']);

Route::get('tasks/today', [TaskController::class, 'today']);
Route::get('tasks/overdue', [TaskController::class, 'overdue']);

Route::get('/clients/{client}/tasks', ClientController::class);


Route::apiResource('tasks', TaskController::class);



