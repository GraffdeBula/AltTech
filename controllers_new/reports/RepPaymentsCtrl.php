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
        $this->render('reports/PaymentsRep',
                ['Report1'=>$this->Payments,
                    'Report2'=>$this->RepPayments,
                    'Report3'=>$this->RepCompPayments,
                    'Report4'=>$this->RepCompPayments,
                    'TotalIncome'=>$this->TotalIncome,
                    'BranchList'=>(new Branch())->getBranchList()]);
    }
    
    public function formRep() {
        $Model=new PaymentMod();        
        /*
        if (isset($_GET['DateF']) && isset($_GET['DateL'])){
            echo('111');
            $this->Payments=(new PaymentMod())->getPaymentFullListDt($_GET['DateF'],$_GET['DateL']);
            $this->RepPayments=(new PaymentMod())->getPaymentAggrListDt($_GET['DateF'],$_GET['DateL']);
        } 
        if ((!isset($_GET['DateF'])) or (!isset($_GET['DateL']))){        
            $this->Payments=(new PaymentMod())->getPaymentFullListBrDt(date("d.m.Y"),date("d.m.Y"),$_GET['Branch']);
            $this->RepPayments=(new PaymentMod())->getPaymentAggrListBrDt(date("d.m.Y"),date("d.m.Y"),$_GET['Branch']);
        }
        */        
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
    
    protected function ExportToExcel(){
        
    }
}
