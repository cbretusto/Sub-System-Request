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

class ExportDataForMaterialCostSheet implements FromView, ShouldAutoSize, WithEvents, WithTitle
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

    public function view(): View {
        return view('exports.export_report', ['category' => $this->category, 'subsystem_history' => $this->subsystem_history]);
    }

    public function title(): string{
        return 'Material Cost';
    }

    //for designs
    public function registerEvents(): array{
        $category = $this->category;
        $subsystem_history = $this->subsystem_history;

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

        $font_9_arial = array(
            'font' => [
                'name'      =>  'Arial',
                'size'      =>  9,
            ]
        );

        $font_10_arial_bold = array(
            'font' => [
                'name'      =>  'Arial',
                'size'      =>  10,
                'bold'      =>  true,
            ]
        );

        return[AfterSheet::class => function(AfterSheet $event) use(
            $category,
            $subsystem_history,
            $border,
            $text_center,
            $font_9_arial, 
            $font_10_arial_bold
        ){
            //==================== Excel Format =========================
            $event->sheet->getDelegate()->getStyle('A1:E1')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('B7D8FF');

            $event->sheet->freezePane('A2');
            $event->sheet
                ->getDelegate()
                ->getStyle('A1:E1')
                ->applyFromArray($border)
                ->applyFromArray($text_center)
                ->applyFromArray($font_10_arial_bold)
                ->getAlignment()
                ->setWrapText(true);

            $event->sheet->getColumnDimension('A')->setWidth(35);
            $event->sheet->getColumnDimension('B')->setWidth(35);
            $event->sheet->getColumnDimension('C')->setWidth(35);
            $event->sheet->getColumnDimension('D')->setWidth(35);
            $event->sheet->getColumnDimension('E')->setWidth(35);
                        
            $event->sheet->setCellValue('A1',"  Order No.");
            $event->sheet->setCellValue('B1',"  Item Code");
            $event->sheet->setCellValue('C1',"  Item Name");
            $event->sheet->setCellValue('D1',"  Material Cost");
            $event->sheet->setCellValue('E1',"  Location");

            
            $start_column = 2;
            if($category == 1){
                for ($i=0; $i < count($subsystem_history); $i++){
                    $event->sheet
                    ->getDelegate()
                    ->getStyle('A'.$start_column.':E'.$start_column)
                    ->applyFromArray($border)
                    ->applyFromArray($text_center)
                    ->applyFromArray($font_9_arial)
                    ->getAlignment()
                    ->setWrapText(true);
                    
                    $event->sheet->getDelegate()->getStyle('A'.$start_column.':C'.$start_column)->getNumberFormat()->setFormatCode('0');
                    $event->sheet->getDelegate()->getStyle('D'.$start_column)->getNumberFormat()->setFormatCode('0.00');
                    $event->sheet->setCellValue('A'.$start_column,$subsystem_history[$i]->order_no);
                    $event->sheet->setCellValue('B'.$start_column,$subsystem_history[$i]->item_code);
                    $event->sheet->setCellValue('C'.$start_column,$subsystem_history[$i]->item_name);
                    $event->sheet->setCellValue('D'.$start_column,$subsystem_history[$i]->material_cost);
                    $event->sheet->setCellValue('E'.$start_column,$subsystem_history[$i]->location);
                    
                    $start_column++;
                }
            }else{
                for($i=0; $i < 19; $i++){
                    $event->sheet
                    ->getDelegate()
                        ->getStyle('A'.$start_column.':E'.$start_column)
                        ->applyFromArray($border)
                        ->applyFromArray($text_center)
                        ->applyFromArray($font_9_arial)
                        ->getAlignment()
                        ->setWrapText(true);

                    $start_column++;
                }
            }

        }];
    }
}
