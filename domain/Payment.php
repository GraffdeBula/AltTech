<?php

//namespace AltTech\domain;

/**
 * Класс Платёж для обработки функций, связанных с платежами
 * 
 *
 * @author Andrey
 */
class Payment {    
    protected $PaymentType; //список типов платежей
    protected $PaymentList; //список платежей по договору
    protected $TotalSum=[]; //общие суммы по договору P1
    
    protected $ClCode;
    protected $ContCode;
    protected $ProdCode;
    protected $ContType;
    protected $ContBranch;
    protected $ContEmp;
    protected $ContClient;
    protected $ContPr;    
    protected $ID;        
    protected $PayCode;
    protected $PaySum;
    protected $PayDate;
    protected $PayPr;
    protected $PayBranch;
    protected $PayFirm;
    protected $PayType;
    protected $PayMethod;
    protected $BuchName;
    protected $KassName;
    protected $OrgName;
    
    protected $Branch;
    protected $Emp;
    
    public function __construct($ClCode=0,$ContCode=0,$ContBranch='',$ContEmp='',$ProdCode=0,$ContType=1,
        $PaySum=0,$PayDate='',$PayPr='',$PayMethod=''){
        $this->ClCode=$ClCode;
        $this->ContCode=$ContCode;
        $this->ContBranch=$ContBranch;
        $this->ContEmp=$ContEmp;
        $this->ContType=$ContType;
        $this->PaySum=$PaySum;
        $this->PayDate=$PayDate;
        $this->PayPr=$PayPr;
        $this->ProdCode=$ProdCode;
        $this->PayMethod=$PayMethod;
        
        $this->PaymentType=(new ATDrPaymentMod())->getPaymentList1();
        $this->PaymentList=(new PaymentMod())->getPaymentList($this->ContCode,$ProdCode); 
        $this->TotalSum=[ 
            'TotalInc'=>(new PaymentMod())->countPayments($this->ContCode,3,9),
            'TotalDep'=>(new PaymentMod())->countPayments($this->ContCode,11,12)
        ];
    }
    
    public function addPayment(){
        #new MyCheck($this->PayMethod,0);
        $ClFIO=(new Client($_GET['ClCode']))->getClRec()->CLFIO;
        $this->PayPr=$_GET['PAYPR'];        
        foreach($this->PaymentType as $Type){            
            if ($this->PayPr==$Type->NAME){
                $this->PayType=$Type->PAYTYPE1;                                
            }            
        }        
        if (($this->PayType==2) or ($this->PayType==9) or ($this->PayType==12)){
            $this->PaySum=$this->PaySum*(-1);
        }        
        if ($_GET['FROFFICE']==''){
            $this->ContBranch=$_SESSION['EmBranch'];
        }else{
            $this->ContBranch=$_GET['FROFFICE'];
        }                
        $OrgPref=(new Branch($this->ContBranch))->getRec()->BRORGPREF;        
        (new PaymentMod())->addPayment($_SESSION['EmName'],$this->ProdCode,$this->ContCode,$this->PaySum,$_GET['PAYDATE'],$_GET['PAYPR'],
                $_SESSION['EmBranch'],$OrgPref,$this->ContBranch,$_GET['FRPERSMANAGER'],$ClFIO,'',$this->PayType,$this->ContType,$this->PayMethod);
        
        if ($this->PayType==3){
            (new ContP1($this->ContCode))->updFirstPayDate();
        }
        
        $this->getLastPaymentRec();
        
        if (($this->PayType==2) or ($this->PayType==9) or ($this->PayType==12)){            
            $this->printReturn();
        } else {            
            $this->printPayment();
        }
    }
        
    public function formPayBill($Id,$ContCode,$ProdCode) {        
        $this->getPaymentRecById($Id,$ContCode,$ProdCode);
        if (($this->PayType==2) or ($this->PayType==9) or ($this->PayType==12)){            
            $this->printReturn();
        } else {            
            $this->printPayment();
        }
    }
    
    public function getPaymentRecById($Id,$ContCode,$ProdCode){
        (new logger('_pay'))->logToFile($_SESSION['EmName']." started getting PaymentRec on ORG ".$this->OrgName." client ".$this->ContClient);
        $SelectedPay=(new PaymentMod())->getPaymentById($Id,$ContCode,$ProdCode);
//        new MyCheck([$SelectedPay],0);
        $this->getPaymentRec($SelectedPay);
    }
    
    public function getLastPaymentRec($i=0){//получение реквизитов последнего платежа для вывода на печать
        (new logger('_pay'))->logToFile($_SESSION['EmName']." started getting PaymentRec on ORG ".$this->OrgName." client ".$this->ContClient);
        $LastPay=(new PaymentMod())->getPaymentList($this->ContCode,$this->ProdCode)[$i];
        $this->getPaymentRec($LastPay);
    }
    
    public function getPaymentRec($LastPay){
        $this->ID=$LastPay->ID;
        $Branch=new Branch($LastPay->CONTBRANCH);    
        
        $Org=new Organization($Branch->getRec()->BRORGPREF);
        
        $Client=new Client($this->ClCode);
        if (($this->ProdCode==1)&&($this->PayType<10)){
            $Cont=new ContP1($this->ContCode);
            $this->ContPr="по договору №{$Cont->getFront()->CONTCODE}-Б от {$Cont->getFront()->FRCONTDATE}";
        }
        
        if (($this->ProdCode==1)&&($this->PayType>10)){
            $Cont=new ContP1($this->ContCode);
            $this->ContPr="Компенсация расходов Исполнителя за оплату депозита/госпошлины/публикаций и пр.";
        }
        if ($this->ProdCode==4){
            $Cont=new ContP4($this->ContCode);
            $this->ContPr="по договору №{$Cont->getFront()->CONTCODE} от {$Cont->getFront()->FRCONTDATE}";
        }
                
        $this->ContClient=$Client->getClRec()->CLFNAME.' '.$Client->getClRec()->CL1NAME.' '.$Client->getClRec()->CL2NAME;
        $this->PayCode=$LastPay->PAYCODE;
        $this->PaySum=$LastPay->PAYSUM;
        $this->PayDate=$LastPay->PAYDATE;
        $this->OrgName=$Org->getRec()->ORGNAME;
        if ($this->ContType==2){
            $this->BuchName=$Branch->getRec()->BRBUCH2;
            $this->KassName=$Branch->getRec()->BRKASS2;
        } else {
            $this->BuchName=$Branch->getRec()->BRBUCH1;
            $this->KassName=$Branch->getRec()->BRKASS1;
        }
        (new logger('_pay'))->logToFile($_SESSION['EmName']." got PaymentRec on ORG ".$this->OrgName." client ".$this->ContClient);
    }
            
    public function getTypeList(){
        return $this->PaymentType;
    }
    
    public function getPaymentList(){
        return $this->PaymentList;
    }
    
    public function getTotalSum(){
        return $this->TotalSum;
    }
    
    protected function printPayment(){
        $FileTemplate = \PhpOffice\PhpSpreadsheet\IOFactory::load("{$_SERVER['DOCUMENT_ROOT']}/".WORK_FOLDER."/templates/Шаблон ПКО1.xlsx");
        $sheet = $FileTemplate->getActiveSheet();        
        //ПКО
        $sheet->setCellValue("B6", $this->OrgName);
        $sheet->setCellValue("F12", $this->PayCode);
        $sheet->setCellValue("H12", (new PrintFunctions)->DateToStr($this->PayDate));
        $sheet->setCellValue("G18", $this->PaySum);
        $sheet->setCellValue("C20", $this->ContClient);
        $sheet->setCellValue("C22", $this->ContPr);
        $sheet->setCellValue("C26", (new PrintFunctions())->SumToStr($this->PaySum));
        $sheet->setCellValue("F34", $this->BuchName);
        $sheet->setCellValue("F37", $this->KassName);
        //квитанция
        $sheet->setCellValue("L2", $this->OrgName);
        $sheet->setCellValue("P5", $this->PayCode);
        $sheet->setCellValue("M6", (new PrintFunctions)->DateToStr($this->PayDate));
        $sheet->setCellValue("M8", $this->ContClient);
        $sheet->setCellValue("M12", $this->ContPr);
        $sheet->setCellValue("M18", $this->PaySum);
        $sheet->setCellValue("L20", (new PrintFunctions())->SumToStr($this->PaySum));
        $sheet->setCellValue("N34", $this->BuchName);
        $sheet->setCellValue("N37", $this->KassName);
        
        
        $FileName="{$_SERVER['DOCUMENT_ROOT']}/".WORK_FOLDER."/payments/{$this->ID}.xlsx";
        (new logger('_pay'))->logToFile($_SESSION['EmName']." printed PKO ".$FileName);
        $objWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($FileTemplate);
        $objWriter->save($FileName);
    }

    protected function printReturn(){
        $FileTemplate = \PhpOffice\PhpSpreadsheet\IOFactory::load("{$_SERVER['DOCUMENT_ROOT']}/".WORK_FOLDER."/templates/Шаблон РКО1.xlsx");
        $sheet = $FileTemplate->getActiveSheet();        
        //РКО
        $sheet->setCellValue("A6", $this->OrgName);
        $sheet->setCellValue("CC11", $this->PayCode);
        $sheet->setCellValue("CT11", (new PrintFunctions)->DateToStr($this->PayDate));
        $sheet->setCellValue("CC15", $this->PaySum*(-1));
        $sheet->setCellValue("H17", $this->ContClient);
        $sheet->setCellValue("K19", $this->ContPr);
        $sheet->setCellValue("G20", (new PrintFunctions())->SumToStr($this->PaySum*(-1)));
        $sheet->setCellValue("I29", (new PrintFunctions())->SumToStr($this->PaySum*(-1)));
        $sheet->setCellValue("AK27", $this->BuchName);
        $sheet->setCellValue("AG37", $this->KassName);
                      
        $FileName="{$_SERVER['DOCUMENT_ROOT']}/".WORK_FOLDER."/payments/{$this->ID}.xlsx";
        (new logger('_pay'))->logToFile($_SESSION['EmName']." printed RKO ".$FileName);
        $objWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($FileTemplate);
        $objWriter->save($FileName);
    }
}
