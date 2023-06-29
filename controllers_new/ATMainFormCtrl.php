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
    
    public function actionClSearch(){
        $this->Params=[ucfirst($_GET['ClFName']),ucfirst($_GET['Cl1Name']),ucfirst($_GET['Cl2Name']),$_GET['ClPasSer'],$_GET['ClPasNum']];
        $this->LoadList();
        $this->GetEmpWorkData();
        $this->GetRefers();       
        $this->getExpList();
        $this->ShowList();
    }
    
    public function actionClIns(){
        $this->ClIns();        
        header("Location: index_admin.php?controller=ATMainFormCtrl&action=ClSearch"
            . "&ClFName={$_GET['ClFName']}&Cl1Name={$_GET['Cl1Name']}&Cl2Name={$_GET['Cl2Name']}&ClPasSer={$_GET['ClPasSer']}&ClPasNum={$_GET['ClPasNum']}");
    }
            
    public function actionClDel(){
        $Model=new ATClientMod();
        $Model->delClient($_GET['ClCode']);
        header("Location: index_admin.php?controller=ATMainFormCtrl");
    }
    
    public function actionSaveAgent(){//реферальная программа
        $Model=new AT7ReferProg();
        $Model->InsAgent($_GET['AgName'],$_GET['AgPhone'],$_SESSION['EmName']);
        
        $NewAg=$Model->GetAgent($_GET['AgName']);
        $ID=2731+$NewAg->ID;
        $Code='AGENT'.$ID;
        $ReferLink="https://fpk-alternativa.ru/bankrotstvo?utm_term=promo&kod={$Code}";
        $Model->UpdAgent($NewAg->ID, $NewAg->NAME, $Code, $ReferLink);

        header("Location: index_admin.php?controller=ATMainFormCtrl");
    }
    /* удаление агента из списка
     */
    public function actionDelAgent(){
        $DelComment="{'Date':'".Date('d.m.Y')."','Name':'".$_SESSION['EmName']."','Comment':'".$_GET['DelComment']."'}";
        (new AT7ReferProg())->DelAgent($_GET['RefId'], $DelComment);
        header("Location: index_admin.php?controller=ATMainFormCtrl");
    }
    /* выход из системы
     */
    public function actionExit(){
        $sessName='PHPSESSID';
	setcookie($sessName,'',time()-1,'/');
        header('Location: index_admin.php');
    }
    /* сохранение нового клиента
     */    
    protected function ClIns(){
        $Model=new ATClientMod();        
        $Model->NewClient($_GET['ClFName'],$_GET['Cl1Name'],$_GET['Cl2Name'],$_GET['ClPasSer'],$_GET['ClPasNum'],$_SESSION['EmName'],$_SESSION['EmBranch']);
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

