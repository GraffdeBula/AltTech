<?php
/**
 * Модель для работы в АМО со статусами воронок
 * использует инструменты AmoTools0
 *
 * @author Andrey
 */
class AmoStatusMod {
    
    //получение списка воронок
    public function getPipelineList(){
        (new logger('log_amo'))->logToFile('AmoStatusMod: getPipelineList');
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink','https://fpcalternative.amocrm.ru/api/v4/leads/pipelines');
        $Amo->setVar('AmoMethod','GET');
        return $Amo->request();
    }
    
    //получение списка статусов в воронке (по ID)
    public function getStatusList($PipelineId){
        $Amo=new AmoRequests();
        $Amo->setVar('AmoLink',"https://fpcalternative.amocrm.ru//api/v4/leads/pipelines/{$PipelineId}/statuses");
        $Amo->setVar('AmoMethod','GET');
        return $Amo->request();
    }
}
