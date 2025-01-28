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
    
    public function actionContP1DiscRepForm(){//форма отчёта по скидкам
        $this->render('reports/ContP1DiscRep',['Report'=>[]]);    
    }
    
    public function actionContP1DiscRep(){//отчёт по скидкам
        $DateF=date('d.m.Y');
        if ($_GET['DateF']!=''){
            $DateF=$_GET['DateF'];
        }
        $DateL=date('d.m.Y');
        if ($_GET['DateL']!=''){
            $DateL=$_GET['DateL'];
        }
                        
        $this->Report=(new ReportsMod())->getContP1Disc($DateF,$DateL);           
                   
        $this->ContP1DiscRepToExcel($this->Report, 'ContP1Disc');
        $this->render('reports/ContP1DiscRep',['Report'=> $this->Report]);
    }
    
    public function actionShowContP1DropForm(){//отчёт по расторжениям форма
        $this->render('reports/ContP1RepDrop',['Report'=>[]]);    
    }
    
    public function actionShowContP1DropRep(){//отчёт по расторжениям
        $DateF=date('d.m.Y');
        if ($_GET['DateF']!=''){
            $DateF=$_GET['DateF'];
        }
        $DateL=date('d.m.Y');
        if ($_GET['DateL']!=''){
            $DateL=$_GET['DateL'];
        }
        $DateDF=date('d.m.Y',mktime(0,0,0,1,1,2000));        
        if ($_GET['DateDF']!=''){
            $DateDF=$_GET['DateDF'];
        }
        $DateDL=date('d.m.Y',mktime(0,0,0,1,1,2099));
        if ($_GET['DateDL']!=''){
            $DateDL=$_GET['DateDL'];
        }
        
        $Branch=$_GET['BranchName'];
        
        if ($Branch!=''){
            $this->Report=(new ReportsMod())->getContP1DropBranch($DateF,$DateL,$DateDF,$DateDL,$Branch);
        } else {
            $this->Report=(new ReportsMod())->getContP1Drop($DateF,$DateL,$DateDF,$DateDL);     
        }
                        
        $RepCols=[
            'A2'=>'ClCode',
            'B2'=>'ContCode',
            'C2'=>'ФИО',
            'D2'=>'Подразделение',
            'E2'=>'Менеджер',
            'F2'=>'Дата дог.',
            'G2'=>'Дата перв. платежа',
            'H2'=>'Дата расторжения',
            'I2'=>'Программа',
            'J2'=>'Тариф',
            'K2'=>'Сумма договора',
            'L2'=>'Долг по ЭПЭ',
            'M2'=>'Скидка',
        ];
        (new RepToExcel())->exportReport($this->Report,$RepCols,'Расторжения','DropContRep');
              
        $this->render('reports/ContP1RepDrop',['Report'=> $this->Report]);
    }
    
    
    public function actionShowContP1AfterUnderForm(){//отчёт по итогам андеррайтинга
        $this->render('reports/ContP1AfterUnder',['Report'=>[]]);    
    }
    
    public function actionShowContP1AfterUnder(){//отчёт по итогам андеррайтинга форма
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
            $this->Report=(new ReportsMod())->getContAfterUnderErrBranch($DateF,$DateL,$Branch);
        } else {
            $this->Report=(new ReportsMod())->getContAfterUnderErr($DateF,$DateL);     
        }
        
        $RepCols=[
            'A2'=>'ClCode',
            'B2'=>'ContCode',
            'C2'=>'ФИО',
            'D2'=>'Подразделение',
            'E2'=>'Дата договора',
            'F2'=>'Дата правового анализа',
            'G2'=>'ФИО юриста',
            'H2'=>'Дата проверки',
            'I2'=>'Комментарий андеррайтера',
        ];
        (new RepToExcel())->exportReport($this->Report,$RepCols,'Замечания','UnderErrRep');
        
        $this->render('reports/ContP1AfterUnder',['Report'=>$this->Report]);    
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
        $sheet->setCellValue("E2", "Риск");        
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
    
    protected function ContP1DiscRepToExcel($Arr,$File){
        $xls = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle('Договоры БФЛ');
        $sheet->setCellValue("A1", "Отчёт по скидкам");
        $sheet->setCellValue("A2", "ClCode");
        $sheet->setCellValue("B2", "ContCode");
        $sheet->setCellValue("C2", "ФИО");
        $sheet->setCellValue("D2", "Подразделение");
        $sheet->setCellValue("E2", "Риски");        
        $sheet->setCellValue("F2", "Дата дог.");
        $sheet->setCellValue("G2", "Дата допсоглашения");
        $sheet->setCellValue("H2", "Сумма доплаты за сложность");
        $sheet->setCellValue("I2", "Тариф");
        $sheet->setCellValue("J2", "Сумма договора");
        $sheet->setCellValue("K2", "Скидка");
        $sheet->setCellValue("L2", "Число кредитов");
        $sheet->setCellValue("M2", "Сложных кредиторов");
        $sheet->setCellValue("N2", "Сумма долга");
     
        $i=3;
        $ContCode[2]=0;
        foreach ($Arr as $reprow){
            $ContCode[$i]=$reprow->CONTCODE;
            $sheet->setCellValueByColumnAndRow(1,$i,$reprow->CLCODE);
            $sheet->setCellValueByColumnAndRow(2,$i,$reprow->CONTCODE);
            $sheet->setCellValueByColumnAndRow(3,$i,$reprow->CLFIO);
            $sheet->setCellValueByColumnAndRow(4,$i,$reprow->FROFFICE);
            $sheet->setCellValueByColumnAndRow(5,$i,$reprow->EXLISTVALUE);
            
            if ($reprow->CONTCODE!=$ContCode[$i-1]){
                $sheet->setCellValueByColumnAndRow(6,$i,(new PrintFunctions())->DateToStr($reprow->FRCONTDATE));
                $sheet->setCellValueByColumnAndRow(7,$i,(new PrintFunctions())->DateToStr($reprow->FRDOPDATE));
                $sheet->setCellValueByColumnAndRow(8,$i,$reprow->FRDOPSUM);
                $sheet->setCellValueByColumnAndRow(9,$i,$reprow->FRCONTTARIF);
                $sheet->setCellValueByColumnAndRow(10,$i,$reprow->FRCONTSUM);
                $sheet->setCellValueByColumnAndRow(11,$i,$reprow->DISCOUNTSUM);
                $sheet->setCellValueByColumnAndRow(12,$i,$reprow->FRCRNUM);
                $sheet->setCellValueByColumnAndRow(13,$i,$reprow->FRCOMPLEXCRNUM);
                $sheet->setCellValueByColumnAndRow(14,$i,$reprow->EXTOTDEBTSUM);
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
