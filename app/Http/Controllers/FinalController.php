<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\PatientInfo;
use App\Models\Role;
use App\Models\Schedule;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class FinalController extends Controller
{
    public function register(Request $request) {

        $fields = $request->validate([
            'reg-role' => 'required|int',
            'reg-name' => 'required|string',
            'reg-email' => 'required|string|unique:users,email',
            'reg-phone' => 'required|int|unique:users,phone',
            'reg-pass' => 'required|string',
            'reg-dob' => 'required|date',
            'reg-code' => 'string',
            'reg-contact-phone' => "int",
            'reg-contact-name' => "string",
            'reg-relation' => "string"
        ]);

        $user = User::create([
            'roleID' => $fields['reg-role'],
            'name' => $fields['reg-name'],
            'email' => $fields['reg-email'],
            'phone' => $fields['reg-phone'],
            'password' => bcrypt($fields['reg-pass']),
            'dateOfBirth' => $fields['reg-dob'],
        ]);

        $userID = json_decode(json_encode(DB::select("select userID from users order by created_at desc limit 1;")), true)[0]["userID"];
        if (in_array($fields["reg-role"], [1,2,3,4])) {
            $salary = Salary::create([
                'userID' => (int)$userID,
                'salary' => ((5-((int)$fields['reg-role'])) * 1000000)
            ]);
        }
        else if ($fields["reg-role"] == 5) {
            $info = PatientInfo::create([
                'userID' => (int)$userID,
                'familyCode' => $fields['reg-code'],
                'emergencyContact' => $fields['reg-contact-phone'],
                'contactName' => $fields['reg-contact-name'],
                'contactRelation' => $fields['reg-relation'],
                'groupNum' => null,
                'admissionDate' => null,
                'balance' => null
            ]);
        }


        $_SESSION["userID"] = $userID;
        $_SESSION["name"] = $fields['reg-name'];
        $_SESSION["accessLevel"] = (int)$fields['reg-role'];

        return redirect('/');

    }

    // public function accountPage() {

    //     $roles = json_decode(json_encode(Role::all()), true);
    //     return view("login-register", ['roles' => $roles]);

    // }


    public function acceptDeclineUsers(Request $request){

        $user = $request->input('user');
        $action = $request->input('approve/decline');
        if($action == 'accept'){
            User::where('userID', $user)->update(['accountStatus' => "approved"]);
            PatientInfo::where('userID', $user) ->update(['admissionDate' => date('Y-m-d')]);
        }
        else{
            User::where('userID', $user)->update(['accountStatus' => "declined"]);
        }
        return redirect('/accountApproval');
    }

    public function newRoster(Request $request){
        $date = $request->input('date');
        $supervisor = $request->input('supervisor');
        $doc1 = $request->input('doctor1');
        $doc2 = $request->input('doctor2');
        $caregiver1 = $request->input('caregiver1');
        $caregiver2 = $request->input('caregiver2');
        $caregiver3 = $request->input('caregiver3');
        $caregiver4 = $request->input('caregiver4');

        Schedule::create([
            'date' => $date,
            'supervisor' => $supervisor,
            'doctorOne' => $doc1,
            'doctorTwo' => $doc2,
            'groupOneCarer' => $caregiver1,
            'groupTwoCarer' => $caregiver2,
            'groupThreeCarer' => $caregiver3,
            'groupFourCarer' => $caregiver4,
        ]);
        return redirect('/newRoster');
    }

    public function newDoctorsAppointment(Request $request){
        $patientID=$request->input('patientID');
        $doctorID=$request->input('doctorID');
        $date=$request->input('date');

        Appointment::create([
            'patientID' => $patientID,
            'doctorID' => $doctorID,
            'date' => $date
        ]);
        return redirect('/newAppointment');
    }

    public function changeSalary(Request $request){
        $employee = $request->input('employee');
        $salary = $request->input('salary');
        $list = json_decode(json_encode(DB::select('select userID from users where 
        roleID between 1 and 4')), true);
        $arr = [];
        for($i=0; $i<count($list); $i++){
            array_push($arr, $list[$i]['userID']);
        }
        print_r($arr);
        if(in_array($employee, $arr)){
            Salary::where('userID', $employee)->update(['salary' => $salary]);
            return redirect('/employees');
        }
        else{
            echo "somethin";
        }
    }

    public function login(Request $request) {

        $fields = $request->validate([
            'login-email' => 'required|string',
            'login-pass' => 'required|string',
        ]);

        $user = User::where('email', $fields['login-email'])->first();

        if (!$user || !Hash::check($fields['login-pass'], $user->password)) {
            $_POST["login-info"] = "incorrect";
            return view("login-register");
        }
        else if ($user->accountStatus != "approved") {
            $_POST["login-info"] = "pending";
            return view("login-register");
        }

        $_POST["login-info"] = "correct";
        $role = Role::where("roleID", $user->roleID)->first();

        $_SESSION["userID"] = $user->userID;
        $_SESSION["name"] = $user->name;
        $_SESSION["accessLevel"] = $role->accessLevel;

        return redirect('/land');

    }

    public function updateBalance(Request $request){
        $patients = PatientInfo::all();
        for($i=0; $i<count($patients); $i++){
            $balance = 0;
            $datediff = DB::select('select timestampdiff(day, lastBalanceUpdate, curdate()) as "days" from patientinfo where userID='.$patients[$i]->userID)[0];
            $balance += 10*json_decode(json_encode($datediff), true)["days"];

            $appointments = DB::select('select count(appointmentID) as "count" from appointments where patientID = '.$patients[$i]->userID.' and date BETWEEN(select lastBalanceUpdate
             from patientinfo where userID='.$patients[$i]->userID.')and curdate()')[0];
            $appointments = json_decode(json_encode($appointments), true)["count"];
            $balance += 50*$appointments;

            if(json_decode(json_encode(DB::select('select DAY(curdate()) as day')), true)[0]['day'] == 6){
                $medications = DB::select("select count(morningMed) as ma, count(afternoonMed) as aa, count(eveningMed) as ea from regiments join patientinfo on(patientinfo.userID=regiments.patientID) where patientID = ".$patients[$i]->userID." and
                timestampdiff(month, date, curdate()) >=1 and date=greatest(lastBalanceUpdate, date) and date != lastBalanceUpdate");
                $medications = json_decode(json_encode($medications), true);
                for($j=0; $j<count($medications); $j++){
                    $balance += 5* $medications[$j]['ma'];
                    $balance += 5* $medications[$j]['aa'];
                    $balance += 5* $medications[$j]['ea'];
                }
            
            }
            PatientInfo::where('userID', $patients[$i]->userID)->update(['balance' => $balance], ['lastBalanceUpdate' => date('Y-m-d')]);
        }
        
    }

    public function makePayment(Request $request){
        $patient = $request->input('searchBalance');
        $balance = DB::select('select balance from patientinfo where userID='.$patient);
        $balance = json_decode(json_encode($balance), true)[0]["balance"];
        $paymentAmount = $request->input('paymentAmount');
        $balance -= $paymentAmount;
        PatientInfo::where('userID', $patient)->update(['balance'=>$balance]);
        $_POST['success'] = 'User '.$patient. " payment succesful";
        return redirect('/payments');
    }

    public function land(){
        //for patient Home Page
        $reg = json_decode(json_encode(DB::select('select doctorID, dailyTasks.patientID, dailytasks.date, dailytasks.docApt, dailytasks.morningMed, dailytasks.afternoonMed, dailytasks.eveningMed, dailytasks.breakfast, dailytasks.lunch, dailytasks.dinner, patientinfo.groupNum, 
        case 
        WHEN patientinfo.groupNum = 1 THEN (select name FROM users INNER JOIN schedules ON (users.userID = schedules.groupOneCarer) WHERE schedules.date = curdate()) 
        WHEN patientinfo.groupNum = 2 THEN (select name FROM users INNER JOIN schedules ON (users.userID = schedules.groupTwoCarer) WHERE schedules.date = curdate()) 
        WHEN patientinfo.groupNum = 3 THEN (select name FROM users INNER JOIN schedules ON (users.userID = schedules.groupThreeCarer) WHERE schedules.date = curdate()) 
        WHEN patientinfo.groupNum = 4 THEN (select name FROM users INNER JOIN schedules ON (users.userID = schedules.groupFourCarer) WHERE schedules.date = curdate()) 
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
        appointments on (appointments.date = dailytasks.date and appointments.patientID = dailytasks.patientID);')), true);
        $takeMeds = json_decode(json_encode(DB::select('select patientID, date, morningMed, afternoonMed, eveningMed from regiments where patientID='.$_SESSION["userID"].' order by date desc LIMIT 1;')), true);

        //for cargiver Home Page
        return view('landing-page', compact('reg', 'takeMeds'));
    }

}


