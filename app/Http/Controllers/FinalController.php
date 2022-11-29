<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class FinalController extends Controller
{
    public function register(Request $request) {

        $fields = $request->validate([
            'reg-role' => 'required|int',
            'reg-name' => 'required|string',
            'reg-email' => 'required|string|unique:users,email',
            'reg-phone' => 'required|int|unique:users,phone',
            'reg-pass' => 'required|string|confirmed',
            'reg-dob' => 'required|date',
        ]);

        $user = Users::create([
            'roleID' => $fields['reg-role'],
            'name' => $fields['reg-name'],
            'email' => $fields['reg-email'],
            'phone' => $fields['reg-phone'],
            'password' => bcrypt($fields['reg-pass']),
            'dateOfBirth' => $fields['dob'],
        ]);

        return redirect('/land');

    }
}
