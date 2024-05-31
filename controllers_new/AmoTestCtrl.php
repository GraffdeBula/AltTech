<?php
/**
 * контроллер для работы с вьюшкой Амо
 *
 * @author Andrey
 */
class AmoTestCtrl extends ControllerMain{    
    public $AmoResult=[];    
    
    public function actionIndex(){
        $this->ViewName='Amo View';
        $this->render('Amo',['AmoResult'=>$this->AmoResult]);
    }
    
    public function actionNewLead(){
        $Answer=(new AmoMethods())->addLead('NewTestLead', '');
        
        $this->actionIndex();
    }
    
    public function actionNewContact(){
        $Answer=(new AmoMethods())->addContact($_GET['ContName']);
        if (isset($Answer['_embedded']['contacts']['0']['id'])){
            $this->AmoResult=(new AmoMethods())->getContact($Answer['_embedded']['contacts']['0']['id']);
            $this->actionIndex();
        }else{
            new MyCheck($Answer,0);
        }
        
    }
    
    public function actionTestRefCont(){
        $Amo=new AmoMethods();
        $Answer=$Amo->addContact($_GET['ContName'],$_GET['ContPhone']);
        $ContId=$Answer['_embedded']['contacts']['0']['id'];
        $Branch=(new Branch($_SESSION['EmBranch']))->getRec()->BRCITY;
                
        $Answer=$Amo->addLead($_GET['LeadName'], $ContId,$Branch);
        
        $Answer=$Amo->addTagToLead("Active", $Answer['_embedded']['leads']['0']['id']);
        
        var_dump($Answer);
        $this->actionIndex();                
    }
            
    
}
