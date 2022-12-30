<?php

/**
 * api DocZilla
 *
 * @author Andrey
 */
class DZCtrl extends Controller{
    
    public $DocName;
    public $DocID;
    public $Data;
    protected $MyDoc;

    protected $CurlParam;
    protected $CurlLink;
    protected $MyAuth;
    protected $MyResponse;
    protected $MySession;
    protected $MyStorage;
    protected $MyList;
    
    public function actionIndex(){ //метод по умолчанию
        $this->getSession();        
        $this->curlCopyDoc(); 
        $this->curlFillAnketa();
    }

    //методы для обработки результатов
    protected function getSession(){
        return $this->MySession=$this->curlAuth()->session; 
    }
    //методы для работы с curl   
    protected function curlFillAnketa(){ //Передача данных в анкету
        $this->CurlLink=curl_init('https://afpc24.doczilla.pro/request.json');
        
        $this->CurlParam=[
            'session' => $this->MySession,
            'request' => 'ru.doczilla.workspace.table.Workspace',
            'method' => 'fillDocz',
            'action' => 'content',
            'id' => $this->MyDoc->recordId,
               
            'data'=>json_encode($this->Data)
        ];
        $this->CurlRequest();
    }
    
    protected function curlCopyDoc(){  //создание копии документа                              
        $this->CurlLink=curl_init('https://afpc24.doczilla.pro/request.json');

        $this->CurlParam=[
            'session' => $this->MySession,
            'request' => 'ru.doczilla.workspace.table.Workspace',
            'method' => 'createDocz',
            'action' => 'content',
            'file' => $this->DocID,
            'folder'=>'95ED3C8F-B6C2-3563-A250-78FB9F78F4C4',
            'name'=> $this->DocName
        ];   
                
        $this->MyDoc=$this->CurlRequest()->data[0];
    }
               
    protected function curlAuth(){ //авторизация
        $this->CurlParam = array(
            'login'    => 'admin@afpc24.ru',
            'password' => md5('afpc$0908'),
            'request' =>  'login'
        );		

        $this->CurlLink = curl_init('https://afpc24.doczilla.pro/request.json');
        return $this->MyAuth=$this->curlRequest();
    }
    
    protected function curlRequest(){ //curl запрос       
        (new logger())->logToFile(' REQUEST:: '.json_encode($this->CurlParam));
        curl_setopt($this->CurlLink, CURLOPT_POST, 1);
        curl_setopt($this->CurlLink, CURLOPT_POSTFIELDS, $this->CurlParam); 
        curl_setopt($this->CurlLink, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->CurlLink, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->CurlLink, CURLOPT_HEADER, false);
        $Response = json_decode(curl_exec($this->CurlLink));
        curl_close($this->CurlLink);
        (new logger())->logToFile(' RESPONSE:: '.json_encode($Response));
        return $Response;
    }
        
}
