<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

use App\Models\SubSystemRequest;
use App\Models\PoReceived;
use App\Models\DieSet;

use App\Solid\Interfaces\ExportInterface;

use Auth;
use DataTables;

class ExportReportController extends Controller
{
    protected $export_report;
    public function __construct(ExportInterface $export_report){
        $this->export_report = $export_report;
    }

    public function searchPoReceivedDetails(Request $request){
        return $this->export_report->searchPoReceivedDetails($request);
    }

    public function export($category,$poNo,$deviceName,$from,$to){
        date_default_timezone_set('Asia/Manila');
        return $this->export_report->export($category,$poNo,$deviceName,$from,$to);
    }

    // public function export($category,$poNo,$deviceName,$from,$to){
    //     date_default_timezone_set('Asia/Manila');

    //     if(strpos($deviceName, '||') !== false) {
    //         $device_name_checking = str_replace("||", "/", $deviceName);            
    //     }else{
    //         $device_name_checking = $deviceName;
    //     }        

    //     $search_data_reports = 
    //     DB::connection('mysql_rapid_pps')
    //         ->table('tbl_POReceived')
    //         ->leftJoin('tbl_Shipment', 'tbl_POReceived.OrderNo', '=', 'tbl_Shipment.OrderNo')
    //         ->leftJoin('tbl_dieset', 'tbl_POReceived.ItemCode', '=', 'tbl_dieset.R3Code')
    //         ->leftJoin(
    //             DB::raw('(SELECT DISTINCT MaterialType, PartNumber FROM tbl_Warehouse) AS tbl_Warehouse'), 
    //             'tbl_dieset.Material', '=', 'tbl_Warehouse.MaterialType'
    //         )            
    //         // ->leftJoin('tbl_WarehouseTransaction', 'tbl_Warehouse.id', '=', 'tbl_WarehouseTransaction.fkid')
    //         ->where('tbl_POReceived.logdel', '0')
    //         ->whereBetween('tbl_POReceived.DateIssued', [$from, $to])
    //         ->when($poNo != 'null', function ($query) use ($poNo) {
    //             return $query->where('ProductPONo', $poNo);
    //         })
    //         ->when($deviceName != 'null', function ($query) use ($device_name_checking) {
    //             return $query->where('ItemName', $device_name_checking);
    //         })
    //         ->select(
    //             'tbl_POReceived.Category', 
    //             'tbl_POReceived.ProductPONo', 
    //             'tbl_POReceived.OrderNo',
    //             'tbl_POReceived.OrderQty',
    //             'tbl_POReceived.DrawingNo',
    //             'tbl_POReceived.ItemName', 
    //             'tbl_POReceived.ItemCode',
    //             'tbl_POReceived.DateIssued',
    //             'tbl_POReceived.POBalance',
    //             'tbl_POReceived.material_cost',

    //             'tbl_dieset.R3Code', 
    //             'tbl_dieset.DeviceName',
    //             'tbl_dieset.UnitWgt',
    //             'tbl_dieset.SprueWgt',
    //             'tbl_dieset.ShotWgt',
    //             'tbl_dieset.NoOfCav',
    //             'tbl_dieset.CycleShot',
                
    //             'tbl_Shipment.UnitPrice',

    //             'tbl_Warehouse.PartNumber', 
    //             'tbl_Warehouse.MaterialType',
    //             DB::raw(
    //                 // 'SUM(tbl_WarehouseTransaction.In) - SUM(tbl_WarehouseTransaction.Out) AS balance'
    //                 'SUM(tbl_Shipment.ShipoutQty) AS sum_ShipoutQty, SUM(tbl_Shipment.ShipoutQty) * tbl_Shipment.UnitPrice AS Computed'
    //             )
    //         )
    //         ->groupBy(
    //             'tbl_POReceived.Category', 
    //             'tbl_POReceived.ProductPONo', 
    //             'tbl_POReceived.OrderNo',
    //             'tbl_POReceived.OrderQty',
    //             'tbl_POReceived.DrawingNo',
    //             'tbl_POReceived.ItemName', 
    //             'tbl_POReceived.ItemCode',
    //             'tbl_POReceived.DateIssued',
    //             'tbl_POReceived.POBalance',
    //             'tbl_POReceived.material_cost',

    //             'tbl_dieset.R3Code', 
    //             'tbl_dieset.DeviceName',
    //             'tbl_dieset.UnitWgt',
    //             'tbl_dieset.SprueWgt',
    //             'tbl_dieset.ShotWgt',
    //             'tbl_dieset.NoOfCav',
    //             'tbl_dieset.CycleShot',
                
    //             'tbl_Shipment.UnitPrice',

    //             'tbl_Warehouse.PartNumber', 
    //             'tbl_Warehouse.MaterialType'
    //         )
    //         ->get();
    //         // return gettype($);
            
    //     if(!empty($search_data_reports)){
    //         $title = 'Sub-System Request Report ( From '.date("Y-m-d ", strtotime($from)).' To '.date("Y-m-d ", strtotime($to)).' ).xlsx';
    //         return Excel::download(new ExportData($search_data_reports,$category),$title);
    //     }else{
    //         return redirect()->back()->with('message', 'There are no data for the chosen date.');
    //     }
    // }

    // public function export($category, $poNo, $deviceName, $from, $to){
    //     // Set timezone
    //     date_default_timezone_set('Asia/Manila');

    //     // Clean up the device name if it contains '||'
    //     $device_name_checking = (strpos($deviceName, '||') !== false) ? str_replace("||", "/", $deviceName) : $deviceName;

    //     // Run the query without chunking to check if there are any records
    //     $search_data_reports = DB::connection('mysql_rapid_pps')
    //         ->table('tbl_POReceived')
    //         ->leftJoin('tbl_Shipment', 'tbl_POReceived.OrderNo', '=', 'tbl_Shipment.OrderNo')
    //         ->leftJoin('tbl_dieset', 'tbl_POReceived.ItemCode', '=', 'tbl_dieset.R3Code')
    //         ->leftJoin(
    //             DB::raw('(SELECT DISTINCT MaterialType, PartNumber FROM tbl_Warehouse) AS tbl_Warehouse'),
    //             'tbl_dieset.Material', '=', 'tbl_Warehouse.MaterialType'
    //         )
    //         ->where('tbl_POReceived.logdel', '0')
    //         ->whereBetween('tbl_POReceived.DateIssued', [$from, $to])
    //         ->when($poNo != 'null', function ($query) use ($poNo) {
    //             return $query->where('ProductPONo', $poNo);
    //         })
    //         ->when($device_name_checking != 'null', function ($query) use ($device_name_checking) {
    //             return $query->where('ItemName', $device_name_checking);
    //         })
    //         ->select(
    //             'tbl_POReceived.Category',
    //             'tbl_POReceived.ProductPONo',
    //             'tbl_POReceived.OrderNo',
    //             'tbl_POReceived.OrderQty',
    //             'tbl_POReceived.DrawingNo',
    //             'tbl_POReceived.ItemName',
    //             'tbl_POReceived.ItemCode',
    //             'tbl_POReceived.DateIssued',
    //             'tbl_POReceived.POBalance',
    //             'tbl_dieset.R3Code',
    //             'tbl_dieset.DeviceName',
    //             'tbl_dieset.UnitWgt',
    //             'tbl_dieset.SprueWgt',
    //             'tbl_dieset.ShotWgt',
    //             'tbl_dieset.NoOfCav',
    //             'tbl_dieset.CycleShot',
    //             'tbl_Shipment.UnitPrice',
    //             'tbl_Warehouse.PartNumber',
    //             'tbl_Warehouse.MaterialType',
    //             DB::raw('SUM(tbl_Shipment.ShipoutQty) AS sum_ShipoutQty'),
    //             DB::raw('SUM(tbl_Shipment.ShipoutQty) * tbl_Shipment.UnitPrice AS Computed')
    //         )
    //         ->groupBy(
    //             'tbl_POReceived.Category',
    //             'tbl_POReceived.ProductPONo',
    //             'tbl_POReceived.OrderNo',
    //             'tbl_POReceived.OrderQty',
    //             'tbl_POReceived.DrawingNo',
    //             'tbl_POReceived.ItemName',
    //             'tbl_POReceived.ItemCode',
    //             'tbl_POReceived.DateIssued',
    //             'tbl_POReceived.POBalance',
    //             'tbl_dieset.R3Code',
    //             'tbl_dieset.DeviceName',
    //             'tbl_dieset.UnitWgt',
    //             'tbl_dieset.SprueWgt',
    //             'tbl_dieset.ShotWgt',
    //             'tbl_dieset.NoOfCav',
    //             'tbl_dieset.CycleShot',
    //             'tbl_Shipment.UnitPrice',
    //             'tbl_Warehouse.PartNumber',
    //             'tbl_Warehouse.MaterialType'
    //         )
    //         ->get();

    //     if ($search_data_reports->isEmpty()) {
    //         return redirect()->back()->with('message', 'There are no data for the chosen date.');
    //     }

    //     $title = 'Sub-System Request Report ( From ' . date("Y-m-d ", strtotime($from)) . ' To ' . date("Y-m-d ", strtotime($to)) . ' ).xlsx';

    //     return Excel::download(new ExportData($search_data_reports, $category), $title);
    // }

    // public function export($category,$poNo,$deviceName,$from,$to){
    //     date_default_timezone_set('Asia/Manila');

    //     if(strpos($deviceName, '||') !== false) {
    //         $device_name_checking = str_replace("||", "/", $deviceName);            
    //     }else{
    //         $device_name_checking = $deviceName;
    //     }        

    //     $sql = '
    //     (SELECT 
    //         tbl_POReceived.Category, 
    //         tbl_POReceived.ProductPONo, 
    //         tbl_POReceived.OrderNo,
    //         tbl_POReceived.OrderQty,
    //         tbl_POReceived.DrawingNo,
    //         tbl_POReceived.ItemName, 
    //         tbl_POReceived.ItemCode,
    //         tbl_POReceived.DateIssued,
    
    //         tbl_dieset.R3Code, 
    //         tbl_dieset.Material,
    //         tbl_dieset.UnitWgt,
    //         tbl_dieset.SprueWgt,
    //         tbl_dieset.ShotWgt,
    //         tbl_dieset.NoOfCav,
    //         tbl_dieset.CycleShot,
            
    //         tbl_Warehouse.PartNumber, 
    //         tbl_Warehouse.MaterialType,
    
    //     SUM(tbl_WarehouseTransaction.In) - SUM(tbl_WarehouseTransaction.Out) AS ppd_warehouse_transaction_balance
    
    //     FROM tbl_POReceived
    //         LEFT JOIN tbl_dieset ON tbl_POReceived.ItemCode = tbl_dieset.R3Code
    //         LEFT JOIN tbl_Warehouse ON tbl_dieset.Material = tbl_Warehouse.MaterialType
    //         LEFT JOIN tbl_WarehouseTransaction ON tbl_Warehouse.id = tbl_WarehouseTransaction.fkid
    //         WHERE tbl_POReceived.logdel = 0
    //         AND tbl_POReceived.DateIssued BETWEEN ? AND ?
    //         ' . ($poNo != 'null' ? 'AND tbl_POReceived.ProductPONo = ? ' : '') . 
    //         ($deviceName != 'null' ? 'AND tbl_POReceived.ItemName = ? ' : '') . '

    //     GROUP BY 
    //         tbl_POReceived.Category, 
    //         tbl_POReceived.ProductPONo, 
    //         tbl_POReceived.OrderNo,
    //         tbl_POReceived.OrderQty,
    //         tbl_POReceived.DrawingNo,
    //         tbl_POReceived.ItemName, 
    //         tbl_POReceived.ItemCode,
    //         tbl_POReceived.DateIssued,
    
    //         tbl_dieset.R3Code, 
    //         tbl_dieset.Material,
    //         tbl_dieset.UnitWgt,
    //         tbl_dieset.SprueWgt,
    //         tbl_dieset.ShotWgt,
    //         tbl_dieset.NoOfCav,
    //         tbl_dieset.CycleShot,
            
    //         tbl_Warehouse.PartNumber, 
    //         tbl_Warehouse.MaterialType
    //     ) AS aggregated_data
    // ';
    
    //     $select_data = [$from, $to]; 
        
    //     if ($poNo != 'null') {
    //         $select_data[] = $poNo;
    //     }
        
    //     if ($deviceName != 'null') {
    //         $select_data[] = $device_name_checking;
    //     }
        
    //     $search_data_reports = DB::connection('mysql_rapid_pps')
    //         ->table(DB::raw($sql))
    //         ->addBinding($select_data, 'select')
    //         ->get();
        
    //     return $search_data_reports;

    //     // return gettype($);

    //     if(!empty($search_data_reports)){
    //         $title = 'Sub-System Request Report ( From '.date("Y-m-d ", strtotime($from)).' To '.date("Y-m-d ", strtotime($to)).' ).xlsx';
    //         return Excel::download(new ExportData($search_data_reports,$category),$title);
    //     }else{
    //         return redirect()->back()->with('message', 'There are no data for the chosen date.');
    //     }
    // }
}