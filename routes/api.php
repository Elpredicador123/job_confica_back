<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BirthdayController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\InfographicController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\ControlPanelController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\ManagementController;
use App\Http\Controllers\Api\ManagerController;
use App\Http\Controllers\Api\ProvisionController;
use App\Http\Controllers\Api\MaintenanceController;
use App\Http\Controllers\Api\QualityController;
use App\Http\Controllers\Api\TechnicalController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\AuditController;
use App\Http\Controllers\AuthController;
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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'birthday'], function ($router) {
    Route::get('/all', [BirthdayController::class, 'index']);
    Route::post('/store', [BirthdayController::class, 'store']);
    Route::get('/show/{id}', [BirthdayController::class, 'show']);
    Route::put('/update/{id}', [BirthdayController::class, 'update']);
    Route::delete('/delete/{id}', [BirthdayController::class, 'destroy']);
});

Route::group(['prefix' => 'news'], function ($router) {
    Route::get('/principal', [NewsController::class, 'principal']);
    Route::get('/all', [NewsController::class, 'index']);
    Route::post('/store', [NewsController::class, 'store']);
    Route::get('/show/{id}', [NewsController::class, 'show']);
    Route::put('/update/{id}', [NewsController::class, 'update']);
    Route::delete('/delete/{id}', [NewsController::class, 'destroy']);
});

Route::group(['prefix' => 'reservation'], function ($router) {
    Route::get('/all', [ReservationController::class, 'index']);
    Route::post('/store', [ReservationController::class, 'store']);
    Route::get('/show/{id}', [ReservationController::class, 'show']);
    Route::put('/update/{id}', [ReservationController::class, 'update']);
    Route::delete('/delete/{id}', [ReservationController::class, 'destroy']);
});

Route::group(['prefix' => 'infographic'], function ($router) {
    Route::get('/all', [InfographicController::class, 'index']);
    Route::post('/store', [InfographicController::class, 'store']);
    Route::get('/show/{id}', [InfographicController::class, 'show']);
    Route::put('/update/{id}', [InfographicController::class, 'update']);
    Route::delete('/delete/{id}', [InfographicController::class, 'destroy']);
});

Route::group(['prefix' => 'video'], function ($router) {
    Route::get('/all', [VideoController::class, 'index']);
    Route::post('/store', [VideoController::class, 'store']);
    Route::get('/show/{id}', [VideoController::class, 'show']);
    Route::put('/update/{id}', [VideoController::class, 'update']);
    Route::delete('/delete/{id}', [VideoController::class, 'destroy']);
});

Route::group(['prefix' => 'technical'], function ($router) {
    Route::get('/all', [TechnicalController::class, 'index']);
    Route::post('/store', [TechnicalController::class, 'store']);
    Route::get('/show/{id}', [TechnicalController::class, 'show']);
    Route::put('/update/{id}', [TechnicalController::class, 'update']);
    Route::delete('/delete/{id}', [TechnicalController::class, 'destroy']);
    Route::get('/carnet/{carnet}', [TechnicalController::class, 'getTechnicalByCarnet']);
});

Route::group(['prefix' => 'user'], function ($router) {
    Route::get('/all', [UserController::class, 'index']);
    Route::post('/store', [UserController::class, 'store']);
    Route::get('/show/{id}', [UserController::class, 'show']);
    Route::put('/update/{id}', [UserController::class, 'update']);
    Route::delete('/delete/{id}', [UserController::class, 'destroy']);
});

Route::group(['prefix' => 'role'], function ($router) {
    Route::get('/all', [RoleController::class, 'index']);
    Route::post('/store', [RoleController::class, 'store']);
    Route::get('/show/{id}', [RoleController::class, 'show']);
    Route::put('/update/{id}', [RoleController::class, 'update']);
    Route::delete('/delete/{id}', [RoleController::class, 'destroy']);
});

Route::group(['prefix' => 'permission'], function ($router) {
    Route::get('/all', [PermissionController::class, 'index']);
    Route::post('/store', [PermissionController::class, 'store']);
    Route::get('/show/{id}', [PermissionController::class, 'show']);
    Route::put('/update/{id}', [PermissionController::class, 'update']);
    Route::delete('/delete/{id}', [PermissionController::class, 'destroy']);
});

Route::group(['prefix' => 'order'], function ($router) {
    Route::get('/all', [OrderController::class, 'index']);
    Route::post('/store', [OrderController::class, 'store']);
    Route::get('/show/{id}', [OrderController::class, 'show']);
    Route::put('/update/{id}', [OrderController::class, 'update']);
    Route::delete('/delete/{id}', [OrderController::class, 'destroy']);
});

Route::group(['prefix' => 'control-panel'], function ($router) {
    Route::get('/installationprogressgraphic', [ControlPanelController::class, 'getInstallationProgressGraphic']);
    Route::get('/installationprogresstable', [ControlPanelController::class, 'getInstallationProgressTable']);
    Route::get('/maintenanceprogressgraphic', [ControlPanelController::class, 'getMaintenanceProgressGraphic']);
    Route::get('/maintenanceprogresstable', [ControlPanelController::class, 'getMaintenanceProgressTable']);
    Route::get('/diarytable', [ControlPanelController::class, 'getDiaryTable']);
    Route::get('/installationratiographic', [ControlPanelController::class, 'getInstallationRatioGraphic']);
    Route::get('/maintenanceratiographic', [ControlPanelController::class, 'getMaintenanceRatioGraphic']);
    Route::get('/productiontable', [ControlPanelController::class, 'getProductionTable']);
});

Route::group(['prefix' => 'management'], function ($router) {
    Route::get('/installationprogresstable/{citie_name?}', [ManagementController::class, 'getInstallationProgressTable']);
    Route::get('/maintenanceprogresstable/{citie_name?}', [ManagementController::class, 'getMaintenanceProgressTable']);
    Route::get('/installationlogmanagertable/{manager_alta?}',[ManagementController::class, 'getInstallationLogManagerTable']);
    Route::get('/ordermanagertable/{manager_averia?}',[ManagementController::class, 'getOrdermanagerTable']);
});

Route::group(['prefix' => 'provision'], function ($router) {
    Route::get('/diarycontratagraphic/{citie_name?}', [ProvisionController::class, 'getDiaryContrataGraphic']);
    Route::get('/diarymanagergraphic/{citie_name?}', [ProvisionController::class, 'getDiaryManagerGraphic']);
    Route::get('/childhoodbreakdownsmanagers/{citie_name?}', [ProvisionController::class, 'getChildhoodBreakdownsManagers']);
    Route::get('/childhoodbreakdownstechnicians/{citie_name?}', [ProvisionController::class, 'getChildhoodBreakdownsTechnicians']);
    Route::get('/childhoodbreakdownsgeneral', [ProvisionController::class, 'getChildhoodBreakdownsGeneral']);
});

Route::group(['prefix' => 'maintenance'], function ($router) {
    Route::get('/ineffectivecontratagraphic/{citie_name?}', [MaintenanceController::class, 'getIneffectiveContrataGraphic']);
    Route::get('/ineffectivedistributionratiographic', [MaintenanceController::class, 'getIneffectiveDistributionRatioGraphic']);
    Route::get('/childhoodbreakdownsmanagers/{citie_name?}', [MaintenanceController::class, 'getChildhoodBreakdownsManagers']);
    Route::get('/childhoodbreakdownstechnicians/{citie_name?}', [MaintenanceController::class, 'getChildhoodBreakdownsTechnicians']);
    Route::get('/childhoodbreakdownsgeneral', [MaintenanceController::class, 'getChildhoodBreakdownsGeneral']);
});

Route::group(['prefix' => 'quality'], function ($router) {
    Route::get('/inspectioneffectivenesstable/{citie_name?}/{month}', [QualityController::class, 'getInspectionEffectivenessTable']);
    Route::get('/inspectioneffectivenessbytectable/{citie_name?}/{month}', [QualityController::class, 'getInspectionEffectivenessByTecTable']);
    Route::get('/auditsprogresstable/{citie_name?}/{month}', [QualityController::class, 'getAuditsProgressTable']);
    Route::get('/auditsprogressbytectable/{citie_name?}/{month}', [QualityController::class, 'getAuditsProgressByTecTable']);
    Route::get('/errorsevidencetable/{citie_name?}', [QualityController::class, 'getErrorsEvidenceTable']);
    Route::get('/errorsevidencebytectable/{citie_name?}', [QualityController::class, 'getErrorsEvidenceByTecTable']);
    Route::get('/errorinspectionratiotable', [QualityController::class, 'getErrorInspectionRatioTable']);
    Route::get('/errorfotostoaratiotable', [QualityController::class, 'getErrorFotosToaRatioTable']);
});

Route::group(['prefix' => 'city'], function ($router) {
    Route::get('/all', [CityController::class, 'getCities']);
});

Route::group(['prefix' => 'audit'], function ($router) {
    Route::get('/months', [AuditController::class, 'getMonths']);
});

Route::group(['prefix' => 'manager'], function ($router) {
    Route::get('/all', [ManagerController::class, 'getManagers']);
    Route::get('/managersaltas', [ManagerController::class, 'getManagersAltas']);
    Route::get('/managersaverias', [ManagerController::class, 'getManagersAverias']);
});