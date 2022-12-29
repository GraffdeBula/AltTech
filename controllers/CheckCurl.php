<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CheckCurl
 *
 * @author Andrey
 */
class CheckCurl extends Controller{
    
    public $ClName;
    public $Data;
    protected $MyDoc;

    protected $MyAuth;
    protected $MyResponse;
    protected $MySession;
    protected $MyStorage;
    protected $MyList;
    
    public function actionIndex(){ //метод по умолчанию
        $this->getSession();
        #$name=$_GET['doc'];
        $this->curlCopyDoc('исковое заявление '.$this->ClName);
        
        #$response=$this->curlDocList()->data;
        #foreach ($response as $doc){
        #    if ($doc->name==$name){
        #        var_dump($doc);
        #    }
            #echo("<br>+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++<br>");
        #}
        #$this->viewJson();
        $this->curlQuestionnaire();
    }
    //методы для обработки результатов
    protected function checkResponse(){
        
    }
    protected function getSession(){
        return $this->MySession=$this->curlAuth()->session;
    }
    //методы для работы с curl
    
    protected function actionSavePage(){
        $ch = curl_init("https://vse-obipoteke.ru/socialnaja_ipoteka_v_regionah/novosibirskaja_oblast/");
        $fp = fopen("downloads/example_homepage.txt", "w");

        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_exec($ch);
        if(curl_error($ch)) {
            fwrite($fp, curl_error($ch));
        }
        curl_close($ch);
        fclose($fp);            
    }
    
    protected function curlQuestionnaire(){ //Передача данных в анкету
        $data=array(
            "57"=>"5404494918"
            
  
        );
        
        $this->CurlParam = array(
            'session' => $this->MySession,
            'request' => 'ru.doczilla.requests.Questionnaire',
            'action' =>'content',
            'method' =>'set',
            'recordId' => $this->MyDoc->data[0]->recordId, //узнали документ 04052021B
            'data' => json_encode($this->Data)
        );		

        $this->link = curl_init('https://afpc24.doczilla.pro/request.json');
        $this->curlRequest();
    }
    
    protected function curlCopyDoc($name){        
        $data=array(
            'name'=>$name
        );
                
        $this->CurlParam = array(
            'session' => $this->MySession,
            'request' => 'ru.doczilla.document.storage.table.File',
            'action' => 'copy',
            'recordId' => '3B2A3454-64C3-4C5E-B1AD-121D1DB245C2',
            'data' => json_encode($data)
        );		
        $this->link = curl_init('https://afpc24.doczilla.pro/request.json');        
        return $this->MyDoc=$this->curlRequest();
    }
    protected function actionDocList(){ //пробуем получить документы                
        $this->curlAuth();
        $this->CurlParam = array(
            'session' => $this->MySession,
            'request' => 'ru.doczilla.document.storage.table.File',
            'action' => 'read',
            'fields' => json_encode(array(
                'recordId','name','shortName','createdBy','comment','type','folderId','folders'
            ))
        );		
        $this->link = curl_init('https://afpc24.doczilla.pro/request.json');        
        $this->MyList=$this->curlRequest();
        foreach ($this->MyList as $Doc) {
            var_dump($Doc);
            echo("<br>============================================================================");
        }
    }
    
    protected function curlUserList(){ //получаем список ПОЛЬЗОВАТЕЛЕЙ                
        $this->CurlParam = array(
            'session' => $this->MySession,
            'request' => 'ru.doczilla.user.tables.User',
            'action' => 'read',
            'fields' => json_encode(array(
                'recordId','name','shortName','createdBy','comment','textContent'
            ))
        );		
        $this->link = curl_init('https://afpc24.doczilla.pro/request.json');        
        return $this->MyList=$this->curlRequest();
    }
    
    protected function curlFileStorage(){ //работа                 
        $this->CurlParam = array(
            'session' => $this->MySession,
            'request' => 'ru.doczilla.document.storage.table.file',
            'method' =>'set',
            'version' => '',
            'contentType' => '',
            'type' => ''            
        );		
        $this->link = curl_init('https://afpc24.doczilla.pro/request.json');        
        return $this->MyStorage=$this->curlRequest();
    }
    
    
    protected function curlAuth(){ //авторизация
        $this->CurlParam = array(
            'login'    => 'adbulavskiy@gmail.com',
            'password' => md5('adbula$DZ21%'),
            'request' =>  'login'
        );		

        $this->link = curl_init('https://afpc24.doczilla.pro/request.json');
        return $this->MyAuth=$this->curlRequest();
    }
    
    protected function curlRequest(){ //авторизация       
        curl_setopt($this->link, CURLOPT_POST, 1);
        curl_setopt($this->link, CURLOPT_POSTFIELDS, $this->CurlParam); 
        curl_setopt($this->link, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->link, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->link, CURLOPT_HEADER, false);
        $Response = json_decode(curl_exec($this->link));
        curl_close($this->link);
        return $Response;
    }
        
}
