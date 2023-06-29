<?php
/**
 * Контроллер для загрузки отчёта по экспертизам
 *
 * @author Andrey
 */
class P4ReportCtrl extends ControllerMain{
    
    protected $ReportExp;
    
    public function actionIndex() {        
        $this->render('reports/ATP4Rep',['Report'=>[]]);
    }
    
    public function actionShowRep() {
        
        if (isset($_GET['DateF']) && isset($_GET['DateL'])){
            $this->ReportExp=(new ATP4ContMod())->getP4RepNew($_GET['DateF'],$_GET['DateL']);
        } else {
            $this->ReportExp=(new ATP4ContMod())->getP4RepNew(date("d.m.Y"),date("d.m.Y"));
        }
        
        $this->ExportToExcel();
        
        $this->render('reports/ATP4Rep',['Report'=>$this->ReportExp]);
    }
    
    protected function ExportToExcel(){
        //вывод отчёта в EXCEL
        // Создаем объект класса PHPExcel
        $xls = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        // Устанавливаем индекс активного листа
        $xls->setActiveSheetIndex(0);
        // Получаем активный лист
        $sheet = $xls->getActiveSheet();
        // Подписываем лист
        $sheet->setTitle('Отчёт по разовым услугам');
        // Вставляем заголовки таблицы
        $sheet->setCellValue("A1", "РАЗОВЫЕ УСЛУГИ");
        $sheet->setCellValue("A2", "CLCODE");
        $sheet->setCellValue("B2", "ID");
        $sheet->setCellValue("C2", "ФИО");
        $sheet->setCellValue("D2", "ФИЛИАЛ");
        $sheet->setCellValue("E2", "МЕНЕДЖЕР");
        $sheet->setCellValue("F2", "СУММА");
        $sheet->setCellValue("G2", "ДАТА");
        $sheet->setCellValue("H2", "ИСПОЛНИТЕЛЬ");
        $sheet->setCellValue("I2", "ОТРАСЛЬ");
        $sheet->setCellValue("J2", "УСЛУГА");
        $sheet->setCellValue("K2", "РЕЗУЛЬТАТ");
        $i=3;
        
        foreach ($this->ReportExp as $reprow){
            $sheet->setCellValueByColumnAndRow(1,$i,$reprow->CLCODE);
            $sheet->setCellValueByColumnAndRow(2,$i,$reprow->CONTCODE);
            $sheet->setCellValueByColumnAndRow(3,$i,$reprow->CLNAME);
            $sheet->setCellValueByColumnAndRow(4,$i,$reprow->FROFFICE);
            $sheet->setCellValueByColumnAndRow(5,$i,$reprow->FRPERSMANAGER);
            $sheet->setCellValueByColumnAndRow(6,$i,$reprow->FRCONTSUM);
            $sheet->setCellValueByColumnAndRow(7,$i,$reprow->FRCONTDATE);
            $sheet->setCellValueByColumnAndRow(8,$i,$reprow->FRJURIST);
            $sheet->setCellValueByColumnAndRow(9,$i,$reprow->FRJURBRANCH);
            $sheet->setCellValueByColumnAndRow(10,$i,$reprow->FRCONTSERVICE);
            $sheet->setCellValueByColumnAndRow(11,$i,$reprow->FRCONTRESULT);
            $i++;
        }
        //create file name  
        $fileName="{$_SERVER['DOCUMENT_ROOT']}/AltTech/downloads/P4Report.xlsx";
        //вывод в файл и сохранение
        $objWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($xls);
        $objWriter->save($fileName);
    }
}
