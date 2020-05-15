<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    Route::get('/', function () {
        if (Auth::user()->isAdmin()) {
            return view('admin.dashboard');
        }

        if (Auth::user()->isStaff()) {
            $staff = DB::selectOne("select * from staffs where user_id = ?", [Auth::id()]);
            return view('staffs.show')->with('staff', $staff);
        }

        return response()->setStatusCode(403);
    })->name('home');

    Route::get('password/reset', 'PasswordController@show')->name('password.reset.form');
    Route::put('password/reset', 'PasswordController@update')->name('password.update');

    Route::resource('staffs', 'StaffController');
    Route::resource('doctors', 'DoctorController');

});
