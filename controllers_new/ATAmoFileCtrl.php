<?php
/**
 * контроллер для работы с формой амоЦРМ
 *
 * функции
 * посмотреть лид по ID
 */
class ATAmoFileCtrl extends ControllerMain {
    protected $Data;
    protected $Lead;
    protected $Contact;
    protected $LeadList;
    protected $ContactList;
    protected $PipelineList;
    protected $StatusList;
    
    public function actionIndex(){
        $this->Data=[];
        $this->showFile();
    }
    
    public function actionGetLead(){
        $Lead=(new AmoLeadMod())->getLeadById($_GET['AmoLeadID']);
        
        $this->Data=['Lead'=>$Lead];
        $this->showFile();
    }
    
    public function actionGetLeadTags(){
        $Lead=(new AmoLeadMod())->getLeadById($_GET['AmoLeadID']);
        $Tags=$Lead['_embedded']['items'][0]['tags'];
        $TagsArr=[];
        foreach($Tags as $Arr => $Value){
            $TagsArr[]=$Value['name'];
        }
        
        $this->Data=['Tags'=>$TagsArr];
        $this->showFile();
    }    
            
    protected function showFile(){                
        $Args=$this->Data;
        $this->render('ATAmoFile',$Args);        
    }
    
}
