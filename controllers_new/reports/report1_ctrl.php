<?php

class report1_ctrl extends Controller{
    protected $repTotal;
    protected $repBranch;
    
    public function actionIndex() {//стартовое действие
        /*сюда можно попасть по ссылке из меню
         *сюда можно попасть нажав Назад
         *сюда можно попасть нажав кнопку "обратно"
         **ветвление
         * отчёт1 свод
         * отчёт1 расшифровка по филиалу
         * отчёт2 свод за выбранный период (по умолчанию что-то надо задать)
         * отчёт2 расшифровка по филиалу за выбранный период
         * 
        */
        
        if ((!isset($_GET['brInd']) and ($_GET['repInd']=='rep1'))){
            $this->actionShowCompanyList1();
        } elseif ((isset($_GET['brInd']) and ($_GET['repInd']=='rep1'))){
            $branch=$_GET['brInd'];
            $this->actionShowBranchList1($branch);
        } elseif ((!isset($_GET['brInd']) and ($_GET['repInd']=='rep2') and isset($_GET['repDat1']))){
            $repDat1=$_GET['repDat1'];
            $repDat2=$_GET['repDat2'];
            $this->actionShowCompanyList2($repDat1,$repDat2);
        } elseif ((!isset($_GET['brInd']) and ($_GET['repInd']=='rep2') and !isset($_GET['repDat1']))){            
            $dat12=date('d.m.Y');
            $this->actionShowCompanyList2($dat12,$dat12);
        } elseif ((isset($_GET['brInd']) and ($_GET['repInd']=='rep2'))){
            $branch=$_GET['brInd'];
            $repDat1=$_GET['repDat1'];
            $repDat2=$_GET['repDat2'];
            $this->actionShowBranchList2($branch,$repDat1,$repDat2);
        } else {
            echo('FALSE_FALSE_FALSE');
        }
                  
    }
    
    public function actionShowCompanyList1(){
        $Model=new ReportDeposit();
        $this->repTotal=$Model->getTotalRep();
        $this->repTotalEx(); //формирование файла excel
        $args=['rep'=>$this->repTotal];        
        $this->render('report1',$args);
        
    }
    
    public function actionShowBranchList1($brName) {
        $Model=new ReportDeposit();
        $this->repBranch=$Model->getBranchRep($brName);
        $this->repBranchEx(); //формирование файла excel
        $args=['rep'=>$this->repBranch];   
        $this->render('report1br',$args);
    }
    
    public function actionShowCompanyList2($repDat1,$repDat2){        
        $Model=new ReportDeposit();
        $this->repTotal=$Model->getTotalRep2($repDat1,$repDat2);        
        $this->repTotal2Ex(); //формирование файла excel        
        $args=['rep'=>$this->repTotal,'repDat1'=>$repDat1,'repDat2'=>$repDat2];        
        
        $this->render('report2',$args);
        
    }
    
    public function actionShowBranchList2($brName,$repDat1,$repDat2) {
        $Model=new ReportDeposit();
        $this->repBranch=$Model->getBranchRep2($brName,$repDat1,$repDat2);
        $this->repBranch2Ex(); //формирование файла excel
        $args=['rep'=>$this->repBranch];   
        $this->render('report2br',$args);
    }
    
    public function actionShowCard($id) {
        
    }
    
    protected function repTotalEx(){
        //вывод отчёта в EXCEL
        // Создаем объект класса PHPExcel
        $xls = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        // Устанавливаем индекс активного листа
        $xls->setActiveSheetIndex(0);
        // Получаем активный лист
        $sheet = $xls->getActiveSheet();
        // Подписываем лист
        $sheet->setTitle('Отчёт по ОХ');
        // Вставляем заголовки таблицы
        $sheet->setCellValue("A1", "ОСТАТКИ ПО ОТВЕТСТВЕННОМУ ХРАНЕНИЮ");
        $sheet->setCellValue("A2", "ФИЛИАЛ");
        $sheet->setCellValue("B2", "ВНЕСЕНО");
        $sheet->setCellValue("C2", "ВЫДАНО");
        $sheet->setCellValue("D2", "ОСТАТОК");
        $i=3;
        
        foreach ($this->repTotal as $reprow){
            $sheet->setCellValueByColumnAndRow(1,$i,$reprow->BRANCH);
            $sheet->setCellValueByColumnAndRow(2,$i,$reprow->SUM1);
            $sheet->setCellValueByColumnAndRow(3,$i,$reprow->SUM2);
            $sheet->setCellValueByColumnAndRow(4,$i,$reprow->SUM3);
            $i++;
        }
        //create file name  
        $fileName="{$_SERVER['DOCUMENT_ROOT']}/AltTech/downloads/reptotal.xlsx";
        //вывод в файл и сохранение
        $objWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($xls);
        $objWriter->save($fileName);
    }
    
    protected function repTotal2Ex(){
        //вывод отчёта в EXCEL
        // Создаем объект класса PHPExcel
        $xls = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        // Устанавливаем индекс активного листа
        $xls->setActiveSheetIndex(0);
        // Получаем активный лист
        $sheet = $xls->getActiveSheet();
        // Подписываем лист
        $sheet->setTitle('Отчёт по ОХ');
        // Вставляем заголовки таблицы
        $sheet->setCellValue("A1", "ОТВЕТСТВЕННОЕ ХРАНЕНИЕ ДВИЖЕНИЕ");
        $sheet->setCellValue("A2", "ФИЛИАЛ");
        $sheet->setCellValue("B2", "ВНЕСЕНО");
        $sheet->setCellValue("C2", "ВЫДАНО");                
        $i=3;
        
        foreach ($this->repTotal as $reprow){
            $sheet->setCellValueByColumnAndRow(0,$i,$reprow->BRNAME);
            $sheet->setCellValueByColumnAndRow(1,$i,$reprow->BRSUM1);
            $sheet->setCellValueByColumnAndRow(2,$i,$reprow->BRSUM2);            
            $i++;
        }
        //create file name  
        $fileName="{$_SERVER['DOCUMENT_ROOT']}/AltTech/downloads/reptotal2.xlsx";
        //вывод в файл и сохранение
        $objWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($xls);
        $objWriter->save($fileName);
    }
       
    protected function repBranchEx(){
        //вывод отчёта в EXCEL
        // Создаем объект класса PHPExcel
        $xls = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        // Устанавливаем индекс активного листа
        $xls->setActiveSheetIndex(0);
        // Получаем активный лист
        $sheet = $xls->getActiveSheet();
        // Подписываем лист
        $sheet->setTitle('Отчёт по ОХ');
        // Вставляем заголовки таблицы
        $sheet->setCellValue("A1", "ОСТАТКИ ПО ОТВЕТСТВЕННОМУ ХРАНЕНИЮ");
        $sheet->setCellValue("A2", "clCode");
        $sheet->setCellValue("B2", "contCode");
        $sheet->setCellValue("C2", "Клиент");        
        $sheet->setCellValue("D2", "ФИЛИАЛ");        
        $sheet->setCellValue("E2", "ВНЕСЕНО");
        $sheet->setCellValue("F2", "ВЫДАНО");
        $sheet->setCellValue("G2", "ОСТАТОК");
        $i=3;
        
        foreach ($this->repBranch as $reprow){
            $sheet->setCellValueByColumnAndRow(1,$i,$reprow->CLCODE);
            $sheet->setCellValueByColumnAndRow(2,$i,$reprow->CONTCODE);
            $sheet->setCellValueByColumnAndRow(3,$i,$reprow->CLNAME);
            $sheet->setCellValueByColumnAndRow(4,$i,$reprow->BRANCH);
            $sheet->setCellValueByColumnAndRow(5,$i,$reprow->SUM1);
            $sheet->setCellValueByColumnAndRow(6,$i,$reprow->SUM2);
            $sheet->setCellValueByColumnAndRow(7,$i,$reprow->SUM3);
            $i++;
        }
        //create file name  
        $fileName="{$_SERVER['DOCUMENT_ROOT']}/AltTech/downloads/repBranch.xlsx";
        //вывод в файл и сохранение
        $objWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($xls);
        $objWriter->save($fileName);
    }
    
    protected function repBranch2Ex(){
        //вывод отчёта о движении по филиалу в EXCEL
        // Создаем объект класса PHPExcel
        $xls = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        // Устанавливаем индекс активного листа
        $xls->setActiveSheetIndex(0);
        // Получаем активный лист
        $sheet = $xls->getActiveSheet();
        // Подписываем лист
        $sheet->setTitle('Отчёт по ОХ');
        // Вставляем заголовки таблицы
        $sheet->setCellValue("A1", "ОТВЕТСТВЕННОЕ ХРАНЕНИЕ ДВИЖЕНИЕ");
        $sheet->setCellValue("A2", "ID договора");
        $sheet->setCellValue("B2", "Клиент");
        $sheet->setCellValue("C2", "Дата");        
        $sheet->setCellValue("D2", "Сумма");
        $sheet->setCellValue("E2", "Филиал");
        $i=3;
        
        foreach ($this->repBranch as $reprow){
            $sheet->setCellValueByColumnAndRow(0,$i,$reprow->CONTCODE);
            $sheet->setCellValueByColumnAndRow(1,$i,$reprow->CLIENT);
            $sheet->setCellValueByColumnAndRow(2,$i,$reprow->PAYDATE);
            $sheet->setCellValueByColumnAndRow(3,$i,$reprow->PAYSUM);
            $sheet->setCellValueByColumnAndRow(4,$i,$reprow->PAYBRANCH);
            $i++;
        }
        //create file name  
        $fileName="{$_SERVER['DOCUMENT_ROOT']}/AltTech/downloads/repBranch2.xlsx";
        //вывод в файл и сохранение
        $objWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($xls);
        $objWriter->save($fileName);
    }
}
