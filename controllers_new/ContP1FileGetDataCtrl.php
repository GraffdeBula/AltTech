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
    
}
