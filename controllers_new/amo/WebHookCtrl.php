<?php
/**
 * класс для работы с вебхуками, пришедшими из амо
 *
 * @author Andrey
 */
class WebHookCtrl extends Controller{
    protected $LeadId;
    
    public function actionIndex(){

    }
          
    public function actionNewLead(){                
        /*вызвать смену тэга(рекомендация)
         * вызвать смену статуса (в рекомендации--заявка)
         * вызвать запись доп поля (код агента)
         */
        
        $Tag=new AmoTagMod();        
        $Lead->amoLead=$Amo->getLeadById($this->getId());            
        $Lead->getName();
        
        if ($Lead->checkName("utm_term=promo")){                
            $Lead->addTag('#рекомендация');
                        
            $Lead->setVar('amoLeadNewInfo',array(            
                "id" => $Lead->amoLeadId,                                
                //поменять статус сделки на входящий статус воронки соцсети
                "pipeline_id" => 532045,
                "status_id" => 14321041
                //записать код агена в поле "Промокод"
//                
            ));
            $Lead->updateLead();
            $Lead->setVar('amoLeadNewInfo',array(            
                'id' => $Lead->amoLeadId,                                
                'custom_fields_values'=>[
                [   
                    'field_id'=>1678544,
                
                    'values'=>[
                        'values'=>['value'=>$this->getKode($Lead->amoLeadName)]
                    ]
                ]
                ]
            ));    
            $Lead->updateLead();
        }
    }
            
    protected function getId(){
        $myArray=json_encode($_POST['leads']['add']);        
        $mySubStr1=explode('","',$myArray,2);        
        $mySubStr2=explode('":"',$mySubStr1[0],2);            
        return $this->LeadId=$mySubStr2[1];          
    }
    
    protected function getKode($Name){//получить код агента из ссылки
        $pos=strpos($Name,'kod=AGENT');
        $kode= substr($Name,$pos+4,9);
        (new logger)->logToFile($kode);
        return $kode;
    }
    
    public function actionIfPeter(){ //какой-то экшн для питера. не используется
        $Amo=new amoTools;                       
        $Lead=new amoLeads();        
        $Lead->amoLead=$Amo->getLeadById($this->getId());            
        $Lead->getName();
        if ($Lead->checkName("spb.fpk-alternativa.ru")){                
            $Lead->addTag('#с-петербург');
        }
    }
    
    
}
