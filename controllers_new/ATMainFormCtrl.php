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
    protected $DiscList=[];
        
    public function actionIndex(){
        $this->GetEmpWorkData();
        $this->Params=[];
        $this->LoadList();                        
        $this->getDiscList();       
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
        $this->GetEmpWorkData();
        $FName=mb_convert_case($_GET['ClFName'],MB_CASE_TITLE, "UTF-8");        
        $FirstName=mb_convert_case($_GET['Cl1Name'],MB_CASE_TITLE, "UTF-8");
        $SecName=mb_convert_case($_GET['Cl2Name'],MB_CASE_TITLE, "UTF-8");
        $this->Params=[$FName,$FirstName,$SecName,$_GET['ClPasSer'],$_GET['ClPasNum']];
        $this->LoadList();        
        $this->getDiscList();       
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
        $args=['ClList'=>$this->ClList,'DiscList'=>$this->DiscList,'ExpList'=>$this->ExpList];        
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
        if (in_array($_SESSION['EmRole'],['admin','top','expert','director','jurist'])){
            if ($this->Params==[]){
                $Model=new ATClientMod();
                $this->ClList=$Model->GetClientListAll();
            } else {
                $Model=new ATClientMod();
                $this->ClList=$Model->SearchClientAll($this->Params[0],$this->Params[1],$this->Params[2],$this->Params[3],$this->Params[4]);
            }
        }
        if (in_array($_SESSION['EmRole'],['franshdir','franshman','front','frontextra'])){
            if ($this->Params==[]){
                $Model=new ATClientMod();
                $this->ClList=$Model->GetClientList($_SESSION['EmBranch']);
            } else {
                $Model=new ATClientMod();
                $this->ClList=$Model->SearchClient($this->Params[0],$this->Params[1],$this->Params[2],$this->Params[3],$this->Params[4],$_SESSION['EmBranch']);
            }
        }
    }
    
    /* получение списков для проведения ЭПЭ
     */
    protected function getExpList(){
        $Model=new ExpertMod();        
        $this->ExpList[1]=$Model->getExpContList(); //заключен договор ЭПЭ
        $this->ExpList[2]=$Model->getExpGetList(); //Получены док-ты от клиента
        $this->ExpList[3]=$Model->getExpSentList(); //Отправлены на ЭПЭ
        $this->ExpList[4]=$Model->getExpReturnList(); //Направлены на доработку
        $this->ExpList[5]=$Model->getExpJurSoglList(); //Направлены юристу
        $this->ExpList[11]=$Model->getContJurList(); //заключен договор услуг
        $this->ExpList[12]=$Model->getContJurSogl(); //заключен договор услуг
        $this->ExpList[13]=$Model->getContAfterUnder(); //заключен договор услуг
    }
    /*получение списка скидок на согласование*/
    protected function getDiscList(){
        $this->DiscList=(new ATP1ContMod())->getContApproveList();
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

