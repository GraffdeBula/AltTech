<?php
/**
 * контроллер для работы с вьюшкой Амо
 *
 * @author Andrey
 */
class AmoCtrl extends ControllerMain{
    public $LeadList=[];
    
    public function actionIndex(){
        $this->ViewName='Amo View';
        $this->render('Amo',[]);
    }
    
    public function actionGetList(){
        $this->amoGetList();
        $this->ViewName='Amo View';
        $this->render('Amo',['LeadList'=>$this->LeadList]);
    }
    
    protected function amoGetList(){
        $this->LeadList=(new AmoMethods())->getAccount();
        new MyCheck($this->LeadList,0);
        return $this->LeadList;
    }
}
