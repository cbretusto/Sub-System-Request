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

use App\Exports\sheets\ExportSummarySheet;
use App\Exports\sheets\ExportDataSheet;

class ExportData implements WithMultipleSheets
{
    use Exportable;
    protected $search_data_reports;
    protected $category;
    protected $group_by;
    protected $po_received_category;

    function __construct(
        $search_data_reports,
        $category,
        $group_by,
        $po_received_category
    ){
        $this->search_data_reports = $search_data_reports;
        $this->category = $category;
        $this->group_by = $group_by;
        $this->po_received_category = $po_received_category;
    }

    public function sheets(): array{
        $sheets = [];
        $sheets[] = new ExportSummarySheet($this->category, $this->group_by, $this->po_received_category);
        $sheets[] = new ExportDataSheet($this->search_data_reports, $this->category);

        return $sheets;
    }
}
