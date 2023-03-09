<?php
/**
 * контроллер управления  формой досье экпертиза
 *
 * функции
 * открыть досье экспертизы
 * сохранить результат
 * сохранить сумму долга
 * 
 */
class ATContP1FileExpertCtrl extends ControllerMain {
    //Данные для отображения
    protected $Client=[];
    protected $Cont=[];
    protected $CredList=[];
    protected $Expert=[];
    protected $RiskList=[];
    protected $WorkHist=[];
    protected $IncHist=[];
    protected $Comments=[];
    protected $Credit=[];
    
    protected $Params=[];
    
    //Данные для заполнения
    protected $RiskListDr=[];
    //для вывода во вью
    
    
    public function actionIndex(){
        $this->GetData();
        $this->ViewName='Экспертиза договора '.$this->Client->CLFNAME;
        $this->render('ATContP1FileExpert',$this->Args);
    }
        
    public function actionExpRes(){        
        if ($_GET['EXRES']=='ЭПЭ проведена'){
            (new ExpertMod())->UpdSoglJur($_SESSION['EmName'], Date('d.m.Y'), $_GET['ContCode']);
        }
        #(new ExpertMod())->UpdSoglExp($_SESSION['EmName'], Date('d.m.Y'), $_GET['ContCode']);        
        (new ATP1ContMod())->UpdP1Expert([$_GET['EXTOTDEBTSUM'],$_GET['EXMAINDEBTSUM'],$_GET['EXANNTOTPAY'],$_GET['EXANNTOTINC'],$_GET['EXPRODREC'],$_GET['EXRES'],$_GET['ContCode']]);
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }

    public function actionExpSogl(){
        (new ExpertMod())->UpdSoglExp($_SESSION['EmName'], Date('d.m.Y'), $_GET['ContCode']);
        if ($this->CheckStatus()){
            (new Status())->ChangeP1Status(4, $_GET['ContCode']);            
        }
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionJurSogl(){
        (new ExpertMod())->UpdSoglJur($_SESSION['EmName'], Date('d.m.Y'), $_GET['ContCode']);
        if ($this->CheckStatus()){
            (new Status())->ChangeP1Status(4, $_GET['ContCode']);            
        }
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionDirSogl(){
        (new ExpertMod())->UpdSoglDir($_SESSION['EmName'], Date('d.m.Y'), $_GET['ContCode']);
        $this->CheckStatus();
        if ($this->CheckStatus()){
            (new Status())->ChangeP1Status(4, $_GET['ContCode']);            
        }
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionAddRisk(){//добавить риск заключения БФЛ
        if ((isset($_GET['AddRisk'])) && ($_GET['AddRisk']!='')){
            $NewRisk=$_GET['AddRisk'];
            (new ExpertMod)->InsExpRisk([$_GET['ContCode'],'Risk',$NewRisk]);
        }
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionDelRisk(){//удалить риск заключения БФЛ
        (new ExpertMod)->DelExpRisk([$_GET['RiskID']]);
        
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionAddComment(){//добавить риск заключения БФЛ
        (new ATCommentMod)->AddComment($_GET['ClCode'],$_GET['ContCode'],1,$_GET['NewComment'],$_SESSION['EmName']);
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionShowIncHist(){
        $this->CredList=(new ATP1CredMod)->GetP1CredList($_GET['ContCode']);
        
        
        $Model=new ATClientMod();
        
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function GetData(){
        $this->Params=[];
        $this->Client=(new ATClientMod)->GetClientById($_GET['ClCode']);
        $this->Cont=(new ATP1ContMod)->GetCont($_GET['ContCode']);        
        $this->CredList=(new ATP1CredMod)->GetP1CredList($_GET['ContCode']);
        $this->Expert=(new ExpertMod)->GetExp($_GET['ContCode']);
        $this->RiskList=(new ExpertMod)->GetExpRiskList($_GET['ContCode']);
        #$this->WorkHist=(new ATClientMod)->GetExp($_GET['ContCode']);
        #$this->IncHist=(new ATClientMod)->GetExp($_GET['ContCode']);
        $this->Comments=(new ATCommentMod())->GetContComments($_GET['ClCode'],$_GET['ContCode'],1);
        $this->RiskListDr=(new ExpertMod)->GetRiskDr(['Risk']);
        
        
        if (isset($_GET['CrCode'])){
            $this->Credit=(new ATP1CredMod)->GetP1Credit($_GET['CrCode']);
        }
        
        $this->Args=[
            'Client'=>$this->Client,
            'Cont'=>$this->Cont,            
            'CredList'=>$this->CredList,
            'Expert'=>$this->Expert,            
            'Comments'=>$this->Comments,
            'RiskList'=>$this->RiskList,
            
            'RiskListDr'=>$this->RiskListDr,
            
            'Credit'=>$this->Credit,
            'WorkHist'=>$this->WorkHist,
            'IncHist'=>$this->IncHist
                        
        ];
        
    }
    
    public function actionShowAddViewCred(){
        $this->GetData();        
        $this->render('ATContP1FileExpCred',$this->Args);
    }
    
    public function actionShowAddViewWork(){
        $this->GetData();        
        $this->render('ATContP1FileExpWork',$this->Args);
    }
     
    protected function ChangeStatus($StatNum){
        (new ATP1ContMod)->UpdP1Status($StatNum,$_GET['ContCode']);
    }
    
    protected function CheckStatus(){
        $this->Expert=(new ExpertMod)->GetExp($_GET['ContCode']);
        if (($this->Expert->EXRESDAT!=null)&&($this->Expert->EXJURSOGLDATE!=null)&&($this->Expert->EXDIRSOGLDATE!=null)){
            return true;
        } else {
            return false;
        }                
    }
            
}
