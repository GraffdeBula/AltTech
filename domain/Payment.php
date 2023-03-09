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
    protected $BuchName;
    protected $KassName;
    protected $OrgName;
    
    protected $Branch;
    protected $Emp;
    
    public function __construct($ClCode=0,$ContCode=0,$ContBranch='',$ContEmp='',$ProdCode=0,$ContType=1,
        $PaySum=0,$PayDate='',$PayPr=''){
        $this->ClCode=$ClCode;
        $this->ContCode=$ContCode;
        $this->ContBranch=$ContBranch;
        $this->ContEmp=$ContEmp;
        $this->ContType=$ContType;
        $this->PaySum=$PaySum;
        $this->PayDate=$PayDate;
        $this->PayPr=$PayPr;
        $this->ProdCode=$ProdCode;
        
        $this->PaymentType=(new ATDrPaymentMod())->getPaymentList1();
        $this->PaymentList=(new PaymentMod())->getPaymentList($this->ContCode,$this->ProdCode);

        foreach($this->PaymentType as $Type){
            if ($PayPr==$Type->NAME){
                $this->PayType=$Type->PAYTYPE1;
                break;
            }
        }
        if (($this->PayType==2) or ($this->PayType==9) or ($this->PayType==12)){
            $this->PaySum=$PaySum*(-1);
        }

    }
    
    public function addPayment(){
        $ClFIO=(new Client($_GET['ClCode']))->getClRec()->CLFIO;
        (new PaymentMod())->addPayment($_SESSION['EmName'],$this->ProdCode,$this->ContCode,$this->PaySum,$_GET['PAYDATE'],$_GET['PAYPR'],
                $_SESSION['EmBranch'],'Альт',$_GET['FROFFICE'],$_GET['FRPERSMANAGER'],$ClFIO,'',$this->PayType,$this->ContType);
        //$Emp,$ProdCode,$ContCode,$PaySum,$PayDate,$PayPr,$PayBranch,$PayFirm,$ContBranch,$ContEmp,$ContClient,$ContPr,$PayType,$ContType
        $this->getLastPaymentRec();
        if (($this->PayType==2) or ($this->PayType==9) or ($this->PayType==12)){
            $this->printReturn();
        } else {
            $this->printPayment();
        }
        
    }
    
    public function getLastPaymentRec(){//получение реквизитов последнего платежа для вывода на печать
        $LastPay=(new PaymentMod())->getPaymentList($this->ContCode,$this->ProdCode)[0];
        #var_dump($LastPay);
        #exit();
        $Branch=new Branch($this->ContBranch);
        
        $Org=new Organization($Branch->getRec()->BRORGPREF);
        
        $Client=new Client($this->ClCode);
        $Cont=new ContP1($this->ContCode);
        $this->ContPr="по договору №{$Cont->getFront()->CONTCODE} от {$Cont->getFront()->FRCONTDATE}";
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
    }
            
    public function getTypeList(){
        return $this->PaymentType;
    }
    
    public function getPaymentList(){
        return $this->PaymentList;
    }
    
    protected function printPayment(){
        $FileTemplate = \PhpOffice\PhpSpreadsheet\IOFactory::load("{$_SERVER['DOCUMENT_ROOT']}/AltTech/templates/Шаблон ПКО1.xlsx");
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
        
        
        $FileName="{$_SERVER['DOCUMENT_ROOT']}/AltTech/payments/{$this->ContCode}.xlsx";
        $objWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($FileTemplate);
        $objWriter->save($FileName);
    }

    protected function printReturn(){
        $FileTemplate = \PhpOffice\PhpSpreadsheet\IOFactory::load("{$_SERVER['DOCUMENT_ROOT']}/AltTech/templates/Шаблон РКО1.xlsx");
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
                      
        $FileName="{$_SERVER['DOCUMENT_ROOT']}/AltTech/payments/{$this->ContCode}.xlsx";
        $objWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($FileTemplate);
        $objWriter->save($FileName);
    }
}
