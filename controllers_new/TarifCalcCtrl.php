<?php
/**
 * контроллер для работы с вьюшкой Амо
 *
 * @author Andrey
 */
class TarifCalcCtrl extends ControllerMain{
      
    
    public function actionIndex(){
        $this->ViewName='Тарифный калькулятор';
        $TarifList=(new TarifMod())->getTarifElList();
        $this->render('TarifCalc',['TarifList'=>$TarifList]);
    }
    
    public function actionGetAuth(){
        $this->AmoResult=(new AmoMethods())->getAuth('');
        $this->actionIndex();
    }
}
