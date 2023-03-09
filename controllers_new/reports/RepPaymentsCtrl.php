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
        if (isset($_GET['DateF']) && isset($_GET['DateL'])){
            $this->Payments=(new PaymentMod())->getPaymentFullList($_GET['DateF'],$_GET['DateL']);
            $this->RepPayments=(new PaymentMod())->getPaymentAggrList($_GET['DateF'],$_GET['DateL']);
        } else {
            $this->Payments=(new PaymentMod())->getPaymentFullList(date("d.m.Y"),date("d.m.Y"));
            $this->RepPayments=(new PaymentMod())->getPaymentAggrList(date("d.m.Y"),date("d.m.Y"));
        }
        
                
        
    }
    
    protected function ExportToExcel(){
        
    }
}
