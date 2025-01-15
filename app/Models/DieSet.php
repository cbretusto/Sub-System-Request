<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\PpdWarehouse;

class DieSet extends Model
{
    protected $connection = 'mysql_rapid_pps';
    protected $table = 'tbl_dieset';

    public function ppd_warehouse_info(){
    	return 
        $this
        ->hasOne(
        PpdWarehouse::class, 
            'MaterialType', 'Material')
        ->select([
            'id',
            'PartNumber',
            'MaterialType',
        ]);
    }

}
