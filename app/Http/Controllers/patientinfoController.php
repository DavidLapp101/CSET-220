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
    public function listEmployees(){
        $employees = DB::select('select users.userID, users.name, roles.roleName, salaries.salary from users left join salaries 
        on(users.userID=salaries.userID) join roles on(users.roleID=roles.roleID) where users.roleID between 1 and 5;');
        return view('employees', ['employeeList' => json_decode(json_encode($employees), true)]);
    }


    public function listPatients(){
        $patients = DB::select('select users.userID, users.name, timestampdiff(year, users.dateOfBirth, curdate()) as age, patientinfo.emergencyContact,
         patientinfo.contactName, patientinfo.admissionDate from users join patientinfo on(users.userID=patientinfo.userID);');
         return view('patient-search', ['patientList' => json_decode(json_encode($patients), true)]);
    }

    public function patientBalances(){
        $balances = DB::select('select userID, balance from patientInfo');
        return view('payments', ['balances' => json_decode(json_encode($balances), true)]);
    }
};
