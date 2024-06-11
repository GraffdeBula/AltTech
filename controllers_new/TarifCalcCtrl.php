<?php
/**
 * контроллер для работы с вьюшкой Амо
 *
 * @author Andrey
 */
class TarifCalcCtrl extends ControllerMain{
      
    
    public function actionIndex(){
        $this->ViewName='Тарифный калькулятор';
        
        $this->render('TarifCalc',[]);
    }
    
    public function actionGetTarifList1(){
        $TarifList=(new TarifMod())->getTarifElList('Доплата');
        echo json_encode($TarifList);
    }
    public function actionGetTarifList2(){
        $TarifList=(new TarifMod())->getTarifElList('Вычет');
        echo json_encode($TarifList);
    }
    public function actionGetTarifList3(){
        $TarifList=(new TarifMod())->getTarifElList('Скидка');
        echo json_encode($TarifList);
    }
    
    
}
