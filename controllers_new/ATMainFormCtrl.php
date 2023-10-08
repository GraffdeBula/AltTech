<?php
/**
 * контроллер управления главной формой
 *
 * функции
 * 
 */
class ATMainFormCtrl extends ControllerMain {
    protected $Params=[];
    protected $ClList=[];
    protected $Refers=[];
    protected $ExpList=[];
    
    
    public function actionIndex(){
        $this->Params=[];
        $this->LoadList();                
        $this->GetEmpWorkData();
        $this->GetRefers();       
        $this->getExpList();
        $this->ShowList();
    }
    
    /* выход из системы
     */
    public function actionExit(){
        $sessName='PHPSESSID';
	setcookie($sessName,'',time()-1,'/');
        header('Location: index_admin.php');
    }
    /* поиск клиента
     */
    public function actionClSearch(){
        $this->Params=[ucfirst($_GET['ClFName']),ucfirst($_GET['Cl1Name']),ucfirst($_GET['Cl2Name']),$_GET['ClPasSer'],$_GET['ClPasNum']];
        $this->LoadList();
        $this->GetEmpWorkData();
        $this->GetRefers();       
        $this->getExpList();
        $this->ShowList();
    }
    /* добавление клиента
     */
    public function actionClIns(){
        $Model=new ATClientMod();        
        $Model->NewClient($_GET['ClFName'],$_GET['Cl1Name'],$_GET['Cl2Name'],$_GET['ClPasSer'],$_GET['ClPasNum'],$_SESSION['EmName'],$_SESSION['EmBranch']);
        header("Location: index_admin.php?controller=ATMainFormCtrl&action=ClSearch"
            . "&ClFName={$_GET['ClFName']}&Cl1Name={$_GET['Cl1Name']}&Cl2Name={$_GET['Cl2Name']}&ClPasSer={$_GET['ClPasSer']}&ClPasNum={$_GET['ClPasNum']}");
    }
    /* удаление клиента
     */        
    public function actionClDel(){
        $Model=new ATClientMod();
        $Model->delClient($_GET['ClCode']);
        header("Location: index_admin.php?controller=ATMainFormCtrl");
    }
                    
    /* загрузка формы
     */   
    protected function ShowList(){       
        $this->ViewName='Главная форма';
        $args=['ClList'=>$this->ClList,'Refers'=>$this->Refers,'ExpList'=>$this->ExpList];        
        $this->render('ATMainForm',$args);
    }
    
    /*получение данных по пользователю и запись их в сессию для отображения
     */
    protected function GetEmpWorkData(){
        $Model=new ATEmployeeMod();  
        if (!$Model->GetEmpWorkData()){
            echo('Ошибка БД: неверно записан пароль');                        
            exit();
        } 
                
        $_SESSION['EmBranch']=$Model->GetEmpWorkData()->EMBRANCH;
        $_SESSION['EmRole']=$Model->GetEmpWorkData()->EMROLE;
        $_SESSION['EmName']=$Model->GetEmpWorkData()->EMNAME;
        
    } 
    
    /*
     * получение списка клиентов
     */
    protected function LoadList(){
        if ($this->Params==[]){
            $Model=new ATClientMod();
            $this->ClList=$Model->GetClientList();
        } else {
            $Model=new ATClientMod();
            $this->ClList=$Model->SearchClient($this->Params[0],$this->Params[1],$this->Params[2],$this->Params[3],$this->Params[4]);
        }
    }
    
    /* получение списков для проведения ЭПЭ
     */
    protected function getExpList(){
        $Model=new ExpertMod();
        $this->ExpList[1]=$Model->getExpList();
        $this->ExpList[2]=$Model->getExpJurList();
        $this->ExpList[3]=$Model->getExpDirList();        
    }
    
    /*получение списка реферальных ссылок
     */
    protected function GetRefers(){
        if ((isset($_GET['DateF']))&&($_GET['DateF']!='')&&(isset($_GET['DateL']))&&($_GET['DateL']!='')){            
            $this->Refers=(new AT7ReferProg())->GetAgentListDate($_GET['DateF'],$_GET['DateL']);        
        } else {
            $this->Refers=(new AT7ReferProg())->GetAgentList();
        }
        
    }
    
    /*формирование эксель файла с выгрузкой списка реферальнй программы
     * 
     */
    
}

