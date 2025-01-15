<?php
namespace App\Solid\Repositories;

use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Imports\SubSystemImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportDataForMaterialCost;

/**
 * Import Interfaces
 */
use App\Solid\Interfaces\SubSystemHistoryInterface;

/**
 * Import Models
 */
use App\Models\PoReceived;
use App\Models\SubSystemHistoryLogs;
use App\Models\SubSystemRequest;

class SubSystemHistoryRepository implements SubSystemHistoryInterface
{
    public function viewSubsystemRequestHistory(){
        $view_subsystem_requests = SubSystemRequest::where('logdel', 0)->get();

        return DataTables::of($view_subsystem_requests)
        ->addColumn('action', function($view_subsystem_request){
            $result =  '<center>';
            $result .= '<button type="button" class="btn btn-dark btn-sm text-center actionSubSystemRequestEdit button-hide d-none" subsystem_request-id="' . $view_subsystem_request->id . '" data-bs-toggle="modal" data-bs-target="#modalCreateUpdateSubSystemRequest" title="Edit Details"><i class="fa fa-edit"></i></button>&nbsp;';
            $result .= '<button type="button" class="btn btn-primary btn-sm text-center actionViewPoReceivedDetails" subsystem_request-order_no="' . $view_subsystem_request->order_no . '" data-bs-toggle="modal" data-bs-target="#modalViewPoRevievedDetails" title="View Details"><i class="fa fa-eye"></i></button>&nbsp;';
            $result .= '</center>';
            return $result;
        })

        ->rawColumns([
            'action',
        ])
        ->make(true);

    }

    public function export($category){
        if($category == 1){
            $subsystem_history = SubSystemRequest::where('logdel', 0)->get();
            $title = 'Sub-System Request ( Material Cost ).xlsx';
        }else{
            $subsystem_history = '';
            $title = 'Sub-System Request ( Material Cost Template ).xlsx';
        }

        return Excel::download(new ExportDataForMaterialCost($category, $subsystem_history),$title);
    }

    public function import($rapidx_name){
        DB::beginTransaction();
        try{
            SubSystemRequest::whereNotNull('id')->delete(); 
            $import_collections = Excel::toCollection(new SubSystemImport, request()->file('import_subsystem_request'));
            $check_batch_no = SubSystemHistoryLogs::orderBy('batch','desc')->distinct()->get('batch');

            if($check_batch_no->isNotEmpty()){
                $get_last_batch_no = $check_batch_no[0]->batch+1;
            }else{
                $get_last_batch_no = 1;
            }
            
            // return $import_collections;
            for($column_start = 1; $column_start < count($import_collections[0]); $column_start++){
                $order_no = preg_replace('/\s+/', '', $import_collections[0][$column_start][0]);
                $material_cost = preg_replace('/\s+/', '', $import_collections[0][$column_start][3]);

                $import_array = [
                    'order_no'          => $order_no,
                    'item_code'         => $import_collections[0][$column_start][1],
                    'item_name'         => $import_collections[0][$column_start][2],
                    'material_cost'     => $material_cost,
                    'location'          => $import_collections[0][$column_start][4],
                    'uploaded_by'       => $rapidx_name,
                    'created_at'        => date('Y-m-d H:i:s')
                ];
                SubSystemRequest::insert(
                    $import_array
                );

                $import_array['batch'] = $get_last_batch_no;
                SubSystemHistoryLogs::insert(
                    $import_array
                );

                PoReceived::where('OrderNo', strval($order_no))->update([
                    'material_cost' => $material_cost,
                    'location'      => $import_collections[0][$column_start][4]
                ]);
            }
            DB::commit();
            return response()->json(['result' => 1]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['hasError' => 1, 'exceptionError' => $e->getMessage()]);
        }      
    }

    public function subsystemRequestCreateUpdate($get_subsystem_request_id,$request, $rapidx_name){
        $data = $request->all();
        $validator = Validator::make($data, [

        ]);
    
        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        } else {
            // DB::beginTransaction();
            // try {
                $check_batch_no = SubSystemHistoryLogs::orderBy('batch','desc')->distinct()->get('batch');
                if($check_batch_no->isNotEmpty()){
                    $get_last_batch_no = $check_batch_no[0]->batch+1;
                }else{
                    $get_last_batch_no = 1;
                }

                $create_update_array = [
                    'order_no'      => $request->order_no,
                    'item_code'     => $request->item_code,
                    'item_name'     => $request->item_name,
                    'material_cost' => $request->material_cost,
                    'location'      => $request->location,
                ];

                if($request->subsystem_request_id == ''){
                    if(SubSystemRequest::where('order_no', $request->order_no)->where('logdel', 0)->doesntExist()){
                        $create_update_array['uploaded_by'] = $rapidx_name;
                        $create_update_array['created_at']  = date('Y-m-d H:i:s');

                        SubSystemRequest::insert([
                            $create_update_array
                        ]);   
                    }else{
                        return response()->json(['hasError' => 1]);
                    } 
                }else{
                    $create_update_array['updated_by']  = $rapidx_name;
                    $create_update_array['updated_at']  = date('Y-m-d H:i:s');
                    // return $create_update_array;
                    SubSystemRequest::where('id', $request->subsystem_request_id)->update(
                        $create_update_array
                    );
                }

                $create_update_array['batch'] = $get_last_batch_no;
                SubSystemHistoryLogs::insert([
                    $create_update_array
                ]);

                PoReceived::where('OrderNo', $request->order_no)->update([
                    'material_cost' => $request->material_cost
                ]);

                // DB::commit();
                return response()->json(['hasError' => 0]);
            // } catch (\Exception $e) {
            //     DB::rollback();
            //     return response()->json(['hasError' => 1, 'exceptionError' => $e->getMessage()]);
            // }
        }
    }

    public function getSubSystemRequestInfoById($get_request_id){
        return SubSystemRequest::where('id', $get_request_id)->where('logdel', 0)->get();
    }

    public function getPoReceivedDetails($subsystem_request_order_no){
        return PoReceived::where('OrderNo', $subsystem_request_order_no)->where('logdel', 0)->get();
    }
}