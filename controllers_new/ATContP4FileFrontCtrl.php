<?php
/**
 * контроллер управления  формой досье договора P4 (разовый)
 *
 * функции
 * открыть досье договора - экшн
 * показать информацию по договору
 * сохранить информацию по договору - экшн
 * принять платёж и вывести ПКО
 * распечатать договор ЭПЭ - экшн
 * 
 * ** экшн должен вызвать объект класса PrintDoc и передать ему всю необходимую информацию для печати договора
 * 
 */
class ATContP4FileFrontCtrl extends ControllerMain {
    protected $TblP4Anketa=[];
    protected $TblP4Front=['FROFFICE','FRPERSMANAGER','FRCONSDATE','FRCONTDATE','FRDOVDATE','FRCONTSUM','FRCONTSERVICE','FRCONTPAYTYPE','FRARCHDATE'];
    
    protected $Params=[];
    protected $Cont=[];    
    protected $Client=[];
    protected $BranchRec=[];
    protected $Comments=[];
    protected $Other=[0=>''];
    
    public function actionIndex(){   
        $this->GetClient();
        $this->GetCont();
        $this->GetComments();
        $this->ShowFile();
    }
          
    public function actionFrontSave(){                
        $this->FrontSave();        
        header("Location: index_admin.php?controller=ATContP4FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionAddPayment(){
        (new Payment($_GET['ClCode'],$_GET['ContCode'],$_SESSION['EmBranch'],$_SESSION['EmName'],4,$_GET['PAYCONTTYPE'],$_GET['PAYSUM']))->addPayment();
        
        header("Location: index_admin.php?controller=ATContP4FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionAddComment(){
        (new ATCommentMod)->AddComment($_GET['ClCode'],$_GET['ContCode'],1,$_GET['NewComment'],$_SESSION['EmName']);
        header("Location: index_admin.php?controller=ATContP4FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
           
    public function actionDelComment(){
        (new ATCommentMod)->DelComment($_GET('Id'));
        header("Location: index_admin.php?controller=ATContP4FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }   
    
    protected function FrontSave(){
        $Params=[];
        foreach($_GET as $Key => $Param){
            if (in_array($Key,$this->TblP4Front)){
                $Params[$Key]=$Param;
            }
        }        
        
        $Model=new ATP4ContMod();        
        $Model->UpdP1Front($Params,$_GET['ContCode']);        
    }

    protected function GetClient(){
        $Model=new ATClientMod();
        $this->Client=$Model->GetClientById($_GET['ClCode']);
    }
    
    protected function GetCont(){
        $Model=new ATP4ContMod();
        $this->TblP4Anketa=$Model->getAnketaByCode($_GET['ContCode']);
        $this->TblP4Front=$Model->getFrontByCode($_GET['ContCode']);        
        $this->Cont=(new ATP4ContMod)->getCont($_GET['ContCode']);
    }
    
    protected function GetBranch($BrName){
        $Model=new BranchRecMod();
        $this->BranchRec=$Model->getBranchRec($BrName);
    }
    
    protected function GetComments(){
        $this->Comments=(new ATCommentMod)->GetContComments($_GET['ClCode'],$_GET['ContCode'],1);        
    }
                    
    protected function ShowFile(){    
        $this->ViewName='Досье договора '.$this->Client->CLFNAME;
        $args=['Client'=>$this->Client,
            'Cont'=>$this->Cont,
            'Anketa'=>$this->TblP4Anketa,
            'Front'=>$this->TblP4Front,            
            'Comments'=>$this->Comments,
            'Payment'=>new Payment($_GET['ClCode'],$_GET['ContCode'],$_SESSION['EmBranch'],$_SESSION['EmName'],4),
            'Tarif'=>new TarifP1(),
        ];
        $this->render('ATContP4FileFront',$args);
    }
      
}
