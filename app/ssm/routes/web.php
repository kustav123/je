<?php

use App\Http\Controllers\InvNonGstController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssociateExtController;
use App\Http\Controllers\AssociateIntController;
use App\Http\Controllers\Clients;
use App\Http\Controllers\FinishproductController;
use App\Http\Controllers\HsnController;
use App\Http\Controllers\RawproductController;
use App\Http\Controllers\ReloadCacheController;
use App\Http\Controllers\scLedgerController;
use App\Http\Controllers\Staffs;
use App\Http\Controllers\StkInControler;
use App\Http\Controllers\StkOutControler;
use App\Http\Controllers\stockController;
use App\Http\Controllers\stockFinishController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SuppPayController;


// Route::get('/i', function () {
//     return view('welcome');
// });

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin']);

Route::group(['middleware' => 'auth'], function () {

    Route::prefix('reloadcache')->group(function () {
        Route::get('/', [ReloadCacheController::class, 'index']);
    });
    Route::prefix('staffs')->group(function () {
        Route::get('/', [Staffs::class, 'index']);
        Route::post('store', [Staffs::class, 'store']);
        Route::post('edit', [Staffs::class, 'edit']);
        Route::post('delete', [Staffs::class, 'destroy']);
        Route::post('getlist', [Staffs::class, 'liststuff']);
    });

    Route::prefix('clients')->group(function () {
        Route::get('/', [Clients::class, 'index']);
        Route::post('store', [Clients::class, 'store']);
        Route::post('edit', [Clients::class, 'edit']);
        Route::post('check', [Clients::class, 'check']);
        Route::post('rm', [Clients::class, 'delete']);
        Route::post('disable', [Clients::class, 'disable']);
        Route::post('enable', [Clients::class, 'enable']);
        Route::post('getcl', [Clients::class, 'getcl']);
        Route::post('getclbyname', [Clients::class, 'getclbyname']);
        Route::post('check', [Clients::class, 'check']);
        Route::post('rm', [Clients::class, 'delete']);
    });


    Route::prefix('hsns')->group(function () {
        Route::get('/', [HsnController::class, 'index']);
        Route::post('store', [HsnController::class, 'store']);
        Route::post('edit', [HsnController::class, 'edit']);
        Route::post('disable', [HsnController::class, 'disable']);
        Route::post('enable', [HsnController::class, 'enable']);
    });
    Route::prefix('assoext')->group(function () {
        Route::get('/', [AssociateExtController::class, 'index']);
        Route::post('store', [AssociateExtController::class, 'store']);
        Route::post('edit', [AssociateExtController::class, 'edit']);
        Route::post('disable', [AssociateExtController::class, 'disable']);
        Route::post('enable', [AssociateExtController::class, 'enable']);
        Route::post('getea', [AssociateExtController::class,'getea']);
        Route::post('geteabyname', [AssociateExtController::class,'geteabyname']);

    });

    Route::prefix('assoint')->group(function () {
        Route::get('/', [AssociateIntController::class, 'index']);
        Route::post('store', [AssociateIntController::class, 'store']);
        Route::post('edit', [AssociateIntController::class, 'edit']);
        Route::post('disable', [AssociateIntController::class, 'disable']);
        Route::post('enable', [AssociateIntController::class, 'enable']);
        Route::post('getia', [AssociateIntController::class,'getia']);
        Route::post('getiabyname', [AssociateIntController::class,'getiabyname']);
    });
    Route::prefix('finishproducts')->group(function () {
        Route::get('/', [FinishproductController::class, 'index']);
        Route::post('store', [FinishproductController::class, 'store']);
        Route::post('edit', [FinishproductController::class, 'edit']);
        Route::post('disable', [FinishproductController::class, 'disable']);
        Route::post('enable', [FinishproductController::class, 'enable']);

    });

    Route::prefix('rawproducts')->group(function () {
        Route::get('/', [RawproductController::class, 'index']);
        Route::post('store', [RawproductController::class, 'store']);
        Route::post('edit', [RawproductController::class, 'edit']);
        Route::post('disable', [RawproductController::class, 'disable']);
        Route::post('enable', [RawproductController::class, 'enable']);

        // Route::post('getrp', [RawproductController::class, 'getrp']);

    });
    Route::prefix('stkent')->group(function () {
        Route::get('/', [stockController::class, 'addnewPage']);
        Route::post('skent', [stockController::class, 'stockentry']);
        Route::get('/gethis', [stockController::class, 'stockhsit']);


    });
    Route::prefix('stkfinent')->group(function () {
        Route::get('/', [stockFinishController::class, 'addnewPage']);
        Route::post('skent', [stockFinishController::class, 'stockentry']);
    });
    Route::prefix('finsup')->group(function () {
        Route::get('/', [SuppPayController::class, 'addnewPage']);
        Route::post('pay', [SuppPayController::class, 'pay']);
    });

    Route::prefix('stkoutint')->group(function () {
        Route::get('/', [StkOutControler::class, 'indexint']);
        Route::post('intoutstock', [StkOutControler::class, 'intoutstock']);
        Route::post('getintstock', [StkOutControler::class, 'stockMapInt']);

    });
    Route::prefix('stkoutext')->group(function () {
        Route::get('/', [StkOutControler::class, 'indexext']);
        Route::post('extoutstock', [StkOutControler::class, 'extoutstock']);
        Route::post('getextstock', [StkOutControler::class, 'stockMapExt']);

    });

    Route::prefix('stkinint')->group(function () {
        Route::get('/', [StkInControler::class, 'indexint']);
        Route::post('adjustint', [StkInControler::class, 'adjint']);
        Route::post('adjustext', [StkInControler::class, 'adjext']);
        Route::post('finint', [StkInControler::class, 'finProdInt']);
        Route::post('finext', [StkInControler::class, 'finProdExt']);
    });
    Route::prefix('suppliers')->group(function () {    //for factory only
        Route::get('/', [SupplierController::class, 'index']);
        Route::post('store', [SupplierController::class, 'store']);
        Route::post('edit', [SupplierController::class, 'edit']);
        Route::post('disable', [SupplierController::class,'disable']);
        Route::post('enable', [SupplierController::class,'enable']);
        Route::post('getsl', [SupplierController::class,'getsl']);
        Route::post('getslbyname', [SupplierController::class,'getslbyname']);
    });
    Route::prefix('stkinext')->group(function () {
        Route::get('/', [StkInControler::class, 'indexext']);
    });
    Route::get('/fetch-by-clid', [scLedgerController::class, 'fetchByClid']);

    Route::get('/', [AdminController::class, 'index'])->middleware('auth');
    Route::post('/log', [AdminController::class, 'fetchLog'])->middleware('auth');

    Route::get('/logout', [AuthController::class, 'logout']);
});
