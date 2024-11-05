<?php
/**
 * Контроллер для загрузки отчёта по экспертизам
 *
 * @author Andrey
 */
class ReportsCtrl extends ControllerMain{
        
    protected $Report;
    
    public function actionShowContP1RepForm(){//отчёт по новым договорам
        $this->render('reports/ContP1Rep',['Report'=>[]]);    
    }
    
    public function actionContP1Rep(){//отчёт по новым договорам
        $DateF=date('d.m.Y');
        if ($_GET['DateF']!=''){
            $DateF=$_GET['DateF'];
        }
        $DateL=date('d.m.Y');
        if ($_GET['DateL']!=''){
            $DateL=$_GET['DateL'];
        }
        $Branch=$_GET['BranchName'];
        
        if ($Branch!=''){
            $this->Report=(new ReportsMod())->getContP1Branch($DateF,$DateL,$Branch);
        } else {
            $this->Report=(new ReportsMod())->getContP1($DateF,$DateL);     
        }
                   
        $this->RepContP1ToExcel($this->Report, 'NewContRep');
        $this->render('reports/ContP1Rep',['Report'=> $this->Report]);
    }
    
    public function actionShowContExpForm(){
        $this->render('reports/ContExpRep',['Report'=>[],'BranchList'=>[]]);
    }
    
    public function actionContExpRep(){//отчёт по новым экспертизам
        $DateF=date('d.m.Y');
        if ($_GET['DateF']!=''){
            $DateF=$_GET['DateF'];
        }
        $DateL=date('d.m.Y');
        if ($_GET['DateL']!=''){
            $DateL=$_GET['DateL'];
        }
        $Branch=$_GET['BranchName'];
        
        if ($Branch!=''){
            $this->Report=(new ReportsMod())->getContNewPaysBranch($DateF,$DateL,$Branch);
        } else {
            $this->Report=(new ReportsMod())->getContNewPays($DateF,$DateL);     
        }
        $this->RepExpToExcel($this->Report, 'NewExpRep');
        $this->render('reports/ContExpRep',['Report'=>$this->Report,'BranchList'=>[]]);
    }
    
    public function actionContNewRep(){
        $DateF=date('d.m.Y');
        if ($_GET['DateF']!=''){
            $DateF=$_GET['DateF'];
        }
        $DateL=date('d.m.Y');
        if ($_GET['DateL']!=''){
            $DateL=$_GET['DateL'];
        }
        $Branch=$_GET['BranchName'];
        
        if ($Branch!=''){
            $this->Report=(new ReportsMod())->getContNewPaysBranch($DateF,$DateL,$Branch);
        } else {
            $this->Report=(new ReportsMod())->getContNewPays($DateF,$DateL);             
        }
        $RepCols=[
            'A2'=>'ClCode',
            'B2'=>'ContCode',
            'C2'=>'ФИО',
            'D2'=>'Подразделение',
            'E2'=>'Менеджер',
            'F2'=>'Дата дог.',
            'G2'=>'Дата платежа',
            'H2'=>'Сумма платежа',
            
        ];
        (new RepToExcel())->exportReport($this->Report,$RepCols,'план новых платежей','ПланПоНовым');
                
        $this->render('reports/ContNewRep',['Report'=>$this->Report,'BranchList'=>[]]);
    }
    
    public function actionShowContNew(){
        $this->render('reports/ContNewRep',['Report'=>[],'BranchList'=>[]]);
    }
    
    protected function RepExpToExcel($Arr,$File){
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
    
    protected function RepContP1ToExcel($Arr,$File){
        $xls = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle('Договоры БФЛ');
        $sheet->setCellValue("A1", "Договоры БФЛ");
        $sheet->setCellValue("A2", "ClCode");
        $sheet->setCellValue("B2", "ContCode");
        $sheet->setCellValue("C2", "ФИО");
        $sheet->setCellValue("D2", "Подразделение");
        $sheet->setCellValue("E2", "Менеджер");        
        $sheet->setCellValue("F2", "Дата дог.");
        $sheet->setCellValue("G2", "Дата перв. платежа");
        $sheet->setCellValue("H2", "Программа");
        $sheet->setCellValue("I2", "Тариф");
        $sheet->setCellValue("J2", "Сумма договора");
        $sheet->setCellValue("K2", "Долг по ЭПЭ");
        $sheet->setCellValue("L2", "Скидка");
     
        $i=3;
        foreach ($Arr as $reprow){
            $j=1;
            foreach ($reprow as $key=>$repfield){
                if ($key=='FRCONTDATE'){
                    $repfield=(new PrintFunctions())->DateToStr($repfield);
                } elseif ($key=='PAYDATE') {
                    $repfield=(new PrintFunctions())->DateToStr($repfield);
                }
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
