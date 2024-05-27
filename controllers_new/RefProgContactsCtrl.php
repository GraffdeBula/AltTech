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
        $Model->InsAgent($_GET['AgName'],$_GET['AgPhone'],$_SESSION['EmName'],$_GET['Status']);
        
        $NewAg=$Model->GetAgent($_GET['AgName']);
        $ID=2731+$NewAg->ID;
        $Code='AgentLight'.$ID;
        $ReferLink="https://fpk-alternativa.ru/bankrotstvo?utm_term=promo&kod={$Code}";
        $Model->UpdAgent($NewAg->ID, $NewAg->NAME, $Code, $ReferLink, $_GET['AgPhone']);
        $this->Agent=$this->getAgent();        
        $this->ShowList();
    }
    
    public function actionSaveContact(){        
        $Model=new AT7ReferProg();
        $Model->addContact($_GET['ContName'], $_GET['ContPhone'], $_GET['AgCode'], 'comment');
        
        $this->Agent=$this->getAgent();        
        $this->getContList();
        
        
        $this->ShowList();
    }
    
    protected function getContList(){
        $this->ContList=(new AT7ReferProg())->getContactList($_GET['AgCode']);
        #new MyCheck($this->ContList,0);
    }
            
    protected function showList(){       
        $this->ViewName='Реферальная программа';
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
