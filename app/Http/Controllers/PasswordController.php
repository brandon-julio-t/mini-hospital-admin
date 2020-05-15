<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function show()
    {
        return view('auth.custom.passwords.reset');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::update('
            update users
            set password = :new_password
            where id = :id
        ', [
            'id' => Auth::id(),
            'new_password' => Hash::make($request->password),
        ]);

        return redirect()->route('home')->with('status', 'Password updated');
    }
}
