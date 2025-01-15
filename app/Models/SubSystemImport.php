<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSystemImport extends Model
{
    protected $fillable = [
        'order_no',
        'item_code',
        'item_name',
        'material_cost',
    ];
}
