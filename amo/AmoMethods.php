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
        (new logger('log_amo'))->logToFile('AmoMethods: getLeadById');
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink',"https://fpcalternative.amocrm.ru/api/v2/leads/?id={$LeadId}");
        $Amo->setVar('AmoHeader',false);
        $Amo->setVar('AmoMethod','GET');        
        if (isset($Amo->request()['_embedded']['items'][0])){
        return $Amo->request()['_embedded']['items'][0];
        }else{
            return [];
        }
    }
    
    public function getPipelineList(){
        (new logger('log_amo'))->logToFile('AmoMethods: getPipelineList');
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink','https://fpcalternative.amocrm.ru/api/v4/leads/pipelines');
        $Amo->setVar('AmoMethod','GET');
        return $Amo->request()['_embedded']['pipelines'];
    }
    
    public function getLeadList($strParam){
        (new logger('log_amo'))->logToFile('AmoMethods: getLeadList');
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink',$strParam);
        $Amo->setVar('AmoHeader',false);
        $Amo->setVar('AmoMethod','GET');
        return $Amo->request()['_embedded']['items'];
    } 
    
    public function getContact($ContId){
        (new logger('log_amo'))->logToFile('AmoMethods: getContactById');
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink',"https://fpcalternative.amocrm.ru/api/v2/contacts/?id={$ContId}");
        $Amo->setVar('AmoHeader',false);
        $Amo->setVar('AmoMethod','GET');
        if (isset($Amo->request()['_embedded']['items'][0])){
            return $Amo->request()['_embedded']['items'][0];
        }else{
            return [];
        }
    }
    
    public function getContactList($ContId){
        (new logger('log_amo'))->logToFile('AmoMethods: getContactList');
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink',"");
        $Amo->setVar('AmoHeader',false);
        $Amo->setVar('AmoMethod','GET');
        return $Amo->request()['_embedded']['items'][0];
    }
}
