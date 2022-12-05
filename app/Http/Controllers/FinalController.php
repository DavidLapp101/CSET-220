<?php

namespace App\Http\Controllers;

use App\Models\PatientInfo;
use App\Models\Role;
use App\Models\Schedule;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

session_start();

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

        return redirect('/land');

    }


    public function acceptDeclineUsers(Request $request){

        $user = $request->input('user');
        $action = $request->input('approve/decline');
        if($action == 'accept'){
            User::where('userID', $user)->update(['accountStatus' => "approved"]);
            
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

    public function changeSalary(Request $request){
        $employee = $request->input('employee');
        $salary = $request->input('salary');
        $list = json_decode(json_encode(DB::select('select userID from users where 
        roleID between 1 and 4')), true);
        echo $employee;
        echo $salary;
        print_r($list);
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



}


