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
    use FixUrl;
    //Данные для отображения
    protected $Client=[];
    protected $Cont=[];
    protected $CredList=[];
    protected $Expert=[];
    protected $RiskList=[];
    protected $RiskList2=[];
    protected $MinIncList=[];
    protected $WorkHist=[];
    protected $IncHist=[];
    protected $Comments=[];
    protected $Credit=[];
    
    protected $Params=[];
    
    //Данные для заполнения
    protected $RiskListDr=[];
    protected $RiskListDr2=[];
    //для вывода во вью
    
    
    public function actionIndex(){
        $this->GetData();
        $this->ViewName='Экспертиза договора '.$this->Client->CLFNAME;
        $this->getUrl();
        if (isset($this->args['Front']->FREXPDATE)){
            $this->render('ATContP1FileExpert',$this->Args);
        }else{
            $this->render('ATContP1FileExpertNew',$this->Args);
        }
    }
        
    public function actionExpRes(){        
        if ($_GET['EXRES']=='ЭПЭ проведена'){
            #(new ExpertMod())->UpdSoglJur($_SESSION['EmName'], Date('d.m.Y'), $_GET['ContCode']);
        }
        #(new ExpertMod())->UpdSoglExp($_SESSION['EmName'], Date('d.m.Y'), $_GET['ContCode']);        
        (new ATP1ContMod())->UpdP1Expert([$_GET['EXTOTDEBTSUM'],$_GET['EXMAINDEBTSUM'],$_GET['EXANNTOTPAY'],$_GET['EXANNTOTINC'],$_GET['EXPRODREC'],$_GET['EXRES'],$_GET['ContCode']]);
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }

    public function actionAddToJurist(){ 
        (new ExpertMod())->AddToJurist($_GET['EXCOMMENT'],$_GET['ContCode']);
        (new P1SaveData('TblP1Expert','EXPJURSENTDATE',$_GET['ContCode']))->saveData();
        (new Status())->ChangeP1Status(7, $_GET['ContCode']);        
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionAddFromJurist(){ 
        (new ExpertMod())->AddFromJurist($_GET['EXJURCOMMENT'],$_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionExpReturn(){
        #(new ExpertMod())->UpdSoglExp($_SESSION['EmName'], Date('d.m.Y'), $_GET['ContCode']);
        (new P1SaveData('TblP1Front','FREXPRETURNDATE',$_GET['ContCode']))->saveData();
        (new Status())->ChangeP1Status(6, $_GET['ContCode']);            
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionExpSogl(){
        if ((new ExpertMod())->getExpMinInc($_GET['ContCode'])){

            (new ExpertMod())->UpdSoglExp($_SESSION['EmName'], Date('d.m.Y'), $_GET['ContCode']);
            if ($this->CheckStatus()){
                (new Status())->ChangeP1Status(17, $_GET['ContCode']);            
            }
            header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
        } else {
            header("Location: index_admin.php?controller=ErrorCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
        }
    }
    
    public function actionJurSogl(){
        (new ExpertMod())->UpdSoglJur($_SESSION['EmName'], Date('d.m.Y'), $_GET['ContCode']);
        if ($this->CheckStatus()){
            (new Status())->ChangeP1Status(17, $_GET['ContCode']);            
        }
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionDirSogl(){
        (new ExpertMod())->UpdSoglDir($_SESSION['EmName'], Date('d.m.Y'), $_GET['ContCode']);
        $this->CheckStatus();
        if ($this->CheckStatus()){
            (new Status())->ChangeP1Status(17, $_GET['ContCode']);            
        }
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionAddRisk(){//добавить риск заключения БФЛ
        if ((isset($_GET['AddRisk'])) && ($_GET['AddRisk']!='')){
            $NewRisk=$_GET['AddRisk'];
            (new ExpertMod)->InsExpRisk([$_GET['ContCode'],'Risk',$NewRisk,'']);
        }
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}#risks");
    }
    
    public function actionAddRisk2(){//добавить риск заключения БФЛ
        if ((isset($_GET['AddRisk2'])) && ($_GET['AddRisk2']!='')){
            $NewRisk=$_GET['AddRisk2'];
            $RiskVal2=$_GET['Risk2Value2'];
            (new ExpertMod)->InsExpRisk([$_GET['ContCode'],'Risk2',$NewRisk,$RiskVal2]);
        }
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}#risks");
    }
    
    public function actionUpdRisk(){//добавить инф о согласии юриста работать с этим риском
        (new ExpertMod())->updExpRisk($_GET['RiskValue2'],$_GET['RiskValue3'],$_GET['RiskID']);                
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    public function actionDelRisk(){//удалить риск заключения БФЛ
        (new ExpertMod)->DelExpRisk([$_GET['RiskID']]);        
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionSaveMinInc(){//сохранить расчёт прожиточного минимума
        (new ExpertMod())->delExpMinInc($_GET['ContCode']);
        (new ExpertMod())->addExpMinInc($_GET['ContCode'],'Avg',$_GET['MinIncAvg']);
        (new ExpertMod())->addExpMinInc($_GET['ContCode'],'Work',$_GET['MinIncWork']);
        (new ExpertMod())->addExpMinInc($_GET['ContCode'],'Pens',$_GET['MinIncPens']);
        (new ExpertMod())->addExpMinInc($_GET['ContCode'],'Child',$_GET['MinIncChild']);
        (new ExpertMod())->addExpMinInc($_GET['ContCode'],'Result',$_GET['MinIncResult']);
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionAddComment(){//добавить комментарий
        (new ATCommentMod)->AddComment($_GET['ClCode'],$_GET['ContCode'],1,$_GET['NewComment'],$_SESSION['EmName']);
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionUpdComment(){//изменить комментарий
        (new ATCommentMod)->UpdComment($_GET['ComID'],$_GET['CmText']);
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionDelComment(){//удалить комментарий
        (new ATCommentMod)->DelComment($_GET['ComID']);
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
        $this->RiskList2=(new ExpertMod)->GetExpRiskList2($_GET['ContCode']);
        $this->MinIncList=(new ExpertMod)->getExpMinInc($_GET['ContCode']);
        #$this->WorkHist=(new ATClientMod)->GetExp($_GET['ContCode']);
        #$this->IncHist=(new ATClientMod)->GetExp($_GET['ContCode']);
        $this->Comments=(new ATCommentMod())->GetContComments($_GET['ClCode'],$_GET['ContCode'],1);
        $this->RiskListDr=(new ExpertMod)->GetRiskDr(['Risk']);
        $this->RiskListDr2=(new ExpertMod)->GetRiskDr(['Risk2']); //риски по ВБФЛ
               
        if (isset($_GET['CrCode'])){
            $this->Credit=(new ATP1CredMod)->GetP1Credit($_GET['CrCode']);
        }
        
        $NewMinInc=[
            'Avg'=>'',
            'Work'=>'',
            'Pens'=>'',
            'Child'=>'',
            'Result'=>''
        ];
        foreach($this->MinIncList as $Inc){
            $NewMinInc[$Inc->EXLISTVALUE]=$Inc->EXLISTVALUE2;
        }
        
        $this->Args=[
            'Client'=>$this->Client,
            'Cont'=>$this->Cont,            
            'CredList'=>$this->CredList,
            'Expert'=>$this->Expert,            
            'Front'=>(new ATP1ContMod)->GetFront($_GET['ContCode']),
            'Comments'=>$this->Comments,
            'RiskList'=>$this->RiskList,
            'RiskList2'=>$this->RiskList2,
            'RiskListDr'=>$this->RiskListDr,
            'RiskListDr2'=>$this->RiskListDr2,
            'MinIncList'=>$NewMinInc,
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
        if (($this->Expert->EXJURSOGLDATE!=null)&&($this->Expert->EXDIRSOGLDATE!=null)){
            return true;
        } else {
            return false;
        }                
    }
            
}
