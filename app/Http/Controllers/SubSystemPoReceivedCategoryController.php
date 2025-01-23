<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Solid\Interfaces\SubSystemPoReceivedCategoryInterface;

class SubSystemPoReceivedCategoryController extends Controller
{
    public function __construct(SubSystemPoReceivedCategoryInterface $subsystem_po_received_category){
        $this->subsystem_po_received_category = $subsystem_po_received_category;
    }

    public function viewSubsystemPoReceivedCategory(){
        return $this->subsystem_po_received_category->viewSubsystemPoReceivedCategory();
    }

    public function createUpdateSubsystemPoReceivedCategory(Request $request){
        session_start();
        $rapidx_name = $_SESSION['rapidx_name'];        
        
        if($request->subsystem_po_received_category_id == ''){
            $get_subsystem_po_received_category_id = '';
        }else{
            $get_subsystem_po_received_category_id = $request->subsystem_po_received_category_id;
        }
        return $this->subsystem_po_received_category->createUpdateSubsystemPoReceivedCategory($get_subsystem_po_received_category_id,$request,$rapidx_name);
    }

    public function getSubsystemPoReceivedCategoryInfoById(Request $request){
        $subsystem_po_received_category_info = $this->subsystem_po_received_category->getSubsystemPoReceivedCategoryInfoById($request->subSystemPoReceivedCategoryId);
        return response()->json(['subsystemPoReceivedCategoryInfo' => $subsystem_po_received_category_info]);
    }

    public function changeSubSystemPoReceivedCategoryStatus(Request $request){
        return $this->subsystem_po_received_category->changeSubSystemPoReceivedCategoryStatus($request);
    }


}
