<?php
/**
 * контроллер управления главной формой
 *
 * функции
 * 
 */
class RefProgContactsCtrl extends ControllerMain {
    protected $Agent;    
    protected $ContList=[];
    
    public function actionIndex(){        
        $this->Agent=$this->getAgent();        
        $this->ShowList();
    }   
    
    public function actionSaveAgent(){
        $Model=new AT7ReferProg();
        $Model->InsAgent($_GET['AgName'],$_GET['AgPhone'],$_SESSION['EmName'],$_GET['Status'],$_GET['PayType']);
        
        $NewAg=$Model->GetAgent($_GET['AgName']);
        $ID=2731+$NewAg->ID;
        $Code='AgentActive'.$ID;
        $ReferLink="https://fpk-alternativa.ru/bankrotstvo?utm_term=promo&kod={$Code}";
        $Model->UpdAgent($NewAg->ID, $NewAg->NAME, $Code, $ReferLink, $_GET['AgPhone']);
        $this->Agent=$this->getAgent();        
        $this->ShowList();
    }
    
    public function actionSaveContact(){        
        $Model=new AT7ReferProg();
        $Model->addContact($_GET['ContName'], $_GET['ContPhone'], $_GET['AgCode'], 'comment',$_SESSION['EmName']);
        
        $this->Agent=$this->getAgent();        
        $this->getContList();
        //постановка задачи в АМО
        if ($_GET['AgStatus']=='4'){
            $Status='Анонимный агент';
        }else{
            $Status='Открытый агент';
        }
        
        $Amo=new AmoMethods();
        $Answer=$Amo->addContact($_GET['ContName'],$_GET['ContPhone']);
        $ContId=$Answer['_embedded']['contacts']['0']['id'];
        $Branch=(new Branch($_SESSION['EmBranch']))->getRec()->BRCITY;
                
        $Answer=$Amo->addLead('Рекомендация Active. '.$Status, $ContId,$Branch,$_GET['AgCode']);    
        $Amo->addTagToLead("Active", $Answer['_embedded']['leads']['0']['id']);
        //возврат на форму
        $this->ShowList();
    }
    
    protected function getContList(){
        $this->ContList=(new AT7ReferProg())->getContactList($_GET['AgCode']);        
    }
            
    protected function showList(){       
        $this->ViewName='Программа акивных рекомендаций';
        $args=['Agent'=>$this->Agent,'Contacts'=>$this->ContList];        
        $this->render('ATRefProgContacts',$args);
    }
    
    protected function getAgent(){
        if (isset($_GET['AgPhone'])){
            $Phone=$_GET['AgPhone'];            
        }else{
            $Phone='0000';
        }
        if((new AT7ReferProg())->GetAgentByPhone($Phone)){
            return (new AT7ReferProg())->GetAgentByPhone($Phone);
        }else{
            return new AgentNul();
        }
        
    }
}

