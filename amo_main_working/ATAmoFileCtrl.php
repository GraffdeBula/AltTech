<?php
/**
 * контроллер для работы с формой амоЦРМ
 *
 * функции
 * посмотреть лид по ID
 */
class ATAmoFileCtrl extends Controller {
    protected $data;
    protected $Lead;
    protected $Contact;
    protected $LeadList;
    protected $ContactList;
    protected $PipelineList;
    protected $StatusList;
    
    public function actionIndex(){
        $this->data=[];
        $this->ShowFile();
    }
    
    public function actionGetLead(){    
        $Model=new AmoLeadMod();
        $this->Lead=$Model->getLeadById($_POST['AmoLeadID']);
        $this->data=['Lead'=>$this->Lead];
        $this->ShowFile();
    }
    public function actionGetLeadList(){
        $Model=new AmoLeadMod();
        $this->LeadList=$_POST['AmoLeadList'];
        $this->data=['LeadList'=>$this->LeadList];
        $this->ShowFile();
    }
    public function actionGetContact(){        
        $this->Contact=$_POST['AmoContactID'];
        $this->data=['Contact'=>$this->Contact];
        $this->ShowFile();
    }
    public function actionGetContactList(){  
        $this->ContactList=$_POST['AmoContactList'];
        $this->data=['ContactList'=>$this->ContactList];
        $this->ShowFile();
    }
    
    public function actionGetPipelineList(){      
        $Model=new AmoStatusMod();
        $this->PipelineList=$Model->getPipelineList();
        $this->data=['PipelineList'=>$this->PipelineList];
        $this->ShowFile();
    }
    
    public function actionGetStatusList(){  
        $Model=new AmoStatusMod();
        $this->StatusList=$Model->getStatusList($_POST['AmoPipelineId']);
        $this->data=['StatusList'=>$this->StatusList];        
        $this->ShowFile();
    }
    
    //работа с тэгами
    public function actionAddTag(){
        (new AmoTagMod)->addTag($_GET['LeadId'],$_GET['TagName']);        
        $this->ShowFile();                
    }
    
    public function actionDelTag(){
        (new AmoTagMod)->dellTag($_GET['LeadId']);        
        $this->ShowFile();                
    }
    
    //работа со статусами
    public function actionAddCustomField(){
        (new amoTools)->addCustField('text',$_POST['AmoCFName'],'FIELD_MY_111');        
        $this->ShowFile();                
    }
    
    public function actionUpdCustomField(){
        (new amoTools)->updCustField(36591882,1678556,$_POST['AmoCFName']);
        $this->data=[$_POST];
        $this->ShowFile();                
    }
    
    public function actionDelCustomField(){
        #(new amoTools)->delCustField($_POST['AmoCFId']);
        $this->data=[$_POST['AmoCFId']];
        $this->ShowFile();        
        
    }
    
    public function actionCountLeads(){        
        $this->LeadList=(new amoTools)->getLeadsFiltList($_GET['AmoPipeLineId'],$_GET['AmoStatusId']);
        $this->data=['LeadList'=>$this->LeadList];
        
        $this->ShowFile();           
    }
    
    public function actionChangeStatus(){                
        $Lead=new amoLeads();        
        $Lead->setVar('amoLeadNewInfo',array(            
            "id" => $_GET['LeadId'],                                
            //поменять статус сделки на входящий статус воронки рекомендации
            "pipeline_id" => $_GET['PipelineId'],
            "status_id" => $_GET['StatusId']
        ));        
        $Lead->updateLead();                
        $this->data=[];
        #$this->data=(new AmoModel())->updLeadStatus($_GET['LeadId'],$_GET['PipelineId'],$_GET['StatusId']);
        #var_dump($this->data);
        #exit();
        $this->ShowFile();           
    }
    
    protected function ShowFile(){                
        $args=$this->data;
        $this->render('ATAmoFile',$args);        
    }
    
    
}
