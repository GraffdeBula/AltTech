<?php
/**
 * Контроллер для загрузки отчёта по экспертизам
 *
 * @author Andrey
 */
class RepPaymentsCtrl extends ControllerMain{
    protected $Payments;
    protected $RepPayments;
    protected $RepCompPayments;
    protected $RepMethodPaymets;
    protected $TotalIncome;   
    
    public function __construct(){
        $this->ViewName='Отчёт по платежам';
    }
    
    public function actionIndex() {        
        $this->formRep();    
        $this->ExportToExcel($this->Payments,'PaymentRep');
        $this->render('reports/PaymentsRep',
                ['Report1'=>$this->Payments,
                    'Report2'=>$this->RepPayments,
                    'Report3'=>$this->RepCompPayments,
                    'Report4'=>$this->RepMethodPayments,
                    'TotalIncome'=>$this->TotalIncome,
                    'BranchList'=>(new Branch())->getBranchList()]);
    }
    
    public function formRep() {
        $Model=new PaymentMod();        
        
        $ContType=0;
        if (isset($_GET['ContType'])){
            $ContType=$_GET['ContType'];
        }
        if (isset($_GET['DateF']) && isset($_GET['DateL']) && ((!isset($_GET['Branch'])) or ($_GET['Branch']==''))){
            #echo('111');
            $this->Payments=(new PaymentMod())->getPaymentFullListDt($_GET['DateF'],$_GET['DateL'],$ContType);
            $this->RepPayments=(new PaymentMod())->getPaymentAggrListDt($_GET['DateF'],$_GET['DateL'],$ContType);
            $this->RepCompPayments=(new PaymentMod())->getPaymentCompListDt($_GET['DateF'],$_GET['DateL'],$ContType);
            $this->TotalIncome=(new PaymentMod())->getIncomeCompTotal($_GET['DateF'],$_GET['DateL']);
            $this->RepMethodPayments=(new PaymentMod())->getPaymentMethCompListDt($_GET['DateF'],$_GET['DateL'],$ContType);
        } 
        if (isset($_GET['DateF']) && isset($_GET['DateL']) && (isset($_GET['Branch'])) && ($_GET['Branch']!='')){
            #echo('222');
            $this->Payments=(new PaymentMod())->getPaymentFullListBrDt($_GET['DateF'],$_GET['DateL'],$_GET['Branch'],$ContType);
            $this->RepPayments=(new PaymentMod())->getPaymentAggrListBrDt($_GET['DateF'],$_GET['DateL'],$_GET['Branch'],$ContType);
            $this->RepCompPayments=(new PaymentMod())->getPaymentCompListDt($_GET['DateF'],$_GET['DateL'],$ContType);
            $this->TotalIncome=(new PaymentMod())->getIncomeCompTotal($_GET['DateF'],$_GET['DateL']);
            $this->RepMethodPayments=(new PaymentMod())->getPaymentMethBrListDt($_GET['DateF'],$_GET['DateL'],$ContType);
        }
        if (((!isset($_GET['DateF'])) or (!isset($_GET['DateL']))) && ((!isset($_GET['Branch'])) or ($_GET['Branch']==''))){  
            #echo('333');
            $this->Payments=(new PaymentMod())->getPaymentFullListDt(date("d.m.Y"),date("d.m.Y"),$ContType);
            $this->RepPayments=(new PaymentMod())->getPaymentAggrListDt(date("d.m.Y"),date("d.m.Y"),$ContType);
            $this->RepCompPayments=(new PaymentMod())->getPaymentCompListDt(date("d.m.Y"),date("d.m.Y"),$ContType);
            $this->TotalIncome=(new PaymentMod())->getIncomeCompTotal(date("d.m.Y"),date("d.m.Y"));
            $this->RepMethodPayments=(new PaymentMod())->getPaymentMethCompListDt(date("d.m.Y"),date("d.m.Y"),$ContType);
        }
        if (((!isset($_GET['DateF'])) or (!isset($_GET['DateL']))) && (isset($_GET['Branch'])) && ($_GET['Branch']!='')){        
            #echo('444');
            $this->Payments=(new PaymentMod())->getPaymentFullListBrDt(date("d.m.Y"),date("d.m.Y"),$_GET['Branch'],$ContType);
            $this->RepPayments=(new PaymentMod())->getPaymentAggrListBrDt(date("d.m.Y"),date("d.m.Y"),$_GET['Branch'],$ContType);
            $this->RepCompPayments=(new PaymentMod())->getPaymentCompListDt(date("d.m.Y"),date("d.m.Y"),$ContType);
            $this->TotalIncome=(new PaymentMod())->getIncomeCompTotal(date("d.m.Y"),date("d.m.Y"));
            $this->RepMethodPayments=(new PaymentMod())->getPaymentBrMethListDt(date("d.m.Y"),date("d.m.Y"),$ContType);
        }        
                   
    }
    
    protected function ExportToExcel($Arr,$File){
        
        $xls = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle('Отчёт по платежам');
        $sheet->setCellValue("A1", "Отчёт по платежам");
        $sheet->setCellValue("A2", "ID");
        $sheet->setCellValue("B2", "Номер ПКО");
        $sheet->setCellValue("C2", "Подразделение");
        $sheet->setCellValue("D2", "Дата платежа");
        $sheet->setCellValue("E2", "Сумма платежа");        
        $sheet->setCellValue("F2", "Назначение платежа");
        $sheet->setCellValue("G2", "Номер договора");
        $sheet->setCellValue("H2", "Продукт");
        $sheet->setCellValue("I2", "ФИО клиента");
        $sheet->setCellValue("J2", "Способ платежа");
        
        $i=3;
        foreach ($Arr as $reprow){
            if ($reprow->PRODCODE==1){
                $Prod='БФЛ';
            } else {
                $Prod='РУ';
            }
            $sheet->setCellValueByColumnAndRow(1,$i,$reprow->ID);
            $sheet->setCellValueByColumnAndRow(2,$i,$reprow->PAYCODE);
            $sheet->setCellValueByColumnAndRow(3,$i,$reprow->CONTBRANCH);
            $sheet->setCellValueByColumnAndRow(4,$i,(new PrintFunctions())->DateToStr($reprow->PAYDATE));
            $sheet->setCellValueByColumnAndRow(5,$i,$reprow->PAYSUM);
            $sheet->setCellValueByColumnAndRow(6,$i,$reprow->PAYPR);
            $sheet->setCellValueByColumnAndRow(7,$i,$reprow->CONTCODE);
            $sheet->setCellValueByColumnAndRow(8,$i,$Prod);           
            $sheet->setCellValueByColumnAndRow(9,$i,$reprow->CONTCLIENT);
            $sheet->setCellValueByColumnAndRow(10,$i,$reprow->PAYMETHOD);
            
            $i++;
        }
        //create file name  
        $FileName="{$_SERVER['DOCUMENT_ROOT']}/".WORK_FOLDER."/downloads/{$File}.xlsx";
        //вывод в файл и сохранение
        $objWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($xls);
        $objWriter->save($FileName);
        
    }
}
