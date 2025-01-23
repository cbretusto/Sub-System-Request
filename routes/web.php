<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Controllers
use App\Http\Controllers\ExportReportController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\SubSystemRequestHistoryController;
use App\Http\Controllers\SubSystemPoReceivedCategoryController;

Route::get('/', function () {
    return view('sub_system_request_history');
})->name('sub_system_request_history');

Route::get('/export', function () {
    return view('export');
})->name('export');

Route::get('/user_management', function () {
    return view('user_management');
})->name('user_management');

Route::get('/po_received_category', function () {
    return view('po_received_category');
})->name('po_received_category');


// SUBSYSTEM REQUEST USER MANAGEMENT
Route::controller(UserManagementController::class)->group(function () {
    Route::get('/view_user', 'viewUser')->name('view_user');
    Route::get('/get_rapidx_user_active_in_systemone', 'getRapidxUserActiveInSystemOne')->name('get_rapidx_user_active_in_systemone');
    Route::get('/get_systemone_department', 'getSystemOneDepartment')->name('get_systemone_department');
    Route::get('/get_systemone_position', 'getSystemOnePosition')->name('get_systemone_position');
    Route::post('/user_create_update', 'userCreateUpdate')->name('user_create_update');
    Route::get('/get_user_info_by_id', 'getUserInfoById')->name('get_user_info_by_id');
    Route::post('/change_user_status', 'changeUserStatus')->name('change_user_status');
    Route::get('/get_user_log', 'getUserLog')->name('get_user_log');
});

// SUBSYSTEM P.O RECEIVED CATEGORY
Route::controller(SubSystemPoReceivedCategoryController::class)->group(function () {
    Route::get('/view_subsystem_po_received_category', 'viewSubsystemPoReceivedCategory')->name('view_subsystem_po_received_category');
    Route::post('/create_update_subsystem_po_received_category', 'createUpdateSubsystemPoReceivedCategory')->name('create_update_subsystem_po_received_category');
    Route::get('/get_subsystem_po_received_category_info_by_id', 'getSubsystemPoReceivedCategoryInfoById')->name('get_subsystem_po_received_category_info_by_id');
    Route::post('/change_category_status', 'changeSubSystemPoReceivedCategoryStatus')->name('change_category_status');
});

// SUBSYSTEM REQUEST HISTORY
Route::controller(SubSystemRequestHistoryController::class)->group(function () {
    Route::get('/view_subsystem_request_history', 'viewSubsystemRequestHistory')->name('view_subsystem_request_history');
    Route::get('/export/{category}', 'export');
    Route::post('/import', 'import');
    Route::post('/create_update_subsystem_request', 'subsystemRequestCreateUpdate')->name('create_update_subsystem_request');
    Route::get('/get_subsystem_request_info_by_id', 'getSubsystemRequestInfoById')->name('get_subsystem_request_info_by_id');
    Route::get('/get_po_received_details', 'getPoReceivedDetails')->name('get_po_received_details');
});

// SUBSYSTEM REQUEST EXPORT REPORT
Route::controller(ExportReportController::class)->group(function () {
    Route::get('/search_po_received_details', 'searchPoReceivedDetails')->name('search_po_received_details');
    Route::get('/export/{category}/{poNo}/{deviceName}/{from}/{to}', 'export');
});