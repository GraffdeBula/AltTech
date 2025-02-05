<?php
/**
 * старый контролер для работы с вьюшкой АМО
 *
 * @author Andrey
 */
class AmoCtrl extends ControllerMain{
    public $LeadList=[];
    public $Pipelines=[];
    public $Users=[];
    public $AmoResult=[];
    
    
    public function actionIndex(){
        $this->ViewName='Amo View';
        $this->render('Amo',['AmoResult'=>$this->AmoResult]);
    }
    
    public function actionAuth(){
        $this->AmoResult=(new AmoMethods2())->getAuth('');
        $this->actionIndex();
    }
    
    public function actionGetLead(){
        
    }
    
    public function actionGetStatuses(){
        $this->AmoResult=(new AmoMethods2())->getStatuses('');
        $this->actionIndex();
    }
    
    
}