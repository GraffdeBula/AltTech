<?php
/**
 * Description of amoTools
 *  AMO TOOLS для тестирования в интерфейсе AltTech
 * 
 */
class AmoRequests{
    protected $AmoLink='';
    protected $AmoHeader=false;
    protected $AmoData=[];
    protected $AmoMethod='GET';
    protected $User='';
    
    public function __construct() {
        $this->User=array(
            'USER_LOGIN'=>'adbulavskiy@gmail.com',
            'USER_HASH'=>'b37b351af8831e36a345926b8c2bb6fdd1d60ab7'
        );
        #$this->amoAuth();
    }
    
    public function setVar($Name,$Value){
        $this->{$Name}=$Value;
    }
    
    protected function amoAuth(){
        $this->AmoLink='https://fpcalternative.amocrm.ru/private/api/auth.php?type=json';
        //Сохраняем дескриптор сеанса cURL
        $Curl=curl_init();
        //Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($Curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($Curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($Curl,CURLOPT_URL,$this->AmoLink);
        curl_setopt($Curl,CURLOPT_POST,true);
        curl_setopt($Curl,CURLOPT_POSTFIELDS,http_build_query($this->User));
        curl_setopt($Curl,CURLOPT_HEADER,false);
        curl_setopt($Curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt');
        curl_setopt($Curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt');
        curl_setopt($Curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($Curl,CURLOPT_SSL_VERIFYHOST,0);
        //Инициируем запрос к API и сохраняем ответ в переменную
        $Out=curl_exec($Curl);
        //Получим HTTP-код ответа сервера
        $Code=curl_getinfo($Curl,CURLINFO_HTTP_CODE);
        //Завершаем сеанс cURL
        curl_close($Curl);
        $Response=json_decode($Out,true);            
        return $Response;
    }
    
    public function request(){
        $this->amoAuth();
        
        $Curl=curl_init(); #Сохраняем дескриптор сеанса cURL
        //Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($Curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($Curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($Curl,CURLOPT_URL,$this->AmoLink);            
        curl_setopt($Curl,CURLOPT_HEADER, $this->AmoHeader);
        curl_setopt($Curl,CURLOPT_POSTFIELDS,$this->AmoData);
        curl_setopt($Curl,CURLOPT_CUSTOMREQUEST,$this->AmoMethod);
        curl_setopt($Curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); 
        curl_setopt($Curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); 
        curl_setopt($Curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($Curl,CURLOPT_SSL_VERIFYHOST,0);
        $Out=curl_exec($Curl);
        curl_close($Curl);
        $Response=json_decode($Out,true);
        (new logger())->logToFile(json_encode($Response));
        return $Response;
    }
    
}
