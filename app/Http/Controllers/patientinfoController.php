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
    
    function showRoster(){
        $supervisor = json_decode(json_encode(DB::select('select date, name FROM users INNER JOIN schedules on(users.userID = schedules.supervisor)')), true);
        $doc1 = json_decode(json_encode(DB::select('select date, name FROM users INNER JOIN schedules on(users.userID = schedules.doctorOne)')), true);
        $doc2 = json_decode(json_encode(DB::select('select date, name FROM users INNER JOIN schedules on(users.userID = schedules.doctorTwo)')), true);
        $care1 = json_decode(json_encode(DB::select('select date, name FROM users INNER JOIN schedules on(users.userID = schedules.groupOneCarer)')), true);
        $care2 = json_decode(json_encode(DB::select('select date, name FROM users INNER JOIN schedules on(users.userID = schedules.groupTwoCarer)')), true);
        $care3 = json_decode(json_encode(DB::select('select date, name FROM users INNER JOIN schedules on(users.userID = schedules.groupThreeCarer)')), true);
        $care4 = json_decode(json_encode(DB::select('select date, name FROM users INNER JOIN schedules on(users.userID = schedules.groupFourCarer)')), true);
        return view('roster', compact('supervisor', 'doc1', 'doc2', 'care1', 'care2', 'care3', 'care4'));
     }


    public function listPatients(){
        $patients = DB::select('select users.userID, users.name, timestampdiff(year, users.dateOfBirth, curdate()) as age, patientinfo.emergencyContact,
         patientinfo.contactName, patientinfo.admissionDate from users join patientinfo on(users.userID=patientinfo.userID);');
         return view('patient-search', ['patientList' => json_decode(json_encode($patients), true)]);
    }

    function appointmentPaintent(){
        $pat = json_decode(json_encode(DB::select('select userID, name from users where roleID=5')), true);
        $doc1 = json_decode(json_encode(DB::select('select userID, name, date from users INNER JOIN schedules on(users.userID = schedules.doctorOne)')), true);
        $doc2 = json_decode(json_encode(DB::select('select userID, name, date from users INNER JOIN schedules on(users.userID = schedules.doctorTwo)')), true);
        return view('doctor-appointment', compact('pat', 'doc1', 'doc2'));
    }
};
