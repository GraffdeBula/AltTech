<?php
/**
 * контроллер управления  формой досье клиента
 *
 * функции
 * открыть досье клиента
 * показать список договоров БФЛ
 * добавить договор БФЛ
 * показать список договоров РУ
 * добавить договор РУ
 */
class ATClientFileCtrl extends ControllerMain {
    protected $Params=[];
    protected $ContP1List=[];
    protected $ContP4List=[];
    protected $Client=[];
    protected $Comments=[];
    
    public function actionIndex(){
        $this->Params=[];
        $this->LoadClient();
        $this->LoadContP1List();
        $this->LoadContP4List();
        $this->LoadComments();
        $this->ViewName='Досье клиента '.$this->Client->CLFNAME;
        $args=['Client'=>$this->Client,'ContP1List'=>$this->ContP1List,'ContP4List'=>$this->ContP4List,'Comments'=>$this->Comments];
        $this->render('ATClientFile',$args);
    }
    
    public function actionContP1Create(){
        $Model=new ATP1ContMod();        
        $Model->InsP1Anketa($_GET['ClCode'],$_SESSION['EmBranch'],$_SESSION['EmName']);
        header("Location: index_admin.php?controller=ATClientFileCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionContP1Del(){        
        (new ATP1ContMod())->DelP1Anketa($_GET['ContCode']);
        header("Location: index_admin.php?controller=ATClientFileCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionContP4Create(){
        $Model=new ATP4ContMod();        
        $Model->InsP4Anketa($_GET['ClCode'],$_SESSION['EmBranch'],$_SESSION['EmName']);
        header("Location: index_admin.php?controller=ATClientFileCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionContP4Del(){        
        (new ATP4ContMod())->DelP4Anketa($_GET['ContCode']);
        header("Location: index_admin.php?controller=ATClientFileCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionAddComment(){
        (new ATCommentMod())->AddComment($_GET['ClCode'],0,0,$_GET['NewComment'],$_SESSION['EmName']);
        header("Location: index_admin.php?controller=ATClientFileCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionDelComment(){
        (new ATCommentMod())->DelComment($_GET['ClAccID']);        
        header("Location: index_admin.php?controller=ATClientFileCtrl&ClCode={$_GET['ClCode']}");
    }
           
    protected function LoadClient(){       
        $Model=new ATClientMod();
        $this->Client=$Model->GetClientById($_GET['ClCode']);
    }
    
    protected function LoadContP1List(){       
        $Model=new ATP1ContMod();
        $this->ContP1List=$Model->GetP1ContList($_GET['ClCode']);
    }
    
    protected function LoadContP4List(){       
        $Model=new ATP4ContMod();
        $this->ContP4List=$Model->GetContList($_GET['ClCode']);
    }
    
    protected function LoadComments(){       
        $Model=new ATCommentMod();
        $this->Comments=$Model->GetClComments($_GET['ClCode']);
    }
               
}
