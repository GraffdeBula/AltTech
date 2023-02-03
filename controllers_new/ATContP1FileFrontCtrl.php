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
class ATContP1FileFrontCtrl extends ControllerMain {
    protected $TblP1Anketa=[];
    protected $TblP1Front=['FROFFICE','FRPERSMANAGER','FREXPDATE','FREXPSUM','FREXPACTDATE','FRCONTDATE','FRDOVDATE','FRCONTSUM','CONTPAC','FRCONTPROG','FRCONTTARIF','FRARCHDATE'];
    protected $TblP1Expert=[];
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
    
    public function actionTest(){   
        $Test=new PrintTrics();
        $this->Other[0]=$Test->SumStr($_GET['test']);
        
        $this->actionIndex();
    }
    
    public function actionFrontSave(){                
        $this->FrontSave();        
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionExpCont(){                        
        $this->FrontSave();
        (new Status())->ChangeP1Status(2, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionExpAct(){                
        $this->FrontSave();
        (new Status())->ChangeP1Status(8, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionTarifChoose(){                
        $this->FrontSave();
        (new Status())->ChangeP1Status(9, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionContSigned(){                
        $this->FrontSave();
        (new Status())->ChangeP1Status(11, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionDovGet(){
        $this->FrontSave();
        (new Status())->ChangeP1Status(13, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
        
    protected function FrontSave(){
        $Params=[];
        foreach($_GET as $Key => $Param){
            if (in_array($Key,$this->TblP1Front)){
                $Params[$Key]=$Param;
            }
        }        
        
        $Model=new ATP1ContMod();        
        $Model->UpdP1Front($Params,$_GET['ContCode']);
        
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
    
    protected function GetBranch($BrName){
        $Model=new BranchRecMod();
        $this->BranchRec=$Model->getBranchRec($BrName);
    }
    
    protected function GetComments(){
        $this->Comments=(new ATCommentMod)->GetContComments($_GET['ClCode'],$_GET['ContCode'],1);        
    }
    
    public function DelComment(){
        (new ATCommentMod)->DelComment($_GET('Id'));
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionAddComment(){
        (new ATCommentMod)->AddComment($_GET['ContCode'], $_GET['NewComment'], $_SESSION['EmName']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    protected function ShowFile(){    
        $this->ViewName='Досье договора '.$this->Client->CLFNAME;
        $args=['Client'=>$this->Client,
            'Cont'=>$this->Cont,
            'Anketa'=>$this->TblP1Anketa,
            'Front'=>$this->TblP1Front,
            'Expert'=>$this->TblP1Expert,
            'Comments'=>$this->Comments
        ];
        $this->render('ATContP1FileFront',$args);
    }
    
    
}
