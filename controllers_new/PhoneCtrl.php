<?php
/**
 * контроллер для тестирования АПИ телефонии
 *
 * @author Andrey
 */
class PhoneCtrl extends ControllerMain{
    
    public $Phone=[''];
    #protected $PhoneUrl='https://afpc.finenumbers.cloud/sys/crm_api.wcgp';
    #protected $PhoneTocken='bcdc62ae-ae23-4636-9176-a4e8f16299cf';
    protected $PhoneUrl='https://cloudpbx.beeline.ru/apis/portal';
    protected $PhoneTocken='29c78105-5637-46d1-af59-d6f0a0d6498f';
    protected $CurlLink;
    protected $CurlParam=[];
    
    public function actionIndex(){
        $this->ViewName='Phone View';
        $this->render('Phone',['Phone'=>$this->Phone]);
    }
    
    public function actionAuth(){
        
//        $this->CurlParam=[
//            'cmd'=>'accounts',
//            'token'=>$this->PhoneTocken
//        ];
        $this->CurlLink = curl_init($this->PhoneUrl.'/');
        $this->Phone=$this->curlRequest2();
        
        $this->actionIndex();
    }
    
    public function actionCall(){
        $this->CurlParam=[
            'cmd'=>'makeCall',
            'user'=>'administrator',
            'phone'=>$_GET['Phone'],
            'token'=>$this->PhoneTocken
        ];
        $this->CurlLink = curl_init($this->PhoneUrl);
        $this->Phone=$this->curlRequest();
        
        $this->actionIndex();        
    }
        
    protected function curlRequest(){ //curl запрос       
        #(new logger())->logToFile(' REQUEST:: '.json_encode($this->CurlParam));
        curl_setopt($this->CurlLink, CURLOPT_POST, 1);
        curl_setopt($this->CurlLink, CURLOPT_POSTFIELDS, $this->CurlParam); 
        curl_setopt($this->CurlLink, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->CurlLink, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->CurlLink, CURLOPT_HEADER, false);
        $Response = json_decode(curl_exec($this->CurlLink));
        curl_close($this->CurlLink);
        #(new logger())->logToFile(' RESPONSE:: '.json_encode($Response));
        return $Response;
    }
    
    protected function curlRequest2(){ //curl запрос       
        
        curl_setopt($this->CurlLink, CURLOPT_POST, 1);
        curl_setopt($this->CurlLink, CURLOPT_POSTFIELDS, $this->CurlParam); 
        curl_setopt($this->CurlLink, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->CurlLink, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->CurlLink, CURLOPT_HEADER, $this->PhoneTocken);
        $Response = json_decode(curl_exec($this->CurlLink));
        curl_close($this->CurlLink);
        return $Response;
    }
        
}