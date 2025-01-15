<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;

use PhpOffice\PhpSpreadsheet\Style\Alignment;

Use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithDrawings;
// use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use App\Exports\sheets\ExportDataForMaterialCostSheet;

class ExportDataForMaterialCost implements WithMultipleSheets
{
    use Exportable;
    protected $category;
    protected $subsystem_history;

    function __construct(
        $category,
        $subsystem_history
    ){
        $this->category = $category;
        $this->subsystem_history = $subsystem_history;
    }

    public function sheets(): array{
        $sheets = [];
        $sheets[] = new ExportDataForMaterialCostSheet($this->category,$this->subsystem_history);

        return $sheets;
    }
}
