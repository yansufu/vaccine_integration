<?php

use App\Http\Controllers\Api\ParentController;
use App\Http\Controllers\Api\ChildController;
use App\Http\Controllers\Api\ProviderController;
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\VaccineController;
use App\Http\Controllers\Api\VaccinationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthProvController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\NewsController;
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
Route::post('/login', [AuthController::class, 'login']);

Route::post('/loginProvider', [AuthProvController::class, 'loginProv']);

Route::apiResource('parent', ParentController::class);

Route::apiResource('child', ChildController::class);

Route::get('/childByParent/{parent_id}', [ChildController::class, 'getByParent']);

Route::post('/parent/{parent}/children', [ChildController::class, 'store']);

Route::get('/getRecommendedVaccinePeriod/{child_id}/{cat_id}', [VaccineController::class, 'getRecommendedVaccinePeriod']);

Route::apiResource('provider', ProviderController::class);

Route::apiResource('organization', OrganizationController::class);

Route::apiResource('vaccine', VaccineController::class);

Route::get('/vaccineByCat/{cat_id}', [VaccineController::class, 'getVaccineByCat']);

Route::apiResource('vaccination', VaccinationController::class);

Route::get('/child/{child_id}', [ChildController::class, 'show']);

Route::get('/child/{child_id}/vaccinations/status', [ChildController::class, 'getVaccinePeriod']);

Route::get('/child/{child_id}/vaccinations/nextStatus', [ChildController::class, 'getVaccineNextPeriod']);

Route::get('/child/{child_id}/vaccinations', [VaccinationController::class, 'getChildVaccinations']);

Route::get('/provider/{providerId}/vaccinations', [VaccinationController::class, 'getProviderVaccinations']);

Route::put('/child/{child_id}/vaccinations/scan', [VaccinationController::class, 'updateAfterScan']);

Route::apiResource('category', CategoryController::class);

Route::apiResource('catalog',  CatalogController::class);         
    
Route::get('/{catalog}', [CatalogController::class, 'show']); 
    
Route::post('/', [CatalogController::class, 'store']);        

Route::delete('/{catalog}', [CatalogController::class, 'destroy']);

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
Route::post('/news', [NewsController::class, 'store'])->name('news.store');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');
Route::put('/news/{id}', [NewsController::class, 'update'])->name('news.update');
Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('news.destroy');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ping', function () {
    return response()->json(['status' => 'OK']);
});

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');

Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
// Show the reset password form (user clicks from email)
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');

// Handle the form submission to reset password
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');


Route::get('/forgot-password-prov', [AuthProvController::class, 'showForgotPasswordFormProv'])->name('passwordProv.Prov');

Route::post('/forgot-password-prov', [AuthProvController::class, 'sendResetLinkEmailProv'])->name('passwordProv.email');
// Show the reset password form (user clicks from email)
Route::get('/reset-password-prov/{token}', [AuthProvController::class, 'showResetFormProv'])->name('passwordProv.reset');

// Handle the form submission to reset password
Route::post('/reset-password-prov', [AuthProvController::class, 'resetPassword'])->name('passwordProv.update');

