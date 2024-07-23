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
    public function actionGetTarifList0(){
        $TarifList=(new TarifMod())->getTarifElListByType('Тариф');
        echo json_encode($TarifList);
    }
    public function actionGetTarifList1(){
        $TarifList=(new TarifMod())->getTarifElListByType('Доплата');
        echo json_encode($TarifList);
    }
    public function actionGetTarifList2(){
        $TarifList=(new TarifMod())->getTarifElListByType('Вычет');
        echo json_encode($TarifList);
    }
    public function actionGetTarifList3(){
        $TarifList=(new TarifMod())->getTarifElListByType('Скидка');
        echo json_encode($TarifList);
    }
    
    
}
