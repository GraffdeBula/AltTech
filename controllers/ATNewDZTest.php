<?php

/**
 * контроллер для тестирования АПИ ДокЗиллы
 *
 * @author Andrey
 */
class ATNewDZTest extends Controller{
    protected $Arg;
    
    protected $MyAuth;
    protected $MySession;
    protected $MyRequest;
    protected $MyDoc;
    
    protected $CurlParam;
    protected $CurlLink;
    
    public function actionIndex(){ //показ меню контроллера
        if (isset($this->Arg)){}
        else {
            $this->Arg=['List'=>[]];
        }
            
        $this->render('ATTestDZ',$this->Arg);
    }
    
    public function actionAuth(){
        $this->CurlAuth();
        $this->Arg=['List'=>[$this->MySession]];
        $this->actionIndex();
    }
    
    public function actionDocList(){
        $this->CurlAuth();
        $this->CurlLink=curl_init('https://afpc24.doczilla.pro/request.json');
        $this->CurlParam=[
            'session' => $this->MySession,
            'request' => 'ru.doczilla.workspace.table.Workspace',
            'action' => 'read',
            'fields' => json_encode(array(
                'recordId','name','shortName','createdBy','comment','type','folderId','folders'
            ))
        ];
        $this->MyRequest=$this->CurlRequest();
        $this->Arg=['List'=>$this->MyRequest->data];
        
        $this->actionIndex();
    }
   
    public function actionFolderList(){
        $this->CurlAuth();
        $this->CurlLink=curl_init('https://afpc24.doczilla.pro/request.json');

        $this->CurlParam=[
            'session' => $this->MySession,
            'request' => 'ru.doczilla.workspace.table.Workspace',
            'action' => 'read',
            'data' => json_encode([]),
            'filter' => json_encode([
                    'property' => 'isFolder',
                    'value' => 'true',
                    'operator' => 'eq'                
                
            ]),
            'fields' => json_encode(['name','folderId','createdBy',])
        ];

        $this->MyRequest=$this->CurlRequest();
        $this->Arg=['List'=>$this->MyRequest->data];

        $this->actionIndex();
    }
    
    public function actionReadDoc(){
        $this->CurlAuth();
        $this->CurlLink=curl_init('https://afpc24.doczilla.pro/request.json');

        $this->CurlParam=[
            'session' => $this->MySession,
            'request' => 'ru.doczilla.workspace.table.Workspace',
            'action' => 'read',
            'data' => json_encode([]),
            'filter' => json_encode([
                    'property' => 'folderId',
                    'value' => '6C7308C8-24E0-4B2A-BBA8-652AA0960CD6',
                    'operator' => 'eq'                
                
            ]),
            #'sort' => json_encode([]),
            'fields' => json_encode(['name','folderId','createdBy',])
        ];

        $this->MyRequest=$this->CurlRequest();
        $this->Arg=['List'=>$this->MyRequest->data];

        $this->actionIndex();
    }
    
    public function actionCreateDoc(){
        $this->CurlAuth();
        $this->CurlLink=curl_init('https://afpc24.doczilla.pro/request.json');

        $this->CurlParam=[
            'session' => $this->MySession,
            'request' => 'ru.doczilla.workspace.table.Workspace',
            'method' => 'create',
            'action' => 'content',
            'data' => json_encode([
                'name'=>'Мой Новый документ',
                'folderId'=>'6C7308C8-24E0-4B2A-BBA8-652AA0960CD6',
                'content'=>'это я'
            ])
            
        ];

        $this->MyRequest=$this->CurlRequest();
        $this->Arg=['List'=>$this->MyRequest];

        $this->actionIndex();
    }
    
    public function actionGetDoc(){ //ПРОВЕРКА
        $this->CurlAuth();
        $this->CurlLink=curl_init('https://afpc24.doczilla.pro/request.json');

        $this->CurlParam=[
            'request' => 'ru.doczilla.workspace.table.Workspace',
            'method' => 'get',
            'session' => $this->MySession,                                  
            'action' => 'content',
            'file' => $_GET['FileId'],
            'document' => $_GET['DocumentId'],
            'contentType' => 'dotx'            
        ];

        $this->MyRequest=$this->CurlRequest();
        $this->Arg=['List'=>[]];
        #(new MyCheck($this->MyRequest))->ShowCheck2();
        $this->actionIndex();
    }
    
    public function actionGetById(){ //РАБОТАЕТ!
        $this->CurlAuth();
        $this->CurlLink=curl_init('https://afpc24.doczilla.pro/request.json');

        $this->CurlParam=[
            'request' => 'ru.doczilla.workspace.table.Workspace',
            'method' => 'getById',
            'session' => $this->MySession,                                  
            'action' => 'content',
            'file' => $_GET['FileId'],            
        ];

        $this->MyRequest=$this->CurlRequest();
        $this->Arg=['List'=>$this->MyRequest];
        #(new MyCheck($this->MyRequest))->ShowCheck2();
        $this->actionIndex();
        
    }
    
    public function actionCopyDoc(){ //РАБОТАЕТ!!!
        $this->CurlAuth();
        $this->CurlLink=curl_init('https://afpc24.doczilla.pro/request.json');

        $this->CurlParam=[
            'session' => $this->MySession,
            #'session' =>'59D58A64-9F16-4672-90B9-FCC3475B15DE',
            'request' => 'ru.doczilla.workspace.table.Workspace',
            'method' => 'createDocz',
            'action' => 'content',
            'file' => 'FC6E07BF-0755-4027-A393-93F3D70F79B6',
            'folder'=>'6C7308C8-24E0-4B2A-BBA8-652AA0960CD6',
            'name'=>'Тест Анкеты'
        ];
        
        $Request=$this->CurlRequest();
        if ($Request->success==true){
            $this->MyDoc=$Request->data[0];
        } else {
             $this->MyDoc=$Request;
        }
        #var_dump($this->MyDoc);
        #$this->Arg=['List'=>$this->MyDoc];

        #$this->actionIndex();
    }
    
    public function actionFillDoc(){
        $this->actionCopyDoc();
        
        $this->CurlAuth();
        $this->CurlLink=curl_init('https://afpc24.doczilla.pro/request.json');

        $this->CurlParam=[
            'session' => $this->MySession,
            'request' => 'ru.doczilla.workspace.table.Workspace',
            'method' => 'fillDocz',
            'action' => 'content',
            'id' => $this->MyDoc->recordId,
            'dictionaryData'=>json_encode([   
                'data'=>json_encode([
                'ID1'=>'this is true',
                'ID2'=>'this is false',
                'ID3'=>'this is fiftien'        
            ])
                ]),
            
        ];

        $this->MyRequest=$this->CurlRequest();
        $this->Arg=['List'=>$this->MyRequest];

        $this->actionIndex();
    }
    
    protected function CurlAuth(){
        $this->CurlLink=curl_init('https://afpc24.doczilla.pro/request.json');
                
        $this->CurlParam=[
            'login'    => 'adbulavskiy@gmail.com',
            'password' => md5('adbula$DZ21%'),
            'request' =>  'login'
            #'login'    => 'admin@afpc24.ru',
            #'password' => md5('afpc$0908'),
            #'request' =>  'login'
        ];
        $this->MyAuth=$this->CurlRequest();
        $this->MySession=$this->MyAuth->session;
    }
    
    protected function CurlRequest(){        
        curl_setopt($this->CurlLink, CURLOPT_POST, 1);
        curl_setopt($this->CurlLink, CURLOPT_POSTFIELDS, $this->CurlParam); 
        curl_setopt($this->CurlLink, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->CurlLink, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->CurlLink, CURLOPT_HEADER, false);
        $Response = json_decode(curl_exec($this->CurlLink));
        curl_close($this->CurlLink);
        (new logger())->logToFile('REQUEST :: '.json_encode($this->CurlParam));
        (new logger())->logToFile('RESPONSE :: '.json_encode($Response));
        
        return $Response;
    }
    
        
   
    
}
