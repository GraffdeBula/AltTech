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
            
    public function getLeadList($strParam){
        (new logger('log_amo'))->logToFile('AmoMethods: getLeadList');
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink',$strParam);
        $Amo->setVar('AmoHeader',false);
        $Amo->setVar('AmoMethod','GET');
        return $Amo->request()['_embedded']['items'];
    } 
    
    public function addLead($LeadName,$ContId,$City,$Agent){
        $Data=json_encode(
            array (array(
                "name" => $LeadName,
                "price" => 0,
                "_embedded" => array(                
                    "contacts" => array(
                        array(
                            "id" => $ContId
                        )
                    )
                ),
                "custom_fields_values" => array(
                    array(
                        "field_id" => 1672870,
                        "values" => array (
                            array(
                                "value"=>$City
                            )
                        )
                    ),
                    array(
                        "field_id" => 1680040,
                        "values" => array (
                            array(
                                "value"=>$Agent
                            )
                        )
                    )
                )
                                    
        )));
                
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink','https://fpcalternative.amocrm.ru/api/v4/leads');
        $Amo->setVar('AmoHeader','application/json');
        $Amo->setVar('AmoMethod','POST');
        $Amo->setVar('AmoData',$Data);
        return $Amo->request();
    }
    
    public function addTagToLead($TagName,$LeadId){
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink',"https://fpcalternative.amocrm.ru/api/v4/leads/{$LeadId}");                
        $Amo->setVar('AmoHeader',array('Content-Type: application/json'));
        $Amo->setVar('AmoMethod','PATCH');

        $Amo->setVar('AmoData',json_encode(
            array(
                "_embedded" => array(
                    "tags" => array(
                        array(
                            "name" => $TagName,
        ))))));
                                
        return $Amo->request();
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
    
    public function addContact($Name,$Phone){
        $Data=json_encode(
            array (array(
                "name" => $Name,  
                "custom_fields_values" => array(
                    array(
                        "field_id" => 646794,
                        "field_name" => "Телефон",
                        "values" => array (
                            array(
                                "value"=>$Phone
                            )
                        )
                    )
                )
        )));
                
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink','https://fpcalternative.amocrm.ru/api/v4/contacts');
        $Amo->setVar('AmoHeader','application/json');
        $Amo->setVar('AmoMethod','POST');
        $Amo->setVar('AmoData',$Data);
        return $Amo->request();
    }
    
    public function getUsers(){
        (new logger('log_amo'))->logToFile('AmoMethods: getUsers');
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink',"https://fpcalternative.amocrm.ru/api/v4/users");
        $Amo->setVar('AmoHeader',false);
        $Amo->setVar('AmoMethod','GET');
        return $Amo->request()['_embedded']['users'];
    }
    
    public function getPipelineList(){
        (new logger('log_amo'))->logToFile('AmoMethods: getPipelineList');
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink','https://fpcalternative.amocrm.ru/api/v4/leads/pipelines');
        $Amo->setVar('AmoMethod','GET');
        return $Amo->request()['_embedded']['pipelines'];
    }
}
