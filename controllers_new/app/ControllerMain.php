<?php

abstract class ControllerMain {
    protected $action; //название метода (action) который выполняет контроллер
    protected $defaultAction='index';
    protected $templateRoot=WORK_FOLDER.'/views_new';
    protected $useLayout=true; //по умолчанию всё с лэйаутом
    protected $userLayout='layouts/MainLayout'; // по умолчанию обычный лэйаут
    protected $ViewName='NewView';
    
    //основной метод для каждого контроллера
    public function run() {
        //проверяем авторизацию, если её нет. то перекидываем на авторизацию. если есть - вытаскиваем имя пользователя        
        //запускаем нужный экшн
        //проверяем передан ли экшн
        //если не передан, то передаём дефолт экшн
        if (empty($this->action)){
            $this->action=$this->defaultAction;
        }
        //конструируем название экшна
        $method='action'.ucfirst($this->action);
        //если метода нет, то сообщаем об этом
        if (!method_exists($this, $method)){
            header('Location: ../error.php');
        }
        //вызываем выбранный метод
        if (isset($_SESSION['EmName'])){
            $EmName=$_SESSION['EmName'];
        }else{
            $EmName='Not authorized';
        }
        if (isset($_GET['ClCode'])){
            $ClCode=$_GET['ClCode'];
        }else{
            $ClCode=0;
        }
        (new logger('_action'))->logToFile($EmName." ran action ".$this->action." on Client ".$ClCode);
        $this->$method();
    }

    public function getAction($paramAc){
        $this->action=$paramAc;
        
    }
    
    protected function render($name,$args=[]){//метод загрузки общего щаблона () и отображения в нём конкретной view
        if ($this->useLayout){
            echo $this->renderTemplate($this->userLayout,[                
                'title'=> $this->ViewName, //заголовок открываемой страницы
                'content'=>$this->renderTemplate($name, $args) //контент открываемой страницы - название нужной вью и массив аргументов для неё
            ]);
        }else{
            echo $this->renderTemplate($name, $args);
        }
    }

    protected function renderTemplate($name, $args=[]){ //метод получает имя шаблона и аргументы для отображения       
        foreach($args as $key=>$arg){
            if($arg==[]){
                $arg==(new GetDataForView())->getData($key);
            }
        }
        
        extract($args); //переменная client1 не видна внутри этого метода (т.к. определена в другом методе)
            //поэтому при передаче client1 в функцию создаём массив с известным названием ключа, а функция extract
            //переменную с этим названием и передаст в неё значение переменной client
        $templatePath="{$_SERVER['DOCUMENT_ROOT']}/{$this->templateRoot}/{$name}.php"; //формируем полное имя шаблона
        ob_start();
        require $templatePath; //подключаем шаблон по имени и он сразу отображает тот HTML который в нём        
        return ob_get_clean();        
    }
    
    
}
