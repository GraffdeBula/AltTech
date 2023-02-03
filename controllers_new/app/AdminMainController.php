<?php
/**
 * Основной админский контроллер
 * Запускается из index_admin, проверяет какой контроллер передан и какой экшн передан
 * Если контроллер не передан, то запускает $DefaultCtrl (контроллер меню)
 * можно замену начать как раз с обработки контроллера меню. заменить его на контроллер главной формы. 
 * логика: если никакой контроллер не передан, то переходим на главную форму.

 * @author Andrey

*echo("<br> GET: ");
*var_dump($_GET);
*echo("<br> POST: ");
*var_dump($_POST);
*/
class AdminMainController extends ControllerMain{    
    protected $MyCtrl=FALSE;
    protected $DefaultCtrl='ATMainFormCtrl';
    protected $MyAction;
    
    public function actionIndex(){        
        if ($this->getController()){
            if ($this->getMyAction()){
                $newCtrl=new $this->MyCtrl();
                $newCtrl->getAction($this->MyAction);
                $newCtrl->run();                
            }else {                
                (new $this->MyCtrl)->run();
            }
        } 
    }
          
    public function getController(){
        if (isset($_GET['controller'])){
            $this->MyCtrl=$_GET['controller'];            
        } elseif (isset($_POST['controller'])){
            $this->MyCtrl=$_POST['controller'];            
        } else {
            $this->MyCtrl=$this->DefaultCtrl;
        }        
        return $this->MyCtrl;
    }

    public function getMyAction(){
        if (isset($_GET['action'])){
            $this->MyAction=$_GET['action'];            
        } else {
            if (isset($_POST['action'])){
            $this->MyAction=$_POST['action'];            
            }
        }
        
        return $this->MyAction;
    }
    
    
}
