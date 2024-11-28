<?php
/**
 * Контроллер для загрузки отчёта по экспертизам
 *
 * @author Andrey
 */
class CurBasePlanCtrl extends ControllerMain{
    protected $PayList=[];
    protected $BranchList=[];
    protected $DocName;
    
    public function __construct(){
        $this->BranchList=(new Branch())->getBranchList();
    }
    
    public function actionIndex(){
        
        $this->ViewName='Отчёт по плановым платежам';
        $this->render('reports/ATCurBasePlan',['BranchList'=>$this->BranchList]);
    }
    
    public function actionShowBrBase(){        
        $this->ViewName='Плановые платежи - '.$_GET['BrName'];
        $Model=new ReportsMod();
        $this->PayList=array_merge($Model->getPaysByBranch($_GET['BrName'],$_GET['DateF'],$_GET['DateL']),$Model->getPaysByBranchCred($_GET['BrName'],$_GET['DateF'],$_GET['DateL']));
        $this->exportToExcel();
        $this->render('reports/ATCurPlanBranch',['PayList'=>$this->PayList,'DocName'=>$this->DocName]);
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
        $sheet->setTitle($_GET['BrName']);
        // Вставляем заголовки таблицы
        $sheet->setCellValue("A2", "CLCODE");
        $sheet->setCellValue("B2", "CONTCODE");
        $sheet->setCellValue("C2", "ФИО");
        $sheet->setCellValue("D2", "Дата договора");
        $sheet->setCellValue("E2", "Программа");
        $sheet->setCellValue("F2", "Тариф");
        $sheet->setCellValue("G2", "Сумма договора");
        $sheet->setCellValue("H2", "Внесено");
        $sheet->setCellValue("I2", "Дата последнего платежа");
        $sheet->setCellValue("J2", "Плановая сумма платежа");
        $sheet->setCellValue("K2", "Плановая дата платежа");
        $i=3;
        
        foreach ($this->PayList as $ListRow){
            $sheet->setCellValueByColumnAndRow(1,$i,$ListRow->CLCODE);
            $sheet->setCellValueByColumnAndRow(2,$i,$ListRow->CONTCODE);
            $sheet->setCellValueByColumnAndRow(3,$i,$ListRow->CLFIO);
            $sheet->setCellValueByColumnAndRow(4,$i,$ListRow->FRCONTDATE);
            $sheet->setCellValueByColumnAndRow(5,$i,$ListRow->FRCONTPROG);
            $sheet->setCellValueByColumnAndRow(6,$i,$ListRow->FRCONTTARIF);
            $sheet->setCellValueByColumnAndRow(7,$i,$ListRow->FRCONTSUM);
            $sheet->setCellValueByColumnAndRow(8,$i,$ListRow->PAYTOTSUM);
            $sheet->setCellValueByColumnAndRow(9,$i,$ListRow->PAYLASTDATE);
            $sheet->setCellValueByColumnAndRow(10,$i,$ListRow->PAYSUM);
            $sheet->setCellValueByColumnAndRow(11,$i,$ListRow->PAYDATE);
            
            $i++;
        }
        //create file name  
        $this->DocName="CurPlan{$_GET['BrName']}";
        $FileName="{$_SERVER['DOCUMENT_ROOT']}/AltTech/downloads/{$this->DocName}.xlsx";
        //вывод в файл и сохранение
        $ObjWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($xls);
        $ObjWriter->save($FileName);                
    }
    
    
    
    
        
}
