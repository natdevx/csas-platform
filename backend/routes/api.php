<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterStudentController;
use App\Http\Controllers\Auth\RegisterStaffController;
use App\Http\Controllers\Admin\InstituteController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas API
|--------------------------------------------------------------------------
|
| Aquí están todas las rutas de la plataforma CSAS organizadas por rol.
| - Público: login, registro de estudiantes/staff
| - Protegido: CRUD y gestión de recursos según roles
|
*/

// ==== AUTH PÚBLICO ====
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register-student', [RegisterStudentController::class, 'register']);
Route::post('/register-staff', [RegisterStaffController::class, 'register']);

// ==== RUTAS PROTEGIDAS ====
Route::middleware(['auth:sanctum'])->group(function () {
    // Sesión del usuario autenticado
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | SUPERADMIN & ADMIN DE INSTITUTO
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:superadmin|admin'])->group(function () {
        // Staff (CRUD completo)
        Route::get('staff', [StaffController::class, 'index']);   // Listar
        Route::post('staff', [StaffController::class, 'store']);  // Crear
        Route::get('staff/{id}', [StaffController::class, 'show']); // Ver por ID
        Route::put('staff/{id}', [StaffController::class, 'update']); // Actualizar
        Route::delete('staff/{id}', [StaffController::class, 'destroy']); // Eliminar


        // Students (CRUD completo)
        Route::get('students', [StudentController::class, 'index']);
        Route::post('students', [StudentController::class, 'store']);
        Route::get('students/{id}', [StudentController::class, 'show']);
        Route::put('students/{id}', [StudentController::class, 'update']);
        Route::delete('students/{id}', [StudentController::class, 'destroy']);

        // Users (gestión de todos los usuarios del sistema)
        Route::get('users', [AdminUserController::class, 'index']);
        Route::post('users', [AdminUserController::class, 'store']);
        Route::get('users/{id}', [AdminUserController::class, 'show']);
        Route::put('users/{id}', [AdminUserController::class, 'update']);
        Route::delete('users/{id}', [AdminUserController::class, 'destroy']);

        // Catálogos (CRUD completo)
        Route::apiResource('institutes', InstituteController::class);
        Route::apiResource('careers', CareerController::class);
        //Route::apiResource('groups', GroupController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | SUPERADMIN & ADMIN | PROFESSOR DE INSTITUTO
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:superadmin|admin|professor'])->group(function () {
        Route::apiResource('groups', GroupController::class);
    });


    /*
    |--------------------------------------------------------------------------
    | PROFESSOR
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:professor'])->group(function () {
        // Gestión de estudiantes
        Route::get('students', [StudentController::class, 'index']);
        Route::post('students', [StudentController::class, 'store']);
        Route::put('students/{id}', [StudentController::class, 'update']);
    });

    /*
    |--------------------------------------------------------------------------
    | STUDENT
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:student'])->group(function () {
        // Solo puede ver/editar su propio perfil
        Route::get('me', [StudentController::class, 'me']);
        Route::put('me', [StudentController::class, 'updateMe']);
    });
});

/*
|--------------------------------------------------------------------------
| CATÁLOGOS PÚBLICOS
|--------------------------------------------------------------------------
| Listas accesibles sin login (para selects/dropdowns en frontend)
*/
Route::get('/institutes', [InstituteController::class, 'index']);
Route::get('/careers', [CareerController::class, 'index']);  
Route::get('/groups', [GroupController::class, 'index']);    


