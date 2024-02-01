<?php
/**
 * Контроллер для загрузки отчёта по экспертизам
 *
 * @author Andrey
 */
class ReportsCtrl extends ControllerMain{
    protected $Report;
    public function actionContP1Rep(){//отчёт по новым договорам
        $this->Report=(new ReportsMod())->getContP1();        
        $this->render('reports/ContP1Rep',['Report'=> $this->Report]);
    }
    
    public function actionContExpRep(){//отчёт по новым экспертизам
        $this->Report=(new ReportsMod())->getContExp();     
        $this->RepToExcel($this->Report, 'NewExpRep');
        $this->render('reports/ContExpRep',['Report'=> $this->Report]);
    }
    
    protected function RepToExcel($Arr,$File){
        $xls = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle('Экспертизы');
        $sheet->setCellValue("A1", "Экспертизы");
        $sheet->setCellValue("A2", "ClCode");
        $sheet->setCellValue("B2", "ContCode");
        $sheet->setCellValue("C2", "ФИО");
        $sheet->setCellValue("D2", "Подразделение");
        $sheet->setCellValue("E2", "Менеджер");
        $sheet->setCellValue("F2", "Дата дог.");
        $sheet->setCellValue("G2", "Дата перв. платежа");
        $sheet->setCellValue("H2", "Стоимость ЭПЭ");
        $sheet->setCellValue("I2", "Всего внесено за ЭПЭ");
     
        $i=3;
        foreach ($Arr as $reprow){
            $j=1;
            foreach ($reprow as $repfield){
                $sheet->setCellValueByColumnAndRow($j,$i,$repfield);
                $j++;
            }            
            $i++;
        }
        //create file name  
        $FileName="{$_SERVER['DOCUMENT_ROOT']}/".WORK_FOLDER."/downloads/{$File}.xlsx";
        //вывод в файл и сохранение
        $objWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($xls);
        $objWriter->save($FileName);
    }
}
