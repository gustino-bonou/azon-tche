<?php

use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\Project\ProjectController;
use App\Http\Controllers\Api\Project\TaskController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(
    ["prefix" => "auth"],
    function ($router) {
        Route::post("/register", [AuthenticationController::class, 'register'])->name('register');
        Route::post("/login", [AuthenticationController::class, 'login'])->name('login');
    }
);




Route::group(
    ["middleware" => ["auth:api"]],
    function ($router) {
        Route::group(
            ["prefix" => "auth"],
            function ($router) {
                Route::get("profile", [AuthenticationController::class, 'profile'])->name("profile");
                Route::post("logout", [AuthenticationController::class, 'logout'])->name("logout");
            }
        );

        Route::group(
            ["prefix" => "project"],
            function ($router) {
                Route::post("store", [ProjectController::class, "store"])->name("store");
                Route::put("update/{project}", [ProjectController::class, "update"])->name("update");
                Route::get("", [ProjectController::class, "index"])->name("index");
            }
        );

        Route::group(
            ["prefix" => "task"],
            function ($router) {
                Route::post("store", [TaskController::class, "store"])->name("store");
                Route::put("update/{task}", [TaskController::class, "update"])->name("update");
                Route::post("assign", [TaskController::class, "assignTask"])->name("assign");
                Route::post("index", [TaskController::class, "assignTask"])->name("assign");
                Route::get("", [TaskController::class, "homeData"])->name("home");
                Route::get("detail/{id}", [TaskController::class, "getTask"])->name("detail");
                Route::post("project_tasks", [TaskController::class, "getProjectTasks"])->name("project");
            }
        );

        Route::post("users", [UserController::class, "search"])->name("search.user");


    }

);