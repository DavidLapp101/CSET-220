<?php

namespace App\Http\Controllers;

use App\Models\PatientInfo;
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
        $supervisor = json_decode(json_encode(DB::select('select date, name FROM users INNER JOIN schedules on(users.userID = schedules.supervisor) ORDER by date')), true);
        $doc1 = json_decode(json_encode(DB::select('select date, name FROM users INNER JOIN schedules on(users.userID = schedules.doctorOne) ORDER by date')), true);
        $doc2 = json_decode(json_encode(DB::select('select date, name FROM users INNER JOIN schedules on(users.userID = schedules.doctorTwo) ORDER by date')), true);
        $care1 = json_decode(json_encode(DB::select('select date, name FROM users INNER JOIN schedules on(users.userID = schedules.groupOneCarer) ORDER by date')), true);
        $care2 = json_decode(json_encode(DB::select('select date, name FROM users INNER JOIN schedules on(users.userID = schedules.groupTwoCarer) ORDER by date')), true);
        $care3 = json_decode(json_encode(DB::select('select date, name FROM users INNER JOIN schedules on(users.userID = schedules.groupThreeCarer) ORDER by date')), true);
        $care4 = json_decode(json_encode(DB::select('select date, name FROM users INNER JOIN schedules on(users.userID = schedules.groupFourCarer) ORDER by date')), true);
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

    public function patientBalances(){
        $balances = DB::select('select userID, balance from patientInfo');
        return view('payments', ['balances' => json_decode(json_encode($balances), true)]);

    }
    
    public function adminReport(){
        $dailyTask = DB::select('select doctorID, dailyTasks.patientID, dailytasks.date, dailytasks.docApt, dailytasks.morningMed, dailytasks.afternoonMed, dailytasks.eveningMed, dailytasks.breakfast, dailytasks.lunch, dailytasks.dinner, patientinfo.groupNum, 
        case 
        WHEN patientinfo.groupNum = 1 THEN (select name FROM users INNER JOIN schedules ON (users.userID = schedules.groupOneCarer) WHERE schedules.date = curdate()) 
        WHEN patientinfo.groupNum = 2 THEN (select name FROM users INNER JOIN schedules ON (users.userID = schedules.groupTwoCarer) WHERE schedules.date = curdate()) 
        WHEN patientinfo.groupNum = 3 THEN (select name FROM users INNER JOIN schedules ON (users.userID = schedules.groupThreeCarer) WHERE schedules.date = curdate()) 
        WHEN patientinfo.groupNum = 4 THEN (select name FROM users INNER JOIN schedules ON (users.userID = schedules.groupFourCarer) WHERE schedules.date = curdate()) 
        END AS caregiverName,
        CASE
        WHEN doctorID IS NOT NULL THEN (select name FROM users WHERE users.userID=doctorID)
        END AS doctorName,
        CASE
        WHEN dailytasks.patientID IS NOT NULL THEN (select name FROM users WHERE users.userID=dailytasks.patientID)
        END AS patientName
        from
        dailytasks INNER JOIN patientinfo on(patientinfo.userID = dailytasks.patientID) INNER JOIN
        schedules on(dailytasks.date = schedules.date) LEFT JOIN
        appointments on (appointments.date = dailytasks.date and appointments.patientID = dailytasks.patientID);');

        $patients = json_decode(json_encode(DB::select('select userID from users where roleID = 5;')), true);
        $regiments =[];
        for($i=0; $i < count($patients); $i++){
            $regiments[] = json_decode(json_encode(DB::select('select * from regiments where patientID ='. $patients[$i]['userID'].' order by date desc LIMIT 1;')), true);
        }
        return view('admin-report', ['dailyTask' => json_decode(json_encode($dailyTask), true)],['regiments' => $regiments]);
    }


    function viewFamilyTasks(Request $request) {
        $date = $request->input("date");
        $code = $request->input("family-code");
        $patient = $request->input("patient-id");

        if ($code == PatientInfo::where("userID", $patient)->first()->familyCode) {
            $dailyTasks = json_decode(json_encode(DB::select('select doctorID, dailyTasks.patientID, dailytasks.date, dailytasks.docApt, dailytasks.morningMed, dailytasks.afternoonMed, dailytasks.eveningMed, dailytasks.breakfast, dailytasks.lunch, dailytasks.dinner, patientinfo.groupNum, 
            case 
            WHEN patientinfo.groupNum = 1 THEN (select name FROM users INNER JOIN schedules ON (users.userID = schedules.groupOneCarer) WHERE schedules.date = "'.$date.'") 
            WHEN patientinfo.groupNum = 2 THEN (select name FROM users INNER JOIN schedules ON (users.userID = schedules.groupTwoCarer) WHERE schedules.date = "'.$date.'") 
            WHEN patientinfo.groupNum = 3 THEN (select name FROM users INNER JOIN schedules ON (users.userID = schedules.groupThreeCarer) WHERE schedules.date = "'.$date.'") 
            WHEN patientinfo.groupNum = 4 THEN (select name FROM users INNER JOIN schedules ON (users.userID = schedules.groupFourCarer) WHERE schedules.date = "'.$date.'") 
            END AS caretakerID,
            CASE
            WHEN doctorID IS NOT NULL THEN (select name FROM users WHERE users.userID=doctorID)
            END AS doctorName,
            CASE
            WHEN dailytasks.patientID IS NOT NULL THEN (select name FROM users WHERE users.userID=dailytasks.patientID)
            END AS patientName
            from
            dailytasks INNER JOIN patientinfo on(patientinfo.userID = dailytasks.patientID) INNER JOIN
            schedules on(dailytasks.date = schedules.date) LEFT JOIN
            appointments on (appointments.date = dailytasks.date and appointments.patientID = dailytasks.patientID) where dailytasks.patientID = '.$patient)), true)[0];
            $regiment = json_decode(json_encode(DB::select('select * from regiments where patientID = '.$patient)), true)[0];
            return view("landing-page", ['dailyTasks' => $dailyTasks], ['regiment' => $regiment]);
        }
        
        return redirect("/land");

    }


    public function rolelist(){
        $existingRoles = DB::select('select roleName, accessLevel from roles;');
        return view('new-role', ['roles'=> json_decode(json_encode($existingRoles), true)]);
    }



    public function groupless(){
        $list = DB::select("select patientinfo.userID, users.name from users join patientinfo on(patientinfo.userID=users.userID) where users.accountStatus='approved' and patientinfo.groupNum IS NULL;");
        return view('assign-group', ['groupless' => json_decode(json_encode($list), true)]);
    }

};
