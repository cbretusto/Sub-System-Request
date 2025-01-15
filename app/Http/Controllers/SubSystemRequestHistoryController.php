<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Auth; // or use Illuminate\Support\Facades\Auth;

use App\Exports\ExportData;
use App\Imports\SubSystemImport;

use App\Solid\Interfaces\SubSystemHistoryInterface;

class SubSystemRequestHistoryController extends Controller{
    public function __construct(SubSystemHistoryInterface $subsystem_request){
        $this->subsystem_request = $subsystem_request;
    }

    public function viewSubsystemRequestHistory(){
        return $this->subsystem_request->viewSubsystemRequestHistory();
    }

    public function export($category){
        return $this->subsystem_request->export($category);
    }

    public function import(){
        session_start();
        $rapidx_name = $_SESSION['rapidx_name'];        

        return $this->subsystem_request->import($rapidx_name);
    }

    public function subsystemRequestCreateUpdate(Request $request){
        session_start();
        $rapidx_name = $_SESSION['rapidx_name'];        
        
        if($request->subsystem_id == ''){
            $get_subsystem_request_id = '';
        }else{
            $get_subsystem_request_id = $request->subsystem_id;
        }
        return $this->subsystem_request->subsystemRequestCreateUpdate($get_subsystem_request_id,$request,$rapidx_name);
    }

    public function getSubSystemRequestInfoById(Request $request){
        $subsystem_request_info = $this->subsystem_request->getSubSystemRequestInfoById($request->subSystemRequestId);
        return response()->json(['subsystemRequestInfo' => $subsystem_request_info]);
    }

    public function getPoReceivedDetails(Request $request){
        $subsystem_request_po_received_info = $this->subsystem_request->getPoReceivedDetails($request->subSystemRequestOrderNo);
        return response()->json(['subsystemRequestPoReceivedInfo' => $subsystem_request_po_received_info]);
    }

}
