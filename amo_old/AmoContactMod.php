<?php
/**
 * Модель для работы в АМО со сделками
 * использует инструменты AmoTools0
 *
 * @author Andrey
 */
class AmoContactMod {
    
    
    public function getContactById($ContactID=''){       
        $Amo=new AmoTools0();
        $Amo->setVar('AmoLink',"https://fpcalternative.amocrm.ru/api/v2/contacts/?id={$ContactID}");
        $Amo->setVar('AmoHeader',false);
        $Amo->setVar('AmoMethod','GET');
        return $Amo->request();        
    }
    
    
}
