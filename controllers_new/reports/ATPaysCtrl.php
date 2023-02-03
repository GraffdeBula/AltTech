<?php
/**
 * Контроллер для загрузки отчёта по экспертизам
 *
 * @author Andrey
 */
class ATPaysCtrl extends ControllerMain{
    protected $ContList=[];
    protected $Branch='';
    
    public function actionIndex(){
        $this->render('reports/ATCurRep',['Report'=>[]]);
    }
    
    public function actionShowDate(){
        $NewDate= mktime(0,0,0,date('m'),date('d'),date('y'));
        
        $date = strtotime('last year');

        echo date_format(date_create("2021-09-15"),"d.m.Y");
//        $MyMonth=$NewDate('m');
//        $MyYear=$NewDate('Y');
//        echo($MyMonth."<br>");
//        echo($MyYear."<br>");
//        $this->LastDayMonth($MyMonth,$MyYear);
    }
    
    protected function LastDayMonth($Month,$Year){
        $SpecYear=[2020,2024,2028,2032,2036,2040,2044,2048,2052];
        $LastDay31=[1,3,5,7,8,10,12];
        $LastDay30=[4,6,9,11];
                
        $LastDay=31;
        if (in_array($Month, $LastDay30)){
            echo ('30');
        }
        if (in_array($Month, $LastDay31)){
            echo ('31');
        }
        
        #return $LastDay;
    }
    
    public function actionTestRep(){
        $Model=new ATP1OldMod();
        $this->ContList=$Model->getP1ContTomskList();
        
        #$this->exportToExcel();
        #header("Location: downloads/Rep {$this->Branch}.xlsx");
        $this->render('reports/ATCurRep',['Report'=>$this->ContList]);
    }
    
    public function actionFormRep(){
        $this->Branch=$_GET['branch'];
        
        $Model=new RepCurPaysMod();
        $this->ContList=$Model->getP1AnketaList($this->Branch);
                
        $this->exportToExcel();
        header("Location: downloads/Rep {$this->Branch}.xlsx");
    }
    
    
    
    public function exportToExcel() {
        
        #вывод в эксель
        // Создаем объект класса PHPExcel
        $xls = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        // Устанавливаем индекс активного листа
        $xls->setActiveSheetIndex(0);
        // Получаем активный лист
        $sheet = $xls->getActiveSheet();
        // Подписываем лист
        $sheet->setTitle('Отчёт по действующим клиентам');
        // Вставляем заголовки таблицы
        $sheet->setCellValue("A2", "CLCODE");
        $sheet->setCellValue("B2", "CONTCODE");
        $sheet->setCellValue("C2", "Фамилия");
        $sheet->setCellValue("D2", "Имя");
        $sheet->setCellValue("E2", "Отчество");
        $sheet->setCellValue("F2", "Дата договора");
        $sheet->setCellValue("G2", "Филиал");
        $sheet->setCellValue("H2", "Программа");
        $sheet->setCellValue("I2", "Тариф");
        $sheet->setCellValue("J2", "Сумма");
        $i=3;
        
        foreach ($this->ContList as $ListRow){
            $sheet->setCellValueByColumnAndRow(1,$i,$ListRow->CLCODE);
            $sheet->setCellValueByColumnAndRow(2,$i,$ListRow->CONTCODE);
            $sheet->setCellValueByColumnAndRow(1,$i,$ListRow->CLFNAME);
            $sheet->setCellValueByColumnAndRow(2,$i,$ListRow->CL1NAME);
            $sheet->setCellValueByColumnAndRow(3,$i,$ListRow->CL2NAME);
            $sheet->setCellValueByColumnAndRow(4,$i,$ListRow->CONTDAT);
            $sheet->setCellValueByColumnAndRow(5,$i,$ListRow->CONTOFFICE);
            $sheet->setCellValueByColumnAndRow(6,$i,$ListRow->CONTPROG);
            $sheet->setCellValueByColumnAndRow(6,$i,$ListRow->CONTTARIF);
            $sheet->setCellValueByColumnAndRow(6,$i,$ListRow->CONTSUM1);
            
            $i++;
        }
        //create file name  
        $FileName="{$_SERVER['DOCUMENT_ROOT']}/AltTech/downloads/Rep {$this->Branch}.xlsx";
        //вывод в файл и сохранение
        $ObjWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($xls);
        $ObjWriter->save($FileName);                
    }
    
    
    
    
        
}
