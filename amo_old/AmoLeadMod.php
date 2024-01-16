<?php
/**
 * Модель для работы в АМО со сделками
 * использует инструменты AmoTools0
 *
 * @author Andrey
 */
class AmoLeadMod {
    
    public function getLeadsFiltList($PipeLineId,$StatusId){
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink',"https://fpcalternative.amocrm.ru/api/v4/leads?filter[statuses][0][pipeline_id]={$PipeLineId}&filter[statuses][0][status_id]={$StatusId}");
        $Amo->setVar('AmoMethod','GET');
        return $Amo->request();
    }
    
    public function getLeadById($LeadID=''){       
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink',"https://fpcalternative.amocrm.ru/api/v2/leads/?id={$LeadID}");
        $Amo->setVar('AmoHeader',false);
        $Amo->setVar('AmoMethod','GET');
        return $Amo->request();        
    }
    
    public function getLeadFromPost(){       
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink',"https://fpcalternative.amocrm.ru/api/v2/leads/?id={$LeadID}");
        $Amo->setVar('AmoHeader',false);
        $Amo->setVar('AmoMethod','GET');
        return $Amo->request();        
    }
    
    public function updLead($LeadID,$NewInfo=[]){
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink',"https://fpcalternative.amocrm.ru/api/v4/leads/{$LeadID}");
        $Amo->setVar('AmoHeader',array('Content-Type: application/json'));
        $Amo->setVar('AmoMethod','PATCH');
        $Amo->setVar('AmoData',json_encode($NewInfo));
        return $Amo->request();
    }
}
