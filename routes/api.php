<?php

use App\Http\Controllers\TypeVaccineController;
use App\Http\Controllers\VaccineStockController;
use App\Http\Controllers\ProvinceVaccinationController;
use App\Http\Controllers\MunicipalityVaccinationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('type-vaccine',TypeVaccineController::class);
Route::apiResource('vaccine-stock',VaccineStockController::class);
Route::apiResource('province-vaccination',ProvinceVaccinationController::class);
Route::apiResource('municipality-vaccination',MunicipalityVaccinationController::class);