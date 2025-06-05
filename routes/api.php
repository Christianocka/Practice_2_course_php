<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToDoController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\UserController;

// Маршруты для задач (ToDo)
Route::get('/tasks', [ToDoController::class, 'index']); // Получить все задачи
Route::post('/tasks', [ToDoController::class, 'create']); // Создать задачу
Route::put('/tasks/{id}', [ToDoController::class, 'update']); // Обновить задачу
Route::patch('/tasks/{id}/refresh', [ToDoController::class, 'refresh']); // Изменить статус задачи
Route::delete('/tasks/{id}', [ToDoController::class, 'delete']); // Удалить задачу

// Маршруты для добавления файлами
Route::post('/upload', [FileUploadController::class, 'upload'])->name('file.upload'); // Загрузка файлов


// Маршрут для авторизации пользователя
Route::post('/login', [UserController::class, 'authorization']);
Route::post('/register', [UserController::class, 'register']); // Регистрация пользователя    
