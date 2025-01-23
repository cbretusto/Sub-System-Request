<?php
namespace App\Solid\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use DataTables;

/**
 * Import Interfaces
 */
use App\Solid\Interfaces\UserManagementInterface;

/**
 * Import Models
 */
use App\Models\RapidxUser;
use App\Models\UserManagement;
use App\Models\SystemOneHrisDepartment;
use App\Models\SystemOneHrisPosition;

class UserManagementRepository implements UserManagementInterface
{
    public function getUsers(){
        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];

        $user_details = UserManagement::with([
            'user_management_rapidx_user_info',
            'user_management_systemone_department_info',
            'user_management_systemone_position_info'
        ])
        ->where('logdel', 0)
        ->get();
        // return $user_details;
        return DataTables::of($user_details)
        ->addColumn('action', function($user_detail) use($rapidx_user_id){
            $check_access = UserManagement::where('rapidx_user_id',$rapidx_user_id)->where('user_level', 0)->where('status', 0)->where('logdel', 0)->get();

            $result = '<center>';
            if($check_access->isNotEmpty()){
                if($user_detail->status == 0){
                    $result .= '<button type="button" class="btn btn-dark btn-sm text-center actionUserManagementEdit" user-id="' . $user_detail->id . '" data-bs-toggle="modal" data-bs-target="#modalUserManagementCreateUpdate" title="Edit User Details"><i class="fa fa-edit"></i></button>&nbsp;';
                    $result .= '<button type="button" class="btn btn-danger btn-sm text-center actionUserManagementChangeUserStatus" user-id="' . $user_detail->id . '" status="1" data-bs-toggle="modal" data-bs-target="#modalUserManagementChangeUserStatus" title="Deactivate User"><i class="fa-solid fa-ban"></i></button>';
                }else{
                    $result .= '<button type="button" class="btn btn-warning btn-sm text-center actionUserManagementChangeUserStatus" user-id="' . $user_detail->id . '" status="0" data-bs-toggle="modal" data-bs-target="#modalUserManagementChangeUserStatus" title="Activate User"><i class="fa-solid fa-arrow-rotate-right"></i></button>';
                }
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('status', function($user_detail){
            $result = "";
            if($user_detail->status == 0){
                $result .= '<center><span class="badge bg-success">Active</span></center>';
            }else{
                $result .= '<center><span class="badge bg-danger">Inactive</span></center>';
            }
            return $result;
        })

        ->rawColumns([
            'action',
            'status'
        ])
        ->make(true);

    }

    public function getRapidxUserActiveInSystemOne(){
        return RapidxUser::with([
            'rapidx_systemone_employee_info',
            'rapidx_systemone_subcon_info'
        ])
        ->where('user_stat', 1)
        ->orderBy('name', 'ASC')
        ->get(['id','employee_number','name','email']);
    }

    public function getSystemOneDepartment(){
        return SystemOneHrisDepartment::with('systemone_division_info')->orderBy('Department', 'ASC')->get(['pkid','Department','fkDivision']);
    }

    public function getSystemOnePosition(){
        return SystemOneHrisPosition::orderBy('Position', 'ASC')->get(['pkid','Position']);
    }

    public function userCreateUpdate($get_user_id,$request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        $validator = Validator::make($data, [

        ]);
    
        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();
            try {
                if($request->user_id == ''){
                    if(UserManagement::where('rapidx_user_id', $request->name)->where('status', 0)->where('logdel', 0)->doesntExist()){
                        UserManagement::insert([
                            'rapidx_user_id'    => $request->name,
                            'user_level'        => $request->user_level,
                            'department'        => $request->department,
                            'position'          => $request->position,
                            'created_at'        => date('Y-m-d H:i:s'),
                        ]);   
                    }else{
                        return response()->json(['hasError' => 1]);
                    } 
                }else{
                    UserManagement::where('id', $request->user_id)->update([
                        'rapidx_user_id'    => $request->name,
                        'user_level'        => $request->user_level,
                        'department'        => $request->department,
                        'position'          => $request->position,                        
                        'updated_at'        => date('Y-m-d H:i:s'),
                    ]);
                }

                DB::commit();
                return response()->json(['hasError' => 0]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['hasError' => 1, 'exceptionError' => $e->getMessage()]);
            }
        }
    }

    public function getUserInfoById($get_request_id){
        return UserManagement::where('id', $get_request_id)->where('logdel', 0)->get();
    }

    public function changeUserStatus($request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        $validator = Validator::make($data, [
            
        ]);
    
        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();
            try {
                UserManagement::where('id', $request->user_id)->update([
                    'status'          => $request->status,                        
                    'updated_at'        => date('Y-m-d H:i:s'),
                ]);
                DB::commit();
                return response()->json(['hasError' => 0]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['hasError' => 1, 'exceptionError' => $e->getMessage()]);
            }
        }
    }

    public function getUserLog($loginEmployeeId){
        return RapidxUser::with('subsystem_user_info')->where('id', $loginEmployeeId)->where('user_stat', 1)->get();
    }

}