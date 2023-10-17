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
    
    public function actionCons(){
        (new ATP4ContMod())->updP4Cons($_GET['FROFFICE'],$_SESSION['EmName'],$_GET['FRCONSDATE'],$_SESSION['EmName'],$_GET['ContCode']);
        (new Status())->ChangeP4Status(2, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP4FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    //$FrOffice,$FrPersManager,$FrConsDate,$Emp,$ContCode
    public function actionContSigned(){
        (new ATP4ContMod())->updP4Cont($_GET['FROFFICE'],$_SESSION['EmName'],$_GET['FRCONTDATE'],$_GET['FRCONTSUM'],$_SESSION['EmName'],$_GET['ContCode']);
        (new Status())->ChangeP4Status(4, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP4FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionChangeBranch(){      
        (new ATP4ContMod())->updP4Office($_GET['FROFFICE'],$_SESSION['EmName'],$_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP4FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionDovGet(){
        (new ATP4ContMod())->updP4Dov($_GET['FROFFICE'],$_SESSION['EmName'],$_GET['FRDOVDATE'],$_SESSION['EmName'],$_GET['ContCode']);
        (new Status())->ChangeP4Status(6, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP4FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionJurSave(){
        (new ATP4ContMod())->updP4Jurist($_GET['FRJURIST'],$_GET['FRJURDOVDATE'],$_SESSION['EmName'],$_GET['ContCode']);        
        header("Location: index_admin.php?controller=ATContP4FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionWorkFinal(){
        (new ATP4ContMod())->updP4FinWork($_SESSION['EmName'],$_GET['ContCode']);        
        (new Status())->ChangeP4Status(10, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP4FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionServiceSave(){
        (new ATP4ContMod())->updP4FrontService($_GET['ContCode'],$_GET['FrContService'],$_GET['FrJurBranch'],$_GET['FrAttrChannel'],$_GET['FrContResult'],$_GET['FrJurist'],$_GET['FrFinWorkDate']);
        header("Location: index_admin.php?controller=ATContP4FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
       
    public function actionAddPayment(){
        (new Payment($_GET['ClCode'],$_GET['ContCode'],$_SESSION['EmBranch'],$_SESSION['EmName'],4,$_GET['PAYCONTTYPE'],$_GET['PAYSUM'],'','',$_GET['PAYMETHOD']))->addPayment();
        
        header("Location: index_admin.php?controller=ATContP4FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionDelPayment(){
        (new PaymentMod())->updPaymentLg($_GET['PayId'],$_GET['ContCode'],$_SESSION['EmName']);
        (new PaymentMod())->delPayment($_GET['PayId'],$_GET['ContCode']);
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
            'EmpList'=>(new Employee(''))->getEmpList()
        ];
        $this->render('ATContP4FileFront',$args);
    }
      
}
