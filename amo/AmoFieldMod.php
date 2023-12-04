<?php
/**
 * Модель для работы в АМО со статусами воронок
 * использует инструменты AmoTools0
 *
 * @author Andrey
 */
class AmoFieldMod {
    public function delCustField($CustFieldID){
        $Amo=new AmoTools0();
        $Amo->setVar('AmoLink',"https://fpcalternative.amocrm.ru/api/v4/leads/custom_fields/{$CustFieldID}");
        $Amo->setVar('AmoHeader',array('Content-Type: application/json'));
        $Amo->setVar('AmoMethod','DELETE');
        $Amo->setVar('AmoData', json_encode([]));
        return $Amo->request();
    }
    
    public function addCustField($Type,$Name,$Code){
        $Amo=new AmoTools0();
        $Amo->setVar('AmoLink',"https://fpcalternative.amocrm.ru/api/v4/leads/custom_fields");
        $Amo->setVar('AmoHeader',array('Content-Type: application/json'));
        $Amo->setVar('AmoMethod','POST');
        $Amo->setVar('AmoData',[
            'type'=>$Type,
            'name'=>$Name,
            'code'=>$Code
        ]);
        return $Amo->request();
    }
    
    public function updCustField($LeadID,$FieldID,$FieldValue){
        $Amo=new AmoTools0();
        $Amo->setVar('AmoLink',"https://fpcalternative.amocrm.ru/api/v4/leads/{$LeadID}");
        $Amo->setVar('AmoHeader',array('Content-Type: application/json'));
        $Amo->setVar('AmoMethod','PATCH');
        $Amo->setVar('AmoData',json_encode([
            'custom_fields_values'=>[
                [   
                    'field_id'=>$FieldID,                
                    'values'=>[
                        'values'=>['value'=>$FieldValue]
                    ]
                ]
            ]    
        ]));

        return $Amo->request();
    }
   
}
