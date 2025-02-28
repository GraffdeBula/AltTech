<?php

/**
 * Description of amoMethods
 *
 * @author Andrey
 */
class AmoMethods2 {
    protected $AmoLink='';
    protected $AmoHeader=false;
    protected $AmoData=[];
    protected $AmoMethod='PATCH';
    
    public function getAuth(){
        $Amo=new AmoRequests2();
        return $Amo->getAuth();
    }
    
    public function getLeadId($LeadId){
        $Amo=new AmoRequests2();
        $Amo->setVar('AmoLink', 'https://fpcalternative.amocrm.ru/api/v4/leads/'.$LeadId);
        $Amo->setVar('AmoHeader', false);
        $Amo->setVar('AmoMethod', 'GET');
        $Amo->setVar('AmoData', []);
        return $Amo->request();
    }
    
    public function getStatuses(){
        $Amo=new AmoRequests2();
        $Amo->setVar('AmoLink', 'https://fpcalternative.amocrm.ru/api/v4/leads/pipelines');
        $Amo->setVar('AmoHeader', false);
        $Amo->setVar('AmoMethod', 'GET');
        $Amo->setVar('AmoData', []);
        return $Amo->request()['_embedded']['pipelines'];
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
        $Amo=new AmoRequests2();
        $Amo->setVar('AmoLink','https://fpcalternative.amocrm.ru/api/v4/contacts');
        $Amo->setVar('AmoHeader','application/json');
        $Amo->setVar('AmoMethod','POST');
        $Amo->setVar('AmoData',$Data);
        return $Amo->request();        
    }
    
    public function updLeadCustomFields($LeadId,$FieldsArr){
        $CustomFields=[];
        foreach($FieldsArr as $Field=>$Value){
            $CustomFields[]=array(
                "field_id" => $Field,
                "values" => array (
                    array(
                        "value"=>"".$Value
                    )
                )
            );
                    
        }
        
        $Data=json_encode(
            array (                                               
                "custom_fields_values" => $CustomFields                
        ));
        $Amo=new AmoRequests2();
        $Amo->setVar('AmoLink','https://fpcalternative.amocrm.ru/api/v4/leads/'.$LeadId);
        $Amo->setVar('AmoHeader','application/json');
        $Amo->setVar('AmoMethod','PATCH');
        $Amo->setVar('AmoData',$Data);
        #new MyCheck($Amo->request(),0);
        return $Amo->request();
        
    }
    
    public function addLead($ContId,$LeadName,$City,$Agent){
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
                
        $Amo=new AmoRequests2();
        $Amo->setVar('AmoLink','https://fpcalternative.amocrm.ru/api/v4/leads');
        $Amo->setVar('AmoHeader','application/json');
        $Amo->setVar('AmoMethod','POST');
        $Amo->setVar('AmoData',$Data);
        return $Amo->request();
    }
    
    public function addTagToLead($TagName,$LeadId){
        $Amo=new AmoRequests2();
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
}
