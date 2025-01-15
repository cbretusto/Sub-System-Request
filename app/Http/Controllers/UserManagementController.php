<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Auth; // or use Illuminate\Support\Facades\Auth;

// use App\Http\Requests\user;
use App\Solid\Interfaces\UserManagementInterface;

class UserManagementController extends Controller
{
    protected $user_management;
    public function __construct(UserManagementInterface $user_management){
        $this->user_management = $user_management;
    }

    public function viewUser(){
        return $user_details = $this->user_management->getUsers();
    }
    
    public function getRapidxUserActiveInSystemOne(){
        $rapidx_name_active_in_systemone = $this->user_management->getRapidxUserActiveInSystemOne();
        return response()->json(['rapidxNameActiveInSystemone' => $rapidx_name_active_in_systemone]);
    }

    public function getSystemOneDepartment(){
        $systemone_department = $this->user_management->getSystemOneDepartment();
        return response()->json(['systemoneDepartment' => $systemone_department]);
    }

    public function getSystemOnePosition(){
        $systemone_position = $this->user_management->getSystemOnePosition();
        return response()->json(['systemonePosition' => $systemone_position]);
    }
    
    public function userCreateUpdate(Request $request){
        if($request->user_id == ''){
            $get_user_id = '';
        }else{
            $get_user_id = $request->user_id;
        }
        return $this->user_management->userCreateUpdate($get_user_id,$request);
    }
    
    public function getUserInfoById(Request $request){
        $subsystem_request_user_info = $this->user_management->getUserInfoById($request->UserId);
        return response()->json(['subsystemRequestUserInfo' => $subsystem_request_user_info]);
    }

    public function changeUserStatus(Request $request){
        return $this->user_management->changeUserStatus($request);
    }

    public function getUserLog(Request $request){
        $get_user_log_info = $this->user_management->getUserLog($request->loginEmployeeId);
        return response()->json(['getUserLogInfo' => $get_user_log_info]);
    }
}
