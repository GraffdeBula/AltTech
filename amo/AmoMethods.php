<?php

/**
 * Description of amoMethods
 *
 * @author Andrey
 */
class AmoMethods {
    protected $AmoLink='';
    protected $AmoHeader=false;
    protected $AmoData=[];
    protected $AmoMethod='PATCH';
    
    public function getLeadById($LeadId){
        $Amo=new AmoRequests();
        
        $Amo->setVar('AmoLink',"https://fpcalternative.amocrm.ru/api/v2/leads/?id={$LeadId}");
        $Amo->setVar('AmoHeader',false);
        $Amo->setVar('AmoMethod','GET');
        $Amo->setVar('AmoData', []);
        return $Amo->request();
    }
    
    public function getContactById($ContactId){
        $Amo=new AmoRequests();
        
        $Amo->setVar('AmoLink',"https://fpcalternative.amocrm.ru/api/v2/contacts/?id={$ContactId}");
        $Amo->setVar('AmoHeader',false);
        $Amo->setVar('AmoMethod','GET');
        $Amo->setVar('AmoData', []);
        return $Amo->request();
    }    
    
    public function addTag($NewTagsArr,$LeadId){    
        (new logger())->logToFile('метод эдд тэг');
        $NewTags=[];
        foreach($NewTagsArr as $Key=>$TagName){
            $NewTags[]=['name'=>$TagName];
        }
                
        $this->AmoData=json_encode(
            array(
                "_embedded" => array(
                    "tags" => $NewTags
        )));
        
        (new logger())->logToFile($this->AmoData);
                        
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink', "https://fpcalternative.amocrm.ru/api/v4/leads/{$LeadId}");
        $Amo->setVar('AmoHeader', array('Content-Type: application/json'));
        $Amo->setVar('AmoMethod', 'PATCH');
        $Amo->setVar('AmoData', $this->AmoData);
                                        
        $Amo->request();
    } 
    
    public function getPipeLineList(){
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink', 'https://fpcalternative.amocrm.ru/api/v4/leads/pipelines');
        $Amo->setVar('AmoHeader', array('Content-Type: application/json'));
        $Amo->setVar('AmoMethod', 'GET');
        $Amo->setVar('AmoData', []);
        return $Amo->request();
    }
}
