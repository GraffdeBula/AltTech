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
    
    public function addTag(){
        $this->AmoData=[
            
            
        ];        
        
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink', "https://fpcalternative.amocrm.ru/api/v4/leads/{$this->LeadID}");
        $Amo->setVar('AmoHeader', array('Content-Type: application/json'));
        $Amo->setVar('AmoMethod', 'PATCH');
        $Amo->setVar('AmoData', $this->AmoData);
                                        
        $Amo->request();
    } 
}
