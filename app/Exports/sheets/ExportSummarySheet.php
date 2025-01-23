<?php

namespace App\Exports\sheets;

use Illuminate\Contracts\View\View;

Use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;

// use Maatwebsite\Excel\Concerns\WithMultipleSheets;
// use Maatwebsite\Excel\Concerns\WithDrawings;
// use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

use PhpOffice\PhpSpreadsheet\Style\Alignment;



class ExportSummarySheet implements FromView, ShouldAutoSize, WithEvents, WithTitle
{
    use Exportable;
    protected $category;
    protected $group_by;
    protected $po_received_category;

    function __construct(
        $category,
        $group_by,
        $po_received_category
    ){
        $this->category = $category;
        $this->group_by = $group_by;
        $this->po_received_category = $po_received_category;
    }

    public function view(): View {
        return view('exports.export_report', [
            'group_by' => $this->group_by,
            'po_received_category' => $this->po_received_category
        ]);
    }

    public function title(): string{
        return 'Summary';
    }

    //for designs
    public function registerEvents(): array{
        $category = $this->category;
        $group_by = $this->group_by;
        $po_received_category = $this->po_received_category;

        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $text_center = array(
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrap' => TRUE
            ]
        );

        $text_align_left = array(
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrap' => TRUE
            ]
        );
        $font_8_arial = array(
            'font' => [
                'name'      =>  'Arial',
                'size'      =>  8,
            ]
        );

        $font_8_arial_bold = array(
            'font' => [
                'name'      =>  'Arial',
                'size'      =>  8,
                'bold'      =>  true,
            ]
        );

        $font_9_arial = array(
            'font' => [
                'name'      =>  'Arial',
                'size'      =>  9,
            ]
        );

        $font_9_arial_bold = array(
            'font' => [
                'name'      =>  'Arial',
                'size'      =>  9,
                'bold'      =>  true,
            ]
        );

        $font_14_arial_bold = array(
            'font' => [
                'name'      =>  'Arial',
                'size'      =>  14,
                'bold'      =>  true,
            ]
        );

        $format_cell_custom_type_five = '_("$"* #,##0.00_);_("$"* (#,##0.00);_("$"* "-"??_);_(@_)';

        return[AfterSheet::class => function(AfterSheet $event) use(
            $po_received_category, 
            $category, 
            $group_by, 
            $border, 
            $text_center, 
            $text_align_left, 
            $font_8_arial, 
            $font_8_arial_bold, 
            $font_9_arial, 
            $font_9_arial_bold,
            $font_14_arial_bold,
            $format_cell_custom_type_five
        ){
            //==================== Excel Format =========================
            // $event->sheet->getDelegate()->getStyle('A3:P3')
            // ->getFill()
            // ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            // ->getStartColor()
            // ->setARGB('B7D8FF');
            $excel = \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID;
            $event->sheet
                ->getDelegate()
                ->getStyle('A4')
                ->getFill()
                ->setFillType($excel)
                ->getStartColor()
                ->setARGB('FF99CC');

            $event->sheet
                ->getDelegate()
                ->getStyle('B4:C4')
                ->getFill()
                ->setFillType($excel)
                ->getStartColor()
                ->setARGB('B7D8FF');

            $event->sheet
                ->getDelegate()
                ->getStyle('D4:E4')
                ->getFill()
                ->setFillType($excel)
                ->getStartColor()
                ->setARGB('FFCC99');

            $event->sheet
                ->getDelegate()
                ->getStyle('F3:L3')
                ->getFill()
                ->setFillType($excel)
                ->getStartColor()
                ->setARGB('FFFF66');

            $event->sheet
                ->getDelegate()
                ->getStyle('F4:G4')
                ->getFill()
                ->setFillType($excel)
                ->getStartColor()
                ->setARGB('99FFFF');

            $event->sheet
                ->getDelegate()
                ->getStyle('H4:I4')
                ->getFill()
                ->setFillType($excel)
                ->getStartColor()
                ->setARGB('FFCC99');

            $event->sheet
                ->getDelegate()
                ->getStyle('J4:L4')
                ->getFill()
                ->setFillType($excel)
                ->getStartColor()
                ->setARGB('FFFF66');

            $event->sheet
                ->getDelegate()
                ->getStyle('M4:N4')
                ->getFill()
                ->setFillType($excel)
                ->getStartColor()
                ->setARGB('FF99CC');

            $event->sheet
                ->getDelegate()
                ->getStyle('O4:P4')
                ->getFill()
                ->setFillType($excel)
                ->getStartColor()
                ->setARGB('CCFFCC');

            $event->sheet
                ->getDelegate()
                ->getStyle('A1')
                ->applyFromArray($font_14_arial_bold)
                ->applyFromArray($text_align_left)
                ->getAlignment()
                ->setWrapText(true);

            $event->sheet
                ->getDelegate()
                ->getStyle('A3:P4')
                ->applyFromArray($border)
                ->applyFromArray($text_center)
                ->applyFromArray($font_9_arial_bold)
                ->getAlignment()
                ->setWrapText(true);

            $event->sheet->freezePane('B5');
            $event->sheet->getColumnDimension('A')->setWidth(15);
            $event->sheet->getColumnDimension('B')->setWidth(15);
            $event->sheet->getColumnDimension('C')->setWidth(15);
            $event->sheet->getColumnDimension('D')->setWidth(15);
            $event->sheet->getColumnDimension('E')->setWidth(15);
            $event->sheet->getColumnDimension('F')->setWidth(15);
            $event->sheet->getColumnDimension('G')->setWidth(15);
            $event->sheet->getColumnDimension('H')->setWidth(15);
            $event->sheet->getColumnDimension('I')->setWidth(15);
            $event->sheet->getColumnDimension('J')->setWidth(15);
            $event->sheet->getColumnDimension('K')->setWidth(15);
            $event->sheet->getColumnDimension('L')->setWidth(15);
            $event->sheet->getColumnDimension('M')->setWidth(15);
            $event->sheet->getColumnDimension('N')->setWidth(15);
            $event->sheet->getColumnDimension('O')->setWidth(15);
            $event->sheet->getColumnDimension('P')->setWidth(15);
            
            $event->sheet->getDelegate()->mergeCells('A1:P2');
            $event->sheet->getDelegate()->mergeCells('B3:C3');
            $event->sheet->getDelegate()->mergeCells('D3:E3');
            $event->sheet->getDelegate()->mergeCells('F3:K3');
            $event->sheet->getDelegate()->mergeCells('M3:N3');
            $event->sheet->getDelegate()->mergeCells('O3:P3');
            
            $event->sheet->setCellValue('A1',"PPD P.O BALANCE & SALES PLAN SUMMARY");

            $event->sheet->setCellValue('B3',"  BOH ( PO Balance )");
            $event->sheet->setCellValue('D3',"  FORECAST");
            $event->sheet->setCellValue('F3',"  ACTUAL SALES REPORT");
            $event->sheet->setCellValue('M3',"  BALANCE FOR S/O");
            $event->sheet->setCellValue('O3',"  PO BALANCE");

            $event->sheet->setCellValue('A4',"  PPS");
            $event->sheet->setCellValue('B4',"  Quantity");
            $event->sheet->setCellValue('C4',"  Amount");
            $event->sheet->setCellValue('D4',"  Quantity");
            $event->sheet->setCellValue('E4',"  Amount");
            $event->sheet->setCellValue('F4',"  External\nQuantity");
            $event->sheet->setCellValue('G4',"  External\Sales");
            $event->sheet->setCellValue('H4',"  Internal\nQuantity");
            $event->sheet->setCellValue('I4',"  Internal\Sales");
            $event->sheet->setCellValue('J4',"  Total\nQuantity");
            $event->sheet->setCellValue('K4',"  NET Sales\n(US&)");
            $event->sheet->setCellValue('L4',"  Rate");
            $event->sheet->setCellValue('M4',"  Total\nQuantity");
            $event->sheet->setCellValue('N4',"  Total\nAmount");
            $event->sheet->setCellValue('O4',"  Total\nQuantity");
            $event->sheet->setCellValue('P4',"  Total\nAmount");

            $start_column = 5;
            $columns = ['C', 'E', 'G', 'I', 'K', 'N', 'P'];
            // $po_received_category = [
            //     'Burn-in Memory Sockets', 
            //     'Burn-in Other Sockets', 
            //     'Grinding Multip-Spindle', 
            //     'Grinding Conventional', 
            //     'Flexicon & TC/DC Connectors', 
            //     'Card Connector', 
            //     'FUS/FRS/FMS Connector', 
            //     'CN171 Connector'
            // ];
            
            for ($ii=0; $ii < count($po_received_category); $ii++) { 
                $event->sheet
                    ->getDelegate()
                    ->getStyle('A'.$start_column)
                    ->applyFromArray($border)
                    ->applyFromArray($font_8_arial_bold)
                    ->getAlignment()
                    ->setWrapText(true);

                $event->sheet
                    ->getDelegate()
                    ->getStyle('B'.$start_column.':P'.$start_column)
                    ->applyFromArray($border)
                    ->applyFromArray($font_8_arial)
                    ->getAlignment()
                    ->setWrapText(true);

                $event->sheet->setCellValue('A'.$start_column,$po_received_category[$ii]->category);
                
                for ($i=0; $i < count($group_by); $i++){
                    $event->sheet
                        ->getDelegate()
                        ->getStyle('J'.$start_column.':L'.$start_column)
                        ->getFill()
                        ->setFillType($excel)
                        ->getStartColor()
                        ->setARGB('FFFF66');
            
                    $event->sheet
                        ->getDelegate()
                        ->getStyle('M'.$start_column.':N'.$start_column)
                        ->getFill()
                        ->setFillType($excel)
                        ->getStartColor()
                        ->setARGB('FF99CC');

                    if($po_received_category[$ii]->category == $group_by[$i]['category_name']){
                        $event->sheet
                            ->getDelegate()
                            ->getStyle('B'.$start_column)
                            ->applyFromArray($text_align_left);
                            
                        $event->sheet
                            ->getDelegate()
                            ->getStyle('B'.$start_column.':P'.$start_column)
                            ->applyFromArray($text_center);
    
                        $sales_report_quantity  =   $group_by[$i]['sum_ShipoutQty'];
                        $sales_report_sales     =   $group_by[$i]['sum_Price']*$group_by[$i]['sum_ShipoutQty'];

                        if($category == 'Internal'){
                            $internal_quantity  =   $sales_report_quantity;
                            $internal_sales     =   $sales_report_sales;

                            $external_quantity = '0';
                            $external_sales = '0.00';
                        }else{
                            $internal_quantity = '0';
                            $internal_sales = '0.00';

                            $external_quantity  =   $sales_report_quantity;
                            $external_sales     =   $sales_report_sales;
                        }

                        $event->sheet->getDelegate()->getStyle('A'.$start_column.':P'.$start_column)->getNumberFormat()->setFormatCode('#,##0');
                        $event->sheet->getDelegate()->getStyle('L'.$start_column)->getNumberFormat()->setFormatCode('0.00%');

                        foreach ($columns as $column) {
                            $event->sheet
                                ->getDelegate()
                                ->getStyle($column . $start_column)
                                ->getNumberFormat()
                                ->setFormatCode($format_cell_custom_type_five);
                        }
                        
                        $event->sheet->setCellValue('B'.$start_column,$group_by[$i]['sum_OrderQty']);
                        $event->sheet->setCellValue('C'.$start_column,$group_by[$i]['sum_OrderQty']*$group_by[$i]['sum_Price']);
                        $event->sheet->setCellValue('D'.$start_column,'');
                        $event->sheet->setCellValue('E'.$start_column,'');
                        $event->sheet->setCellValue('F'.$start_column,$external_quantity);
                        $event->sheet->setCellValue('G'.$start_column,$external_sales);
                        $event->sheet->setCellValue('H'.$start_column,$internal_quantity);
                        $event->sheet->setCellValue('I'.$start_column,$internal_sales);
                        $event->sheet->setCellValue('J'.$start_column,"=F$start_column+H$start_column");
                        $event->sheet->setCellValue('K'.$start_column,"=I$start_column+G$start_column");
                        $event->sheet->setCellValue('L'.$start_column,"=K$start_column/E$start_column");
                        $event->sheet->setCellValue('M'.$start_column,"=D$start_column-J$start_column");
                        $event->sheet->setCellValue('N'.$start_column,"=E$start_column-K$start_column");
                        $event->sheet->setCellValue('O'.$start_column,"=B$start_column-J$start_column");
                        $event->sheet->setCellValue('P'.$start_column,"=C$start_column-K$start_column");
                    }
                }
                $start_column++;
            }

            // ==========================================================================================================================
            // ====================================================== OVER ALL SUM ======================================================
            // ==========================================================================================================================
            $last_row = $start_column;
            $columns_to_sum = range('B', 'P');

            $event->sheet
                ->getDelegate()
                ->getStyle('A'.$last_row.':P'.$last_row)
                ->getFill()
                ->setFillType($excel)
                ->getStartColor()
                ->setARGB('C0C0C0');

            foreach ($columns_to_sum as $column_total_sum) {
                $event->sheet->setCellValue($column_total_sum . $last_row, "=SUM($column_total_sum" . '5' . ":" . $column_total_sum . ($last_row - 1) . ")");
            }

            $event->sheet->getDelegate()->getStyle('B' . $last_row . ':P' . $last_row)->getNumberFormat()->setFormatCode('#,##0');
            $event->sheet->getDelegate()->getStyle('L'.$last_row)->getNumberFormat()->setFormatCode('0.00%');

            foreach ($columns as $column_total_dollar_format) {
                $event->sheet
                    ->getDelegate()
                    ->getStyle($column_total_dollar_format . $last_row)
                    ->getNumberFormat()
                    ->setFormatCode($format_cell_custom_type_five);
            }

            $event->sheet
                ->getDelegate()
                ->getStyle('B'.$last_row.':P'.$last_row)
                ->applyFromArray($text_center);

            $event->sheet
                ->getDelegate()
                ->getStyle('A' . $last_row . ':P' . $last_row)
                ->applyFromArray($border)
                ->applyFromArray($font_9_arial_bold)
                ->getAlignment()
                ->setWrapText(true);

            $event->sheet->setCellValue('A' . $last_row, 'TOTAL:');
        }];
    }
}