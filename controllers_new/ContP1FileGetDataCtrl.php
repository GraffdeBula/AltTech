<?php

/**
 * контроллер для получения данных из БД посредством AJAX запроса и передачи их во Вью ContP1FileFront (Досье менеджера)
 * 
 * Какие данные получает
 * 1.Список платежей
 *
 * @author Andrey
 */
class ContP1FileGetDataCtrl extends ControllerMain {
    protected $PaymentList;
        
    public function actionGetPaymentList(){
        $this->PaymentList=(new PaymentMod())->getPaymentList($_GET['ContCode'],1);
        echo json_encode($this->PaymentList);        
    }
    
    public function actionAddPayment(){
        (new PaymentMod())->getPaymentList($_GET['ContCode'],1);                
    }
    
    public function actionDelPayment(){
        (new PaymentMod())->delPayment($_GET['ID'],$_GET['ContCode']);
    }
    
    public function actionGetPaymentMethodList(){
        $PaymentMethod=(new ATDrPaymentMod())->getPaymentMethod();
        echo json_encode($PaymentMethod);        
    }
    
    public function actionGetPaymentPrList(){
        $PaymentPr=(new ATDrPaymentMod())->getPaymentList1();
        new MyCheck($PaymentPr,1);
        echo json_encode($PaymentPr);        
    }
    
}
