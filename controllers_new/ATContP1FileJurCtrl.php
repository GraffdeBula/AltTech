<?php
/**
 * контроллер управления  формой досье договора P1
 *
 * функции
 * открыть досье договора - экшн
 * показать информацию по договору
 * сохранить информацию по договору - экшн
 * открыть анкету договора - переход по ссылке
 * распечатать договор ЭПЭ - экшн
 * ** запускается экшн печать договора ЭПЭ. он получаеткод клиента и код договора
 * ** экшн должен вызвать объект класса PrintDoc и передать ему всю необходимую информацию для печати договора
 * 
 */
class ATContP1FileJurCtrl extends ControllerMain {
    protected $TblP1Anketa=[];
    protected $TblP1Front=['FROFFICE','FRPERSMANAGER','FREXPDATE','FREXPSUM','FREXPACTDATE',
        'FRCONTDATE','FRDOVDATE','FRCONTSUM','CONTPAC','FRCONTPROG','FRCONTTARIF','FRARCHDATE','FRTOTALWORKSUM'];
    protected $TblP1Expert=[];
    protected $Params=[];
    protected $Cont=[];    
    protected $Client=[];
    protected $BranchRec=[];
    protected $EmpList=[];
    protected $Comments=[];
    protected $Other=[0=>''];
    
    public function actionIndex(){   
        $this->GetClient();
        $this->GetCont();  
                
        $this->ShowFile();
    }
    
    public function actionJurSave(){
        $this->updBackOf();
        
        header("Location: index_admin.php?controller=ATContP1FileJurCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionUpdDebt(){
        $Model=new ATP1CredMod();
        $Params=[
            'CRSUMREST'=>$_GET['CRSUMREST'],
            'CRSUMOVERDUE'=>$_GET['CRSUMOVERDUE'],
            'CRSUMFINE'=>$_GET['CRSUMFINE'],
        ];
        $Model->UpdP1Credit($Params,$_GET['CrCode']);
        
        header("Location: index_admin.php?controller=ATContP1FileJurCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    protected function ShowFile(){    
        $this->ViewName='Досье договора '.$this->Client->CLFNAME;
        $args=['Client'=>$this->Client,
            'ContP1'=>new ContP1($_GET['ContCode']),
            'Cont'=>$this->Cont,
            'Anketa'=>$this->TblP1Anketa,
            'Front'=>$this->TblP1Front,
            'BackOf'=>(new ContP1($_GET['ContCode']))->getBackOf(),
            'EmpList'=>(new Employee(''))->getEmpList(),
            'CreditListArr'=>(new ContP1($_GET['ContCode']))->getCreditList()->getCreditListArr(),
            'CreditList'=>(new ContP1($_GET['ContCode']))->getCredList(),
        ];
        $this->render('ATContP1FileJur',$args);
    }
    
    protected function GetClient(){
        $Model=new ATClientMod();
        $this->Client=$Model->GetClientById($_GET['ClCode']);
    }
    
    protected function GetCont(){
        $Model=new ATP1ContMod();
        $this->TblP1Anketa=$Model->GetAnketa($_GET['ContCode']);
        $this->TblP1Front=$Model->GetFront($_GET['ContCode']);
        $this->TblP1Expert=$Model->GetExpert($_GET['ContCode']);
        $this->Cont=(new ATP1ContMod)->GetCont($_GET['ContCode']);
    }
    
    protected function updBackOf(){
        $Keys=['lgEmp'];
        $Params=[$_SESSION['EmName']];
        $i=0;
        foreach($_GET as $key => $Param){
            if (!in_array($key,['controller','action','ClCode'])){
                $Keys[]=$key;
                $Params[]=$Param;
            }
            $i++;    
        }
        $Keys[]='ContCode';
        $Params[]=$_GET['ContCode'];        
        (new ATP1ContMod())->updP1BackOf($Keys,$Params);
    }
      
}
