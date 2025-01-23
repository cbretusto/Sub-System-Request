<?php
namespace App\Solid\Repositories;

use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Import Interfaces
 */
use App\Solid\Interfaces\SubSystemPoReceivedCategoryInterface;

/**
 * Import Models
 */
use App\Models\SubSystemPoReceivedCategory;
use App\Models\UserManagement;

class SubSystemPoReceivedCategoryRepository implements SubSystemPoReceivedCategoryInterface
{
    public function viewSubsystemPoReceivedCategory(){
        session_start();
        $rapidx_user_id = $_SESSION['rapidx_user_id'];

        $view_subsystem_po_received_categories = SubSystemPoReceivedCategory::where('logdel', 0)->get();
        $check_user = UserManagement::where('rapidx_user_id', $rapidx_user_id)->where('status', 0)->where('logdel', 0)->get();

        return DataTables::of($view_subsystem_po_received_categories)
        ->addColumn('action', function($view_subsystem_po_received_category) use($check_user){
            $result =  '<center>';
            if($check_user->isNotEmpty()){
                if($view_subsystem_po_received_category->status == 0){
                    $result .= '<button type="button" class="btn btn-dark btn-sm text-center actionEditSubSystemPoReceivedCategory" subsystem_po_received_category-id="' . $view_subsystem_po_received_category->id . '" data-bs-toggle="modal" data-bs-target="#modalCreateUpdateSubSystemPoReceivedCategory" title="Edit Category"><i class="fa fa-edit"></i></button>&nbsp;';
                    $result .= '<button type="button" class="btn btn-danger btn-sm text-center actionChangeSubSystemPoReceivedCategoryStatus" subsystem_po_received_category-id="' . $view_subsystem_po_received_category->id . '" status="1" data-bs-toggle="modal" data-bs-target="#modalChangeSubSystemPoReceivedCategoryStatus" title="Deactivate User"><i class="fa-solid fa-ban"></i></button>';
                }else{
                    $result .= '<button type="button" class="btn btn-warning btn-sm text-center actionChangeSubSystemPoReceivedCategoryStatus" subsystem_po_received_category-id="' . $view_subsystem_po_received_category->id . '" status="0" data-bs-toggle="modal" data-bs-target="#modalChangeSubSystemPoReceivedCategoryStatus" title="Activate User"><i class="fa-solid fa-arrow-rotate-right"></i></button>';
                }
            }else{
                $result .= '<center><span class="badge bg-dark">The user doesn`t exist in the User List</span></center>';
            }
            $result .= '</center>';
            return $result;
        })

        ->rawColumns([
            'action',
        ])
        ->make(true);

    }

    public function createUpdateSubsystemPoReceivedCategory($get_subsystem_po_received_category_id,$request, $rapidx_name){
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();
        $validator = Validator::make($data, [

        ]);
    
        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        } else {
            // DB::beginTransaction();
            // try {

                if($request->subsystem_po_received_category_id == ''){
                    if(SubSystemPoReceivedCategory::where('category', $request->category)->where('status', 0)->where('logdel', 0)->doesntExist()){
                        SubSystemPoReceivedCategory::insert([
                            'category'      => $request->category,
                            'uploaded_by'   => $rapidx_name,
                            'created_at'    => date('Y-m-d H:i:s')
                        ]);   
                    }else{
                        return response()->json(['hasError' => 1]);
                    } 
                }else{
                    SubSystemPoReceivedCategory::where('id', $request->subsystem_po_received_category_id)->update([
                        'category'      => $request->category,
                        'updated_by'    => $rapidx_name,
                        'updated_at'    => date('Y-m-d H:i:s')
                    ]);
                }

                // DB::commit();
                return response()->json(['hasError' => 0]);
            // } catch (\Exception $e) {
            //     DB::rollback();
            //     return response()->json(['hasError' => 1, 'exceptionError' => $e->getMessage()]);
            // }
        }
    }

    public function getSubsystemPoReceivedCategoryInfoById($get_category_id){
        return SubSystemPoReceivedCategory::where('id', $get_category_id)->where('status', 0)->where('logdel', 0)->get();
    }

    public function changeSubSystemPoReceivedCategoryStatus($request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        $validator = Validator::make($data, [
            
        ]);
    
        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();
            try {
                SubSystemPoReceivedCategory::where('id', $request->category_id)->update([
                    'status'        => $request->status,                        
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);
                DB::commit();
                return response()->json(['hasError' => 0]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['hasError' => 1, 'exceptionError' => $e->getMessage()]);
            }
        }
    }

}