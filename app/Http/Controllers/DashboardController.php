<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        if (auth()->user()->isAdmin()) {
            return view('admin.dashboard');
        }

        if (auth()->user()->isStaff()) {
            return view('staffs.dashboard')
                ->with('staff', DB::selectOne('select * from staffs where user_id = ?', [auth()->id()]));
        }

        if (auth()->user()->isDoctor()) {
            return view('doctors.dashboard')
                ->with('doctor', DB::selectOne('select * from doctors where user_id = ?', [auth()->id()]));
        }

        return response(null, 403);
    }
}
