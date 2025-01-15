<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DieSet;

class PoReceived extends Model
{
    protected $connection = 'mysql_rapid_pps';
    protected $table = 'tbl_POReceived';
    public $timestamps = false;

    public function dieset_info(){
    	return 
        $this
        ->hasOne(
        DieSet::class, 
            'R3Code', 'ItemCode')
        ->select([
            'R3Code',
            'DieNo',
            'NoOfCav',
            'DiesetWgt',
            'UnitWgt',
            'SprueWgt',
            'ShotWgt',
            'CycleShot',
            'ToolLife',
            'ToolShot',
            'ToolLifePMI',
            'MaintenanceCycle',
            'Material'
        ]);
    }

}
