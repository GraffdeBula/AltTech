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
    protected $RiskListMan=[];
    protected $RiskList2=[];
    protected $RiskListOld=[];
    protected $RiskListDirSogl=[];
    protected $MinIncList=[];
    protected $WorkHist=[];
    protected $IncHist=[];
    protected $Comments=[];
    protected $Credit=[];
    protected $InfSave=[];
    
    protected $Params=[];
    
    //Данные для заполнения
    protected $RiskDr=[];//справочник обычных рисков
    protected $RiskDr2=[];//справочник рисков ВБФЛ
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
        $Params=[
            'EXTOTDEBTSUM'=>$_GET['EXTOTDEBTSUM'],            
            'EXANNTOTPAY'=>$_GET['EXANNTOTPAY'],            
            'EXPRODREC'=>$_GET['EXPRODREC'],
            'EXRES'=>$_GET['EXRES'],
            'EXCRNUM'=>$_GET['EXCRNUM'],
            'EXCOMPLEXCRNUM'=>$_GET['EXCOMPLEXCRNUM'],
            'EXJURCOMMENT'=>$_GET['EXJURCOMMENT'],
            'EXCONTDOPSUM'=>$_GET['EXCONTDOPSUM'],
            'EXDIFCOST'=>$_GET['EXDIFCOST'],
        ];
        (new ATP1ContMod())->UpdP1Expert2($Params,$_GET['ContCode']);
        
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }

    public function actionAddToJurist(){ 
        (new ExpertMod())->AddToJurist($_GET['EXCOMMENT'],$_GET['ContCode']);
        (new P1SaveData('TblP1Expert','EXPJURSENTDATE',$_GET['ContCode']))->saveData();
        (new Status())->ChangeP1Status(7, $_GET['ContCode']);        
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }       
    
    public function actionSaveUnder(){ 
        $Params=[
            'EXPUNDERDATE'=>date('d.m.Y'),
            'EXPUNDERRES'=>$_GET['EXPUNDERRES'],
            'EXPUNDERCOMMENT'=>$_GET['EXPUNDERCOMMENT']
        ];
        (new ATP1ContMod())->UpdP1Expert2($Params,$_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionSaveErrWork(){
        $Params=[
            'EXJURERRWORKDATE'=>date('d.m.Y'),
            'EXJURERRWORKNAME'=>$_SESSION['EmName'],
            'EXJURERRWORKCOMMENT'=>$_GET['EXJURERRWORKCOMMENT']
        ];
        (new ATP1ContMod())->UpdP1Expert2($Params,$_GET['ContCode']);
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
        (new P1SaveData('TblP1Front','FREXPACTDATE',$_GET['ContCode']))->saveData();
        (new Status())->ChangeP1Status(17, $_GET['ContCode']);            
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionDirSogl(){
        (new ExpertMod())->UpdSoglDir($_SESSION['EmName'], Date('d.m.Y'), $_GET['ContCode']);
        (new Status())->ChangeP1Status(18, $_GET['ContCode']);            
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
           
    public function actionAddRisk2(){//добавить риск заключения БФЛ
        if ((isset($_GET['AddRisk2'])) && ($_GET['AddRisk2']!='')){
            $NewRisk=$_GET['AddRisk2'];
            $RiskVal2=$_GET['Risk2Value2'];
            (new ExpertMod)->InsExpRisk($_GET['ContCode'],'Risk2',$NewRisk,$RiskVal2,'',0);
        }
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}#risks");
    }
    
    public function actionUpdRisk(){//добавить инф о согласии юриста работать с этим риском
        (new ExpertMod())->updExpRisk($_GET['RiskValue2'],$_GET['RiskValue3'],$_GET['RiskID']);                
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    public function actionDelRisk_old(){//удалить риск заключения БФЛ
        (new ExpertMod)->DelExpRisk([$_GET['RiskID']]);        
        header("Location: index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionAddRisk(){//добавить риск заключения БФЛ
        (new ExpertMod())->InsExpRisk($_GET['ContCode'],'Risk',$_GET['RiskVal'],'Jurist','',$_GET['RiskCost']);
    }
    
    public function actionDelRisk(){
        (new ExpertMod())->DelExpRisk2($_GET['ContCode'],$_GET['RiskVal'],'Jurist');
    }
    
    public function actionCountRiskDopSum(){
        $RiskDopSum=(new ExpertMod())->CountRiskSum($_GET['ContCode'],'Jurist')->RISKCOST;
        (new ATP1ContMod())->UpdP1Expert2(['EXCONTDOPSUM'=>$RiskDopSum],$_GET['ContCode']);
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
        $this->RiskList=(new ExpertMod)->GetExpRiskList($_GET['ContCode'],'Jurist');        
        $this->RiskListMan=(new ExpertMod)->GetExpRiskList($_GET['ContCode'],'Manager');  
        $this->RiskListDirSogl=(new ExpertMod)->GetExpRiskList($_GET['ContCode'],'DirSogl');
        $this->RiskListOld=(new ExpertMod)->GetExpRiskListOld($_GET['ContCode']);
        $this->RiskList2=(new ExpertMod)->GetExpRiskList2($_GET['ContCode']);
        $this->MinIncList=(new ExpertMod)->getExpMinInc($_GET['ContCode']);
        #$this->WorkHist=(new ATClientMod)->GetExp($_GET['ContCode']);
        #$this->IncHist=(new ATClientMod)->GetExp($_GET['ContCode']);
        $this->Comments=(new ATCommentMod())->GetContComments($_GET['ClCode'],$_GET['ContCode'],1);
        $this->RiskDr=(new ExpertMod)->GetRiskDr(['Risk']);//справочник обычных рисков
        $this->RiskDr2=(new ExpertMod)->GetRiskDr(['Risk2']); //справочник рисков по ВБФЛ
        
        $TmpInfSave=(new InfSave())->getInf($_GET['ContCode']);
        $this->InfSave=[];
        foreach($TmpInfSave as $Inf){
            $this->InfSave[$Inf->INFVARIABLE]=$Inf->INFVALUE;
        }
                                       
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
            'Anketa'=>(new ATP1ContMod)->GetAnketa($_GET['ContCode']),
            'Comments'=>$this->Comments,
            'RiskDr'=>$this->RiskDr,
            'RiskList'=>$this->RiskList,
            'RiskListOld'=>$this->RiskListOld,
            'RiskListMan'=>$this->RiskListMan,
            'RiskListDirSogl'=>$this->RiskListDirSogl,
            'RiskList2'=>$this->RiskList2,            
            'RiskDr2'=>$this->RiskDr2,
            'MinIncList'=>$NewMinInc,
            'Credit'=>$this->Credit,
            'WorkHist'=>$this->WorkHist,
            'IncHist'=>$this->IncHist,
            'DRRegionsList'=>(new ATDrRegionsMod())->GetRegList(),
            'InfSave'=>$this->InfSave
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
