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
    
    public function getStatuses(){
        $Amo=new AmoRequests2();
        $Amo->setVar('AmoLink', 'https://fpcalternative.amocrm.ru/private/api/v4/leads/pipelines');
        $Amo->setVar('AmoHeader', false);
        $Amo->setVar('AmoMethod', 'GET');
        $Amo->setVar('AmoData', []);
        return $Amo->request();
    }
}
