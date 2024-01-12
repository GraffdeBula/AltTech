<?php
/**
 * Description of amoTools
 *  AMO TOOLS для тестирования в интерфейсе AltTech
 * 
 */
class amoTools {
    protected $AmoLink='';
    protected $AmoHeader=false;
    protected $AmoData=[];
    protected $AmoMethod='PATCH';
    protected $user='';
    protected $lead=[];
    
    public function __construct() {
        $this->user=array(
            'USER_LOGIN'=>'adbulavskiy@gmail.com',
            'USER_HASH'=>'b37b351af8831e36a345926b8c2bb6fdd1d60ab7'
        );
        $this->amoAuth();
    }
        
    public function getLeadById($LeadID=''){       
        //Формируем ссылку для запроса
        $this->AmoLink="https://fpcalternative.amocrm.ru/api/v2/leads/?id={$LeadID}";
        $this->AmoHeader=false;
        $this->AmoMethod='GET';
        $lead=$this->Request();
        return $lead;
    }
    
    public function updLead($LeadID,$NewInfo=[]){
        $this->AmoLink="https://fpcalternative.amocrm.ru/api/v4/leads/{$LeadID}";
        $this->AmoHeader=array('Content-Type: application/json');
        $this->AmoMethod='PATCH';
        $this->AmoData= json_encode($NewInfo);
        
        #var_dump($this->Request());
        #exit();
        return $this->Request();
    }
    
    public function delCustField($CustFieldID){
        $this->AmoLink="https://fpcalternative.amocrm.ru/api/v4/leads/custom_fields/{$CustFieldID}";
        $this->AmoHeader=array('Content-Type: application/json');
        $this->AmoMethod='DELETE';
        $this->AmoData= json_encode([]);
        return $this->Request();
    }
    
    public function addCustField($Type,$Name,$Code){
        $this->AmoLink="https://fpcalternative.amocrm.ru/api/v4/leads/custom_fields";
        $this->AmoHeader=array('Content-Type: application/json');
        $this->AmoMethod='POST';
        $this->AmoData=[
            'type'=>$Type,
            'name'=>$Name,
            'code'=>$Code
        ];
        return $this->Request();
    }
    
    public function updCustField($LeadID,$FieldID,$FieldValue){
        $this->AmoLink="https://fpcalternative.amocrm.ru/api/v4/leads/{$LeadID}";
        $this->AmoHeader=array('Content-Type: application/json');
        $this->AmoMethod='PATCH';
        $this->AmoData=json_encode([
            'custom_fields_values'=>[
                [   
                    'field_id'=>$FieldID,
                
                    'values'=>[
                        'values'=>['value'=>$FieldValue]
                    ]
                ]
            ]    
        ]);

        return $this->Request();
    }
    
    public function addPromo($LeadID,$Promo){
        $this->AmoLink="https://fpcalternative.amocrm.ru/api/v4/leads/{$LeadID}";        
                
        $this->AmoHeader=array('Content-Type: application/json');
        $this->AmoData=json_encode(
            array(
                "id" => $LeadID,
                "name" => 'new lead name3',
                "custom_fields_values" => [
                    "id" => '1672870'
                    #"code" => 'NASELENNII_PUNKT_POSTOYANNOI_REGISTRATSII_KAK_V_PASPORTE'
                #    "values" => [
                #        "value" => 'Барабинск'
                #    ]
                ]
            )
        );
        
//        $this->AmoData=json_encode( c этим масивом обновлялось название сделки
//            array(
//                "id" => $LeadID,
//                "name" => 'new lead name7',
//                "custom_fields" => [
//                    "custom_fields_values"=>[
//                        "field_id"=>1672870,
//                        "field_type"=>9,
//                        "enum_id"=>null,
//                        "text"=>"Барабинск"
//                    ]
//                ]
//            )
//        );
        
        $this->AmoMethod='PATCH';
        return $this->Request();        
    }
    
    public function addTag($LeadID,$TagName){  #перенёс
        $this->AmoLink="https://fpcalternative.amocrm.ru/api/v4/leads/{$LeadID}";
                
        $this->AmoHeader=array('Content-Type: application/json');
        // работающий массив на изменение сделок
        /*
        $this->AmoData=json_encode(
            array(
                "id" => $LeadID,
                "name" => 'NewLead26102021-type2',
                "responsible_user_id" => 139752
            )
        );
         * 
         */
        //работающий массив на удаление тэгов
        /*
        $this->AmoData=json_encode(
            array(
                
                "_embedded" => array (
                    "tags" => null
                )
            )
        );        
         */
        //работающий массив на добавление тэгов
        $this->AmoData= json_encode(
                array(
                    "_embedded" => array(
                        "tags" => array(
                            array(
                                "name" => $TagName,
                                )                                    
                        )
                    )
                )
        );
        
        $this->AmoMethod='PATCH';
        return $this->Request();
    }
    
    public function getTagList(){ #перенёс
        $this->AmoLink='https://fpcalternative.amocrm.ru/api/v4/leads/tags?page=1&limit=250';
        $this->AmoMethod='GET';
        return $this->Request();
    }
    
    public function getPipelineList(){ #перенёс
        $this->AmoLink='https://fpcalternative.amocrm.ru/api/v4/leads/pipelines';
        $this->AmoMethod='GET';
        return $this->Request();
    }
     
    public function getStatusList($PipelineId){ #перенёс
        $this->AmoLink="https://fpcalternative.amocrm.ru//api/v4/leads/pipelines/{$PipelineId}/statuses";
        $this->AmoMethod='GET';
        return $this->Request();
    }
    
    public function getLeadsFiltList($PipeLineId,$StatusId){
        $this->AmoLink="https://fpcalternative.amocrm.ru/api/v4/leads?filter[statuses][0][pipeline_id]={$PipeLineId}&filter[statuses][0][status_id]={$StatusId}";
        $this->AmoMethod='GET';
        return $this->Request();
    }
    
    protected function amoAuth(){
        $this->AmoLink='https://fpcalternative.amocrm.ru/private/api/auth.php?type=json';
        //Сохраняем дескриптор сеанса cURL
        $curl=curl_init(); 
        //Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($curl,CURLOPT_URL,$this->AmoLink);
        curl_setopt($curl,CURLOPT_POST,true);
        curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($this->user));
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
        //Инициируем запрос к API и сохраняем ответ в переменную
        $out=curl_exec($curl); 
        //Получим HTTP-код ответа сервера
        $code=curl_getinfo($curl,CURLINFO_HTTP_CODE); 
        //Завершаем сеанс cURL
        curl_close($curl); 
        $Response=json_decode($out,true);    
        (new logger())->logToFile(json_encode($Response));
        return $Response;
    }
    
    protected function Request(){
        $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
        //Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($curl,CURLOPT_URL,$this->AmoLink);            
        curl_setopt($curl,CURLOPT_HEADER, $this->AmoHeader);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$this->AmoData);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,$this->AmoMethod);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); 
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); 
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
        $out=curl_exec($curl);
        curl_close($curl);
        $Response=json_decode($out,true);
        (new logger())->logToFile(json_encode($Response));
        return $Response;
    }
    
}
