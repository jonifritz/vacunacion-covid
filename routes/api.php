<?php

use App\Http\Controllers\TypeVaccineController;
use App\Http\Controllers\VaccineStockController;
use App\Http\Controllers\VaccineLotController;
use App\Http\Controllers\ProvinceVaccinationController;
use App\Http\Controllers\MunicipalityVaccinationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VacunatoryCenterVaccinationController;
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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

//Route::apiResource('auth', AuthController::class);


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});


// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

//Route::apiResource('auth', AuthController::class);
//Route::apiResource('/auth/register', 'AuthController@register');

Route::apiResource('type-vaccine', TypeVaccineController::class);
//Route::get('/type-vaccine/show/{id}',TypeVaccineController::class,'show');


Route::apiResource('province-vaccination', ProvinceVaccinationController::class);
Route::apiResource('municipality-vaccination', MunicipalityVaccinationController::class);
Route::apiResource('vaccine-lots', VaccineLotController::class);
Route::apiResource('vacunatory-center-vaccination', VacunatoryCenterVaccinationController::class);

