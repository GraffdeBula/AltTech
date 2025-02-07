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
        $this->AmoResult=(new AmoMethods2())->getAuth();
        $this->actionIndex();
    }
    
    public function actionGetLead(){
        $this->AmoResult=(new AmoMethods2())->getLeadId($_GET['LeadId']);
        $this->actionIndex();
    }
    
    public function actionGetStatuses(){
        $this->AmoResult=(new AmoMethods2())->getStatuses();
        $this->actionIndex();
    }
    
    public function actionAddContact(){
        $this->AmoResult=(new AmoMethods2())->addContact($_GET['Name'],$_GET['Phone']);
        $this->actionIndex();
    }
    
    public function actionAddLead(){
        $ContactId=(new AmoMethods2())->addContact($_GET['Name'],$_GET['Phone'])['_embedded']['contacts']['0']['id'];        
        
        $this->AmoResult=(new AmoMethods2())->addLead($ContactId,$_GET['LeadName']);
        $this->actionIndex();
    }
        
}