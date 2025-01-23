<?php
namespace App\Solid\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportData;

/**
 * Import Interfaces
 */
use App\Solid\Interfaces\ExportInterface;

/**
 * Import Models
 */
use App\Models\SubSystemPoReceivedCategory;
use App\Models\SubSystemRequest;
use App\Models\PoReceived;
use App\Models\DieSet;

class ExportRepository implements ExportInterface
{
    public function searchPoReceivedDetails($request){
        if($request->check == '1'){
            $po_received_details = DB::connection('mysql_rapid_pps')
                ->select("SELECT ProductPONo
                    FROM tbl_POReceived
                    WHERE logdel = '0'
                    GROUP BY ProductPONo
                ");
        }else if($request->check == '2'){
            $po_received_details = DB::connection('mysql_rapid_pps')
            ->select("SELECT ItemName
                FROM tbl_POReceived
                WHERE logdel = '0'
                GROUP BY ItemName
            ");
        }else{
            if($request->check != ''){
                $po_received_details = DB::connection('mysql_rapid_pps')
                ->table('tbl_POReceived')
                ->select(DB::raw('ItemCode, MAX(ItemName) as ItemName'))
                ->where('logdel', '0')
                ->where('ItemCode', $request->check)
                ->groupBy('ItemCode')
                ->get();
            }else{
                $po_received_details = DB::connection('mysql_rapid_pps')
                ->select("SELECT ItemCode
                    FROM tbl_POReceived
                    WHERE logdel = '0'
                    GROUP BY ItemCode
                ");
            }
        }
        return response()->json(['getSearchPoReceivedDetails' => $po_received_details]);
    }

    public function export($category,$poNo,$deviceName,$from,$to){
        date_default_timezone_set('Asia/Manila');

        if(strpos($deviceName, '||') !== false) {
            $device_name_checking = str_replace("||", "/", $deviceName);            
        }else{
            $device_name_checking = $deviceName;
        }        

        $search_data_reports = 
        DB::connection('mysql_rapid_pps')
            ->table('tbl_POReceived')
            ->leftJoin('tbl_Shipment', 'tbl_POReceived.OrderNo', '=', 'tbl_Shipment.OrderNo')
            ->leftJoin('tbl_dieset', 'tbl_POReceived.ItemCode', '=', 'tbl_dieset.R3Code')
            ->leftJoin(
                DB::raw('(SELECT DISTINCT MaterialType, PartNumber FROM tbl_Warehouse) AS tbl_Warehouse'), 
                'tbl_dieset.Material', '=', 'tbl_Warehouse.MaterialType'
            )
            ->where('tbl_POReceived.OrderNo', 'not like', 'TS%')
            ->where('tbl_POReceived.OrderNo', 'not like', 'CN%')            
            ->where('tbl_POReceived.logdel', '0')
            ->whereBetween('tbl_POReceived.DateIssued', [$from, $to])
            ->when($poNo != 'null', function ($query) use ($poNo) {
                return $query->where('ProductPONo', $poNo);
            })
            ->when($deviceName != 'null', function ($query) use ($device_name_checking) {
                return $query->where('ItemName', $device_name_checking);
            })
            ->orderBy('DateIssued', 'ASC')
            ->select(
                'tbl_POReceived.Category', 
                'tbl_POReceived.ProductPONo', 
                'tbl_POReceived.ItemCode',
                'tbl_POReceived.ItemName', 
                'tbl_POReceived.OrderNo',
                'tbl_POReceived.OrderQty',
                'tbl_POReceived.Price',
                'tbl_POReceived.DateIssued',
                'tbl_POReceived.ShipOutPPS',
                'tbl_POReceived.POBalance',
                'tbl_POReceived.material_cost',
                'tbl_POReceived.location',

                'tbl_dieset.R3Code', 
                'tbl_dieset.DeviceName',
                'tbl_dieset.DrawingNo',
                'tbl_dieset.UnitWgt',
                'tbl_dieset.SprueWgt',
                'tbl_dieset.ShotWgt',
                'tbl_dieset.NoOfCav',
                'tbl_dieset.CycleShot',
                
                'tbl_Shipment.UnitPrice',

                'tbl_Warehouse.PartNumber', 
                'tbl_Warehouse.MaterialType',
                DB::raw(
                    'SUM(tbl_Shipment.ShipoutQty) AS sum_ShipoutQty, SUM(tbl_Shipment.ShipoutQty) * tbl_Shipment.UnitPrice AS Computed'
                )
            )
            ->groupBy(
                'tbl_POReceived.Category', 
                'tbl_POReceived.ProductPONo', 
                'tbl_POReceived.ItemCode',
                'tbl_POReceived.ItemName', 
                'tbl_POReceived.OrderNo',
                'tbl_POReceived.OrderQty',
                'tbl_POReceived.Price',
                'tbl_POReceived.DateIssued',
                'tbl_POReceived.ShipOutPPS',
                'tbl_POReceived.POBalance',
                'tbl_POReceived.material_cost',
                'tbl_POReceived.location',

                'tbl_dieset.R3Code', 
                'tbl_dieset.DeviceName',
                'tbl_dieset.DrawingNo',
                'tbl_dieset.UnitWgt',
                'tbl_dieset.SprueWgt',
                'tbl_dieset.ShotWgt',
                'tbl_dieset.NoOfCav',
                'tbl_dieset.CycleShot',
                
                'tbl_Shipment.UnitPrice',

                'tbl_Warehouse.PartNumber', 
                'tbl_Warehouse.MaterialType'
            )
            ->get();

            $group_by = $search_data_reports->groupBy('Category')->map(function ($details){
                $category_name = $details[0]->Category; // PO RECEIVED CATEGORY
                $sum_OrderQty = $details->sum('OrderQty');
                $sum_Price = $details->sum('Price');
                $sum_ShipoutQty = $details->sum('sum_ShipoutQty');
                
                // $mapped_details = $details->map(function ($detail) {
                //     return [
                //         'OrderQty' => $detail->OrderQty,
                //         'UnitPrice' => $detail->UnitPrice,
                //         'sum_ShipoutQty' => $detail->sum_ShipoutQty,
                //     ];
                // });
                

                return [
                    'category_name'     => $category_name,
                    'sum_OrderQty'      => $sum_OrderQty,
                    'sum_Price'         => $sum_Price,
                    'sum_ShipoutQty'    => $sum_ShipoutQty,
                ];
            })
            ->values()
            ->toArray();
            
            $po_received_category = SubSystemPoReceivedCategory::where('status', 0)->where('logdel', 0)->get();
            // $qwe = DB::connection('mysql_rapid_pps')
            //     ->table('tbl_POReceived')
            //     ->where('logdel', '0')
            //     ->select('tbl_POReceived.category')
            //     ->groupBy('tbl_POReceived.category')
            //     ->get();

            // return $search_data_reports;
            // return $group_by[0]['category'];
            // return gettype($);
            
        if(!empty($search_data_reports)){
            $title = 'Sub-System Request Report ( From '.date("Y-m-d ", strtotime($from)).' To '.date("Y-m-d ", strtotime($to)).' ).xlsx';
            return Excel::download(new ExportData($search_data_reports,$category,$group_by,$po_received_category),$title);
        }else{
            return redirect()->back()->with('message', 'There are no data for the chosen date.');
        }
    }
}