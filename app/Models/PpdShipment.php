<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdShipment extends Model
{
    protected $connection = 'mysql_rapid_pps';
    protected $table = 'tbl_Shipment';
}
