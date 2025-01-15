<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\PpdWarehouseTransaction;

class PpdWarehouse extends Model
{
    protected $connection = 'mysql_rapid_pps';
    protected $table = 'tbl_Warehouse';

    public function ppd_warehouse_transaction_info(){
    	return 
        $this
        ->hasMany(
            PpdWarehouseTransaction::class, 
            'fkid', 'id')
        // ->select([
        //     'fkid',
        //     'In',
        //     'Out'
        // ])
        ;
    }
}
