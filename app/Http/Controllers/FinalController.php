<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\DailyTask;
use App\Models\PatientInfo;
use App\Models\Regiment;
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

        if ($fields['reg-role'] == 5) {
            $status = "pending";
        }
        else {
            $status = "approved";
        }

        $user = User::create([
            'roleID' => $fields['reg-role'],
            'name' => $fields['reg-name'],
            'email' => $fields['reg-email'],
            'phone' => $fields['reg-phone'],
            'password' => bcrypt($fields['reg-pass']),
            'dateOfBirth' => $fields['reg-dob'],
            'accountStatus' => $status
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
            'groupFourCarer' => $caregiver4
        ]);


        $patients = json_decode(json_encode(DB::select('select userID from users where roleID = 5;')), true);
        for($i=0; $i < count($patients); $i++){
            DailyTask::create([
                'date' => $date,
                'patientID' => $patients[$i]['userID']
            ]);
        }

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
            return redirect('/employees');
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
            $balance = $patients[$i]->balance;
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

            PatientInfo::where('userID', $patients[$i]->userID)->update(['balance' => $balance, 'lastBalanceUpdate' => date('Y-m-d')]);
            return redirect('payments');

           

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


    public function addRole(Request $request){
        $role = $request->input('role');
        $accessLevel = $request->input('accessLevel');
        Role::create([
            'roleName' => $role,
            'accessLevel'=> $accessLevel
        ]);
        return redirect('/newRole');
    }

    public function assignGroup(Request $request){
        $patient = $request->input('patient');
        $group = $request->input('groupNum');
        PatientInfo::where('userID', $patient)->update(['groupNum'=>$group]);
        return redirect('/assignGroup');
    }

    public function newRegiment(Request $request) {
        $patient = $request->input("patientID");
        $comment = $request->input('comment');
        $morning = $request->input('morningMed');
        $afternoon = $request->input('afternoonMed');
        $evening = $request->input('eveningMed');
        Regiment::create([
            "doctorID" => $_SESSION["userID"],
            "patientID" => $patient,
            "comment" => $comment,
            "date" => Date("Y-m-d"),
            "morningMed" => $morning,
            "afternoonMed" => $afternoon,
            "eveningMed" => $evening
        ]);
        return redirect('/land');
    }

    public function land(){
        //for patient Home Page
        $reg = json_decode(json_encode(DB::select('select doctorID, dailyTasks.patientID, dailytasks.date, 
        dailytasks.docApt, dailytasks.morningMed, dailytasks.afternoonMed, dailytasks.eveningMed, dailytasks.breakfast, 
        dailytasks.lunch, dailytasks.dinner, patientinfo.groupNum,
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
        $caregiverAll = json_decode(json_encode(DB::select('select * from schedules;')), true);
        $caregiverOneName = json_decode(json_encode(DB::select('select date, name FROM schedules INNER JOIN users on (schedules.groupOneCarer = users.userID) ORDER BY schedules.date DESC;')), true);
        $caregiverTwoName = json_decode(json_encode(DB::select('select date, name FROM schedules INNER JOIN users on (schedules.groupTwoCarer = users.userID) ORDER BY schedules.date DESC;')), true);
        $caregiverThreeName = json_decode(json_encode(DB::select('select date, name FROM schedules INNER JOIN users on (schedules.groupThreeCarer = users.userID) ORDER BY schedules.date DESC;')), true);
        $caregiverFourName = json_decode(json_encode(DB::select('select date, name FROM schedules INNER JOIN users on (schedules.groupFourCarer = users.userID) ORDER BY schedules.date DESC;')), true);
        
        //for cargiver Home Page
        $caregiverPatientInfo = json_decode(json_encode(DB::select('select dailytasks.patientID, dailytasks.date, 
        dailytasks.morningMed, dailytasks.afternoonMed, dailytasks.eveningMed,
        dailytasks.breakfast, dailytasks.lunch, dailytasks.dinner, patientinfo.groupNum, dailytasks.docApt,
        CASE
        WHEN dailytasks.patientID IS NOT NULL THEN (select name FROM users WHERE users.userID=dailytasks.patientID)
        END AS patientName 
        from dailytasks INNER JOIN patientinfo on(dailytasks.patientID = patientinfo.UserID)
        where dailytasks.date = curdate();')), true);
        $patients = json_decode(json_encode(DB::select('select userID from users where roleID = 5;')), true);
        $regiments =[];
        for($i=0; $i < count($patients); $i++){
            $regiments[] = json_decode(json_encode(DB::select('select * from regiments where patientID ='. $patients[$i]['userID'].' order by date desc LIMIT 1;')), true);
        }
        return view('landing-page', compact('reg', 'takeMeds', 'caregiverOneName', 'caregiverTwoName', 'caregiverThreeName', 'caregiverFourName', 'caregiverPatientInfo', 'caregiverAll', 'regiments'));
    }

    public function caregiverUpdatePatient(Request $request){
        print_r ($request->all());
        $apt = $request->filled('docApt')? 1 : 0;
        $morningMed = $request->filled('morningMed')? 1 : 0;
        $afternoonMed = $request->filled('afternoonMed')? 1 : 0;
        $eveningMed = $request->filled('eveningMed')? 1 : 0;
        $breakfast = $request->filled('breakfast')? 1 : 0;
        $lunch = $request->filled('lunch')? 1 : 0;
        $dinner = $request->filled('dinner')? 1 : 0;
        $patientID = $request->input('patientID');
        $date = Date('Y-m-d');

        DailyTask::where('patientID', $patientID)->where('date', $date)->update(['morningMed' => $morningMed, 'docApt' => $apt, 'afternoonMed' => $afternoonMed, 'eveningMed' => $eveningMed, 'breakfast' => $breakfast, 'lunch' => $lunch, 'dinner' => $dinner]);
        return redirect('/land');
        return view('landing-page', compact('reg', 'takeMeds'));

    }

}


