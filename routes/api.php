<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserManagement\UserResource;
use App\Http\Controllers\Kepegawaian\UnitController;
use App\Http\Controllers\Kegiatan\KegiatanController;
use App\Http\Controllers\Kepegawaian\JabatanController;
use App\Http\Controllers\Kepegawaian\PangkatController;
use App\Http\Controllers\Kepegawaian\SubUnitController;
use App\Http\Controllers\UserManagement\UserController;
use App\Http\Controllers\Kepegawaian\UraianTugasController;
use App\Http\Controllers\Kegiatan\ProgramKegiatanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user()->load(['pangkat', 'jabatan', 'unit']));
    });
    Route::post('/profile-foto', [UserController::class, 'addFotoProfile']);
    Route::apiResources([
        'programKegiatan' => ProgramKegiatanController::class,
        'kegiatan' => KegiatanController::class,
        // 'roles' => RoleController::class,php
        'unit' => UnitController::class,
        'subUnit' => SubUnitController::class,
        'pangkat' => PangkatController::class,
        'jabatan' => JabatanController::class,
        'uraianTugas' => UraianTugasController::class,
        'users' => UserController::class,
    ]);
    Route::put('/follow-kegiatan/{kegiatan}', [KegiatanController::class, 'follow']);
});
