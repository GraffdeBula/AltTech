<?php
/**
 * Контроллер для загрузки отчёта по экспертизам
 *
 * @author Andrey
 */
class RepPaymentsCtrl extends ControllerMain{
    protected $Payments;
    protected $RepPayments;   
    
    public function __construct(){
        $this->ViewName='Отчёт по платежам';
    }
    
    public function actionIndex() {        
        $this->formRep();        
        $this->render('reports/PaymentsRep',['Report1'=>$this->Payments,'Report2'=>$this->RepPayments]);
    }
    
    public function formRep() {
        $Model=new PaymentMod();        
        if (isset($_GET['DateF']) && isset($_GET['DateL']) && (!isset($_GET['Branch']))){
            $this->Payments=(new PaymentMod())->getPaymentFullListDt($_GET['DateF'],$_GET['DateL']);
            $this->RepPayments=(new PaymentMod())->getPaymentAggrListDt($_GET['DateF'],$_GET['DateL']);
        } 
        if (isset($_GET['DateF']) && isset($_GET['DateL']) && isset($_GET['Branch'])){
            $this->Payments=(new PaymentMod())->getPaymentFullListBrDt($_GET['DateF'],$_GET['DateL'],$_GET['Branch']);
            $this->RepPayments=(new PaymentMod())->getPaymentAggrListBrDt($_GET['DateF'],$_GET['DateL'],$_GET['Branch']);
        }
        if (((!isset($_GET['DateF'])) or (!isset($_GET['DateL']))) && (!isset($_GET['Branch']))){        
            $this->Payments=(new PaymentMod())->getPaymentFullListDt(date("d.m.Y"),date("d.m.Y"));
            $this->RepPayments=(new PaymentMod())->getPaymentAggrListDt(date("d.m.Y"),date("d.m.Y"));
        }
        if (((!isset($_GET['DateF'])) or (!isset($_GET['DateL']))) && (isset($_GET['Branch']))){        
            $this->Payments=(new PaymentMod())->getPaymentFullListBrDt(date("d.m.Y"),date("d.m.Y"),$_GET['Branch']);
            $this->RepPayments=(new PaymentMod())->getPaymentAggrListBrDt(date("d.m.Y"),date("d.m.Y"),$_GET['Branch']);
        }
                
        
    }
    
    protected function ExportToExcel(){
        
    }
}
