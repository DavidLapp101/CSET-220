<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

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
            'password' => $fields['reg-pass'],
            'dateOfBirth' => $fields['reg-dob'],
        ]);

        if ($fields["reg-role"] == 5) {
            
        }

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

}
