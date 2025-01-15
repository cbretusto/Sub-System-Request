<?php

namespace App\Imports;

use App\Models\SubSystemRequest;

use Maatwebsite\Excel\Concerns\ToModel;

class SubSystemImport implements ToModel
{
    public function model(array $row)
    {
        return new SubSystemRequest([
            'order_no' => $row[0],
            'item_code' => $row[1],
            'item_name' => $row[2],
            'material_cost' => $row[3],
            'Location' => $row[4]
        ]);
    }
}