<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes(['register' => false, 'auth.reset' => false]);

Route::middleware('auth')->group(function () {

    Route::get('/', 'DashboardController')->name('home');

    Route::get('password/reset', 'PasswordController@show')->name('password.reset.form');
    Route::put('password/reset', 'PasswordController@update')->name('password.update');

    Route::get('treat/{patient_id}', 'DoctorController@treat')->name('treat.patient');
    Route::post('treat/{patient_id}', 'DoctorController@finishTreatment')->name('treat.patient.finish');

    Route::get('treat/{patient_id}/finalize', 'StaffController@finalizePreparation')->name('patient.finalize.preparation');
    Route::post('treat/{patient_id}/finalize', 'StaffController@finalizeReceipt')->name('patient.finalize');

    Route::get('receipt/{patient_id}', 'StaffController@viewReceipt')->name('receipt');

    Route::get('patients/finalized', 'PatientController@finalized')->name('patients.finalized');

    Route::resource('staffs', 'StaffController');
    Route::resource('doctors', 'DoctorController');
    Route::resource('patients', 'PatientController');

});
