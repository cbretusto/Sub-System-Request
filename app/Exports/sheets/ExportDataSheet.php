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



class ExportDataSheet implements FromView, ShouldAutoSize, WithEvents, WithTitle
{
    use Exportable;
    protected $search_data_reports;
    protected $category;

    function __construct(
        $search_data_reports,
        $category
    ){
        $this->search_data_reports = $search_data_reports;
        $this->category = $category;
    }

    public function view(): View {
        return view('exports.export_report', [
            'search_data_reports' => $this->search_data_reports
        ]);
    }

    public function title(): string{
        return 'Sub-System Request Report';
    }

    //for designs
    public function registerEvents(): array{
        $search_data_reports = $this->search_data_reports;
        $category = $this->category;

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

        $font_10_arial_bold = array(
            'font' => [
                'name'      =>  'Arial',
                'size'      =>  10,
                'bold'      =>  true,
            ]
        );

        $format_cell_custom_type_one = '_("$"* #,##0.00000_);_("$"* (#,##0.00000);_("$"* "-"??.000_);_(@_)';
        $format_cell_custom_type_two = '_(* #,##0.0000_);_(* (#,##0.0000);_(* "-"??_);_(@_)';
        $format_cell_custom_type_three = '_(* #,##0.0_);_(* (#,##0.0);_(* "-"??_);_(@_)';
        $format_cell_custom_type_four = '_(* #,##0.00_);_(* (#,##0.00);_(* "-"??.00_);_(@_)';
        $format_cell_custom_type_five = '_("$"* #,##0.00_);_("$"* (#,##0.00);_("$"* "-"??_);_(@_)';
        $format_cell_custom_type_six = '_(* #,##0_);_(* (#,##0);_(* "-"_);_(@_)';

        return[AfterSheet::class => function(AfterSheet $event) use(
            $search_data_reports, 
            $category, 
            $border, 
            $text_center, 
            $text_align_left, 
            $font_8_arial, 
            $font_8_arial_bold, 
            $font_9_arial, 
            $font_9_arial_bold, 
            $font_10_arial_bold,
            $format_cell_custom_type_one,
            $format_cell_custom_type_two,
            $format_cell_custom_type_three,
            $format_cell_custom_type_four,
            $format_cell_custom_type_five,
            $format_cell_custom_type_six
        ){
            //==================== Excel Format =========================
            $event->sheet
                ->getDelegate()
                ->getStyle('A3:AQ3')
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('B7D8FF');

            $event->sheet->freezePane('J4');
            $event->sheet->getDelegate()->getStyle('A3:AQ3')->applyFromArray($border);
            $event->sheet->getColumnDimension('A')->setWidth(10);
            $event->sheet->getColumnDimension('B')->setWidth(10);
            $event->sheet->getColumnDimension('C')->setWidth(35);
            $event->sheet->getColumnDimension('D')->setWidth(10);
            $event->sheet->getColumnDimension('E')->setWidth(15);
            $event->sheet->getColumnDimension('F')->setWidth(15);
            $event->sheet->getColumnDimension('G')->setWidth(5);
            $event->sheet->getColumnDimension('H')->setWidth(10);
            $event->sheet->getColumnDimension('I')->setWidth(35);
            $event->sheet->getColumnDimension('J')->setWidth(10);
            $event->sheet->getColumnDimension('K')->setWidth(35);
            $event->sheet->getColumnDimension('L')->setWidth(10);
            $event->sheet->getColumnDimension('M')->setWidth(10);
            $event->sheet->getColumnDimension('N')->setWidth(10);
            $event->sheet->getColumnDimension('O')->setWidth(10);
            $event->sheet->getColumnDimension('P')->setWidth(10);
            $event->sheet->getColumnDimension('Q')->setWidth(10);
            $event->sheet->getColumnDimension('R')->setWidth(10);
            $event->sheet->getColumnDimension('S')->setWidth(10);
            $event->sheet->getColumnDimension('T')->setWidth(10);
            $event->sheet->getColumnDimension('U')->setWidth(10);
            $event->sheet->getColumnDimension('V')->setWidth(10);
            $event->sheet->getColumnDimension('W')->setWidth(10);
            $event->sheet->getColumnDimension('X')->setWidth(10);
            $event->sheet->getColumnDimension('Y')->setWidth(10);
            $event->sheet->getColumnDimension('Z')->setWidth(10);
            $event->sheet->getColumnDimension('AA')->setWidth(10);
            $event->sheet->getColumnDimension('AB')->setWidth(10);
            $event->sheet->getColumnDimension('AC')->setWidth(10);
            $event->sheet->getColumnDimension('AD')->setWidth(10);
            $event->sheet->getColumnDimension('AE')->setWidth(10);
            $event->sheet->getColumnDimension('AF')->setWidth(10);
            $event->sheet->getColumnDimension('AG')->setWidth(10);
            $event->sheet->getColumnDimension('AH')->setWidth(10);
            $event->sheet->getColumnDimension('AI')->setWidth(10);
            $event->sheet->getColumnDimension('AJ')->setWidth(10);
            $event->sheet->getColumnDimension('AK')->setWidth(10);
            $event->sheet->getColumnDimension('AL')->setWidth(10);
            $event->sheet->getColumnDimension('AM')->setWidth(35);
            $event->sheet->getColumnDimension('AN')->setWidth(10);
            $event->sheet->getColumnDimension('AO')->setWidth(10);
            $event->sheet->getColumnDimension('AP')->setWidth(10);
            $event->sheet->getColumnDimension('AQ')->setWidth(10);

            $event->sheet
                ->getDelegate()
                ->mergeCells('A1:I2');

            $event->sheet
                ->getDelegate()
                ->getStyle('A1')
                ->applyFromArray($text_center)
                ->applyFromArray($font_10_arial_bold)
                ->getAlignment()
                ->setWrapText(true);

            $event->sheet
                ->getDelegate()
                ->getStyle('A3:AQ3')
                ->applyFromArray($text_center)
                ->applyFromArray($font_9_arial_bold)
                ->getAlignment()
                ->setWrapText(true);
            
            $event->sheet->setCellValue('A1',"NOTE: METAL PARTS AND UD ARE NOT INCLUDED");
            
            $event->sheet->setCellValue('A3',"  Category");
            $event->sheet->setCellValue('B3',"  VA");
            $event->sheet->setCellValue('C3',"  Category");
            $event->sheet->setCellValue('D3',"  PO \n Date");
            $event->sheet->setCellValue('E3',"  Drawing");
            $event->sheet->setCellValue('F3',"  PR");
            $event->sheet->setCellValue('G3',"  Loc");
            $event->sheet->setCellValue('H3',"  Code");
            $event->sheet->setCellValue('I3',"  Item Name");
            $event->sheet->setCellValue('J3',"  Code");
            $event->sheet->setCellValue('K3',"  Resin Type");
            $event->sheet->setCellValue('L3',"  Unit \n Weight");
            $event->sheet->setCellValue('M3',"  Sprue \n Weight");
            $event->sheet->setCellValue('N3',"  G/Shot");
            $event->sheet->setCellValue('O3',"  Std Cav");
            $event->sheet->setCellValue('P3',"  No of \n Cavity");
            $event->sheet->setCellValue('Q3',"  Cycle \n Time");
            $event->sheet->setCellValue('R3',"  Needed \n Kgs");
            $event->sheet->setCellValue('S3',"  Allowance");
            $event->sheet->setCellValue('T3',"  Total Need \n (kgs)");
            $event->sheet->setCellValue('U3',"  Material \n Cost");
            $event->sheet->setCellValue('V3',"  CT($)");
            $event->sheet->setCellValue('W3',"  ME($)");
            $event->sheet->setCellValue('X3',"  Shut off");
            $event->sheet->setCellValue('Y3',"  RMU @ \n Standard");
            $event->sheet->setCellValue('Z3',"  RMU @ \n Actual");
            $event->sheet->setCellValue('AA3'," Unit \n Price");
            $event->sheet->setCellValue('AB3'," P.O \n Qty");
            $event->sheet->setCellValue('AC3'," Amount");
            $event->sheet->setCellValue('AD3'," Qty");
            $event->sheet->setCellValue('AE3'," Amount \n (Round Off)");
            $event->sheet->setCellValue('AF3'," Internal Inv \n (Amt)");
            $event->sheet->setCellValue('AG3'," External Inv \n (Amt)");
            $event->sheet->setCellValue('AH3'," RMU @ \n Standard");
            $event->sheet->setCellValue('AI3'," RMU @ \n Actual Activity");
            $event->sheet->setCellValue('AJ3'," Rate");
            $event->sheet->setCellValue('AK3'," Balance \n Qty");
            $event->sheet->setCellValue('AL3'," Amount");
            $event->sheet->setCellValue('AM3'," Classification");
            $event->sheet->setCellValue('AN3'," RMU");
            $event->sheet->setCellValue('AO3'," Rate");
            $event->sheet->setCellValue('AP3'," RMU @ \n Standard");
            $event->sheet->setCellValue('AQ3'," RMU @ \n Actual");
            
            $start_column = 4;
            for ($i=0; $i < count($search_data_reports); $i++){
                $data = $search_data_reports[$i];

                $event->sheet
                    ->getDelegate()
                    ->getStyle('A'.$start_column.':AQ'.$start_column)
                    ->applyFromArray($border)
                    ->applyFromArray($text_align_left)
                    ->applyFromArray($font_8_arial)
                    ->getAlignment()
                    ->setWrapText(true);
                
                $event->sheet
                    ->getDelegate()
                    ->getStyle('F'.$start_column)
                    ->getNumberFormat()
                    ->setFormatCode('0');

                $event->sheet
                    ->getDelegate()
                    ->getStyle('Y'.$start_column.':Z'.$start_column)
                    ->getNumberFormat()
                    ->setFormatCode('"$"#,##0.0000');

                $event->sheet
                    ->getDelegate()
                    ->getStyle('AB'.$start_column.':AD'.$start_column)
                    ->getNumberFormat()
                    ->setFormatCode('#,##0');

                $event->sheet
                    ->getDelegate()
                    ->getStyle('AJ'.$start_column)
                    ->getNumberFormat()
                    ->setFormatCode('0.00%');

                $event->sheet
                    ->getDelegate()
                    ->getStyle('AK'.$start_column.':AL'.$start_column)
                    ->getNumberFormat()
                    ->setFormatCode('#,##0');

                $event->sheet
                    ->getDelegate()
                    ->getStyle('AO'.$start_column.':AQ'.$start_column)
                    ->getNumberFormat()
                    ->setFormatCode('0.00%');

                $event->sheet->setCellValue('A'.$start_column, $data->Category );
                $event->sheet->setCellValue('B'.$start_column, $category );
                $event->sheet->setCellValue('C'.$start_column, $data->Category.'('.$category.')' );
                $event->sheet->setCellValue('D'.$start_column, $data->DateIssued );
                $event->sheet->setCellValue('E'.$start_column, $data->DrawingNo );
                $event->sheet->setCellValue('F'.$start_column, $data->OrderNo );
                $event->sheet->setCellValue('G'.$start_column, $data->location );
                $event->sheet->setCellValue('H'.$start_column, $data->ItemCode );
                $event->sheet->setCellValue('I'.$start_column, $data->ItemName );
                $event->sheet->setCellValue('J'.$start_column, $data->PartNumber );
                $event->sheet->setCellValue('K'.$start_column, $data->MaterialType );
                $event->sheet->setCellValue('L'.$start_column, $data->UnitWgt );
                $event->sheet->setCellValue('M'.$start_column, $data->SprueWgt );
                $event->sheet->setCellValue('N'.$start_column, $data->ShotWgt );
                $event->sheet->setCellValue('O'.$start_column, $data->NoOfCav.'.0000' );
                $event->sheet->setCellValue('P'.$start_column, $data->NoOfCav );
                $event->sheet->setCellValue('Q'.$start_column, $data->CycleShot );
                $event->sheet->setCellValue('R'.$start_column, "=AK$start_column*N$start_column/1000/P$start_column" );
                $event->sheet->setCellValue('S'.$start_column, "=0.8*((180+(34*N$start_column))/1000)" );
                $event->sheet->setCellValue('T'.$start_column, "=S$start_column+R$start_column" );
                $event->sheet->setCellValue('U'.$start_column, $data->material_cost );
                $event->sheet->setCellValue('V'.$start_column, '0' );
                $event->sheet->setCellValue('W'.$start_column, '0' );
                $event->sheet->setCellValue('X'.$start_column, "=P$start_column-O$start_column" );
                $event->sheet->setCellValue('Y'.$start_column, "=((N$start_column/O$start_column)/1000*U$start_column)+V$start_column+W$start_column" );
                $event->sheet->setCellValue('Z'.$start_column, "=((N$start_column/P$start_column)/1000*U$start_column)+V$start_column+W$start_column" );
                $event->sheet->setCellValue('AA'.$start_column, $data->Price );
                $event->sheet->setCellValue('AB'.$start_column, $data->OrderQty );
                $event->sheet->setCellValue('AC'.$start_column, "=ROUND(AB$start_column*AA$start_column,2)" );
                $event->sheet->setCellValue('AD'.$start_column,  $data->sum_ShipoutQty);
                $event->sheet->setCellValue('AE'.$start_column, "=ROUND(AA$start_column*AD$start_column,2)" );
                $event->sheet->setCellValue('AF'.$start_column, $data->Computed );
                $event->sheet->setCellValue('AG'.$start_column, '0' );
                $event->sheet->setCellValue('AH'.$start_column, "=AD$start_column*Y$start_column" );
                $event->sheet->setCellValue('AI'.$start_column, "=AD$start_column*Z$start_column" );
                $event->sheet->setCellValue('AJ'.$start_column, "=AI$start_column/AE$start_column" );
                $event->sheet->setCellValue('AK'.$start_column, $data->POBalance );
                $event->sheet->setCellValue('AL'.$start_column, "=ROUND(AK$start_column*AA$start_column,2)" );
                $event->sheet->setCellValue('AM'.$start_column, "=A$start_column" );
                $event->sheet->setCellValue('AN'.$start_column, "=AK$start_column*Z$start_column" );
                $event->sheet->setCellValue('AO'.$start_column, "=AN$start_column/AL$start_column" );
                $event->sheet->setCellValue('AP'.$start_column, "=Y$start_column/AA$start_column" );
                $event->sheet->setCellValue('AQ'.$start_column, "=Z$start_column/AA$start_column" );

                $event->sheet
                    ->getDelegate()
                    ->getStyle('O'.$start_column)
                    ->getNumberFormat()
                    ->setFormatCode($format_cell_custom_type_two);
                
                $event->sheet
                    ->getDelegate()
                    ->getStyle('R'.$start_column)
                    ->getNumberFormat()
                    ->setFormatCode($format_cell_custom_type_four);

                $event->sheet
                    ->getDelegate()
                    ->getStyle('S'.$start_column)
                    ->getNumberFormat()
                    ->setFormatCode($format_cell_custom_type_three);

                $event->sheet
                    ->getDelegate()
                    ->getStyle('T'.$start_column)
                    ->getNumberFormat()
                    ->setFormatCode($format_cell_custom_type_four);

                $event->sheet
                    ->getDelegate()
                    ->getStyle('V'.$start_column.':W'.$start_column)
                    ->getNumberFormat()
                    ->setFormatCode($format_cell_custom_type_one);

                $event->sheet
                    ->getDelegate()
                    ->getStyle('AC'.$start_column)
                    ->getNumberFormat()
                    ->setFormatCode($format_cell_custom_type_five);

                $event->sheet
                    ->getDelegate()
                    ->getStyle('AE'.$start_column.':AF'.$start_column)
                    ->getNumberFormat()
                    ->setFormatCode($format_cell_custom_type_five);

                $event->sheet
                    ->getDelegate()
                    ->getStyle('AH'.$start_column.':AI'.$start_column)
                    ->getNumberFormat()
                    ->setFormatCode($format_cell_custom_type_five);

                $event->sheet
                    ->getDelegate()
                    ->getStyle('AN'.$start_column)
                    ->getNumberFormat()
                    ->setFormatCode($format_cell_custom_type_six);

                $start_column++;
            }
        }];
    }
}
