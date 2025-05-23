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
        $this->Agent=new AgentNul();        
        $this->ShowList();
    }   
    
    public function actionSaveAgent(){
        $Model=new AT7ReferProg();
        
        $Model->InsAgent($_GET['AgName'],$_GET['AgPhone'],$_SESSION['EmName'],$_GET['Status'],$_GET['PayType']);
        
        $NewAg=$Model->GetAgent($_GET['AgName'],$_GET['Status']);
        $ID=2731+$NewAg->ID;
        $Code='AgentActive'.$ID;
        $ReferLink="https://fpk-alternativa.ru/bankrotstvo?utm_term=promo&kod={$Code}";
        $Model->UpdAgent($NewAg->ID, $NewAg->NAME, $Code, $ReferLink, $_GET['AgPhone']);
        $this->Agent=$this->getAgent();        
        $this->ShowList();
    }
    
    public function actionSaveContact(){        
        
        //постановка задачи в АМО
        if ($_GET['AgStatus']=='4'){
            $Status='Анонимный агент';
        }else{
            $Status='Открытый агент';
        }
        
        $Amo=new AmoMethods2();
        $Answer=$Amo->addContact($_GET['ContName'],$_GET['ContPhone']);
        #new MyCheck($Answer,0);
        $ContId=$Answer['_embedded']['contacts']['0']['id'];
        $Branch=(new Branch($_SESSION['EmBranch']))->getRec()->BRCITY;
                
        $Answer=$Amo->addLead($ContId,'Рекомендация Active. '.$Status,$Branch,$_GET['AgCode']);   
        $LeadId=$Answer['_embedded']['leads']['0']['id'];
        $Amo->addTagToLead("Active", $LeadId);
        //сохранение агента в БД
        $Model=new AT7ReferProg();
        $Model->addContact($_GET['ContName'], $_GET['ContPhone'], $_GET['AgCode'], $LeadId, $_SESSION['EmName']);
                
        $this->Agent=$this->getAgent();        
        $this->getContList();
        //возврат на форму
        $this->ShowList();
    }
    
    public function actionDelAgent(){
        $DelComment="{'Date':'".Date('d.m.Y')."','Name':'".$_SESSION['EmName']."','Comment':'".$_GET['DelComment']."'}";
        (new AT7ReferProg())->DelAgent($_GET['RefId'], $DelComment);
        header("Location: index_admin.php?controller=RefProgContactsCtrl");
    }
    
    protected function getContList(){
        $ContList=(new AT7ReferProg())->getContactList(); 
        $i=0;
        $Agent=[];
        foreach($ContList as $Cont){
            $i++;
            $Agent[$i]=$Cont->AGENT;
        }
        
    }
            
    protected function showList(){       
        $this->ViewName='Программа акивных рекомендаций';
        $args=['Agent'=>$this->Agent,'Contacts'=>$this->ContList,'Agents'=>(new AT7ReferProg())->GetAgentActList()];        
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

