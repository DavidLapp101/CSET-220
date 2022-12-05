<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class patientinfoController extends Controller
{
    function pendingUsers(){
        $pending = DB::select('select userID, name, roleName from users join roles on roles.roleID=users.roleID where accountStatus = "Pending"');
        // $pending = User::where('accountStatus', 'Approved')->get();
        return view('account-approval', ['pendingUsers' => json_decode(json_encode($pending), true)]);
    }
    // function patientHome(){
    //     $info = DB::select('select users.userID, users.name, dailytasks.date, morningMed, afternoonMed, eveningMed, breakfast, lunch, dinner, ')
    // }

    function createRoster(){
        $supervisor = json_decode(json_encode(DB::select('select name, userID from users where roleID=2 AND accountStatus = "approved"')), true);
        $doctor = json_decode(json_encode(DB::select('select name, userID from users where roleID=3 AND accountStatus = "approved"')), true);
        $caregiver = json_decode(json_encode(DB::select('select name, userID from users where roleID=4 AND accountStatus = "approved"')), true);
        return view('new-roster', compact('supervisor', 'doctor', 'caregiver'));
    }
}
