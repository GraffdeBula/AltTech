<?php
/**
 * Модель для работы в АМО со статусами воронок
 * использует инструменты AmoRequests
 *
 * @author Andrey
 */
class AmoTagMod {
    
    public function getTagList(){
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink','https://fpcalternative.amocrm.ru/api/v4/leads/tags?page=1&limit=250');
        $Amo->setVar('AmoMethod','GET');
        return $Amo->request();
    }
    
    public function addTag($LeadID,$TagName){
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink',"https://fpcalternative.amocrm.ru/api/v4/leads/{$LeadID}");                
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
    
    public function dellTag($LeadID){
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink',"https://fpcalternative.amocrm.ru/api/v4/leads/{$LeadID}");                
        $Amo->setVar('AmoHeader',array('Content-Type: application/json'));
        $Amo->setVar('AmoMethod','PATCH');
        $Amo->setVar('AmoData',json_encode(
            array(
                "_embedded" => array (
                    "tags" => null
        ))));   
        
        return $Amo->request();
    }
    
}
