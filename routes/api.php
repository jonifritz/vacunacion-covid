<?php

use App\Http\Controllers\TypeVaccineController;
use App\Http\Controllers\VaccineStockController;
use App\Http\Controllers\VaccineLotController;
use App\Http\Controllers\ProvinceVaccinationController;
use App\Http\Controllers\MunicipalityVaccinationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VacunatoryCenterController;
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

Route::get('/users', [AuthController::class, 'index']);

Route::put('/update/{id}',[AuthController::class,'edit']);
Route::delete('/destroy/{id}',[AuthController::class,'destroy']);

//Route::post('users/edit/{id}',AuthController::class,'edit');

Route::apiResource('type-vaccine', TypeVaccineController::class);
//Route::get('/type-vaccine/show/{id}',TypeVaccineController::class,'show');

Route::get('/province-vaccination/my-vaccines/', [ProvinceVaccinationController::class, 'showProvinceVaccines']);

Route::get('/municipality-vaccination/my-vaccines/', [MunicipalityVaccinationController::class, 'showMunicipalitiesVaccines']);

Route::get('province-vaccination/stats/{vaccine_id}', [ProvinceVaccinationController::class, 'stats']);
Route::get('province-vaccination/statsall', [ProvinceVaccinationController::class, 'statsAll']);
Route::get('province-vaccination/typeVaccineByProvinces/{vaccine_id}', [ProvinceVaccinationController::class, 'typeVaccineByProvinces']);
Route::get('province-vaccination/typesVaccinesByProvince/{iso_id}', [ProvinceVaccinationController::class, 'typesVaccinesByProvince']);
Route::get('province-vaccination/alltypesVaccinesProvinces/', [ProvinceVaccinationController::class, 'alltypesVaccinesProvinces']);

Route::get('municipality-vaccination/stats/{vaccine_id}', [MunicipalityVaccinationController::class, 'stats']);
Route::get('municipality-vaccination/statsall', [MunicipalityVaccinationController::class, 'statsAll']);

Route::get('municipality-vaccination/alltypesVaccinesMunicipalities/', [MunicipalityVaccinationController::class, 'alltypesVaccinesMunicipalities']);

Route::get('vaccine-lots/alltypesVaccines/', [VaccineLotController::class, 'alltypesVaccines']);

Route::apiResource('province-vaccination', ProvinceVaccinationController::class);
Route::apiResource('municipality-vaccination', MunicipalityVaccinationController::class);
Route::apiResource('vaccine-lots', VaccineLotController::class);
Route::apiResource('vacunatory-center-vaccination', VacunatoryCenterVaccinationController::class);

Route::apiResource('vacunatory-center', VacunatoryCenterController::class);
Route::put('/edit/{id}',[VacunatoryCenterController::class,'edit']);

Route::get('/all-vacunatories-centers', [VacunatoryCenterController::class, 'allVacunatoriesCenters']);

