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
    protected $TblP1Front=['FROFFICE','FRPERSMANAGER','FREXPDATE','FREXPSUM','FREXPACTDATE',
        'FRCONTDATE','FRDOVDATE','FRCONTSUM','CONTPAC','FRCONTPROG','FRCONTTARIF','FRARCHDATE','FRTOTALWORKSUM'];
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
        (new ATP1ContMod())->updP1Front1(['lgDat','lgEmp','frOffice','frpersmanager','frcontsum','ContCode'],['a','b','ОП Томск','Никита Прокопьев','85000.00',0]);
        
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
    
    public function actionChangeBranch(){      
        $this->FrontSave();
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionTarifChoose(){                
        $this->FrontSave();
        (new Status())->ChangeP1Status(9, $_GET['ContCode']);
        $Cont=new ContP1($_GET['ContCode']);
        $Tarif=(new TarifP1())->getTarif($Cont->getFront()->FRCONTTARIF,$Cont->getExpert()->EXTOTDEBTSUM);
        $Pac=(new TarifP1())->getTarifContType($Tarif->TRPAC,$_SESSION['EmBranch']);        
        
        $Params=[
            'FRCONTSUM'=>$Tarif->TRSUMFIX,
            'FRCONTPAC'=>$Tarif->TRPAC,
            'FRCONTTYPE'=>$Pac->PACCONTTYPE
        ];        
        (new ATP1ContMod())->UpdP1Front($Params,$_GET['ContCode']);
        
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionSaveCalend(){
        $this->FrontSave();
        $Cont=new ContP1($_GET['ContCode']);
        $Period=(new TarifP1())->getPac($Cont->getFront()->FRCONTPAC)->PCPERIOD;
        $PaySum=$Cont->getFront()->FRCONTSUM/$Period;
        if ($Cont->getFront()->FRCONTDATE!=null){
            $PayDate=new DateTime($Cont->getFront()->FRCONTDATE);
        }else{
            $PayDate=new DateTime(date("d.m.Y"));
        }
        $Model=new PayCalend();
        $Model->delAllPlanPays($_GET['ContCode']);
        for ($i=1; $i<=$Period; $i++){
            $j=$i-1;
            $Model->addPlanPay($_GET['ContCode'],$i,$PaySum,$PayDate->format('d.m.Y'));
            $PayDate->modify("+1 month")->format('d.m.Y');
        }
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionAddCalend(){
        
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionUpdCalend(){
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionDelCalend(){
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
            
    public function actionAddDiscount(){
        $Cont=new ContP1($_GET['ContCode']);
        $Model=new P1DiscountMod();
        $Model->addDiscount($_GET['ContCode'],$_GET['DiscountSum'],$_GET['DiscountComment'],$_GET['DiscountType'],$_SESSION['EmName']);
        if ($_GET['DiscountType']=='НД'){
            $this->FrontSave($GetParams=[
                'ContCode'=>$_GET['ContCode'],
                'FRCONTSUM'=>$Cont->getFront()->FRCONTSUM-$_GET['DiscountSum']
            ]);
        }    
        
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionDelDiscount(){
        (new P1DiscountMod())->delDiscount($_GET['DiscId']);
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
    
    public function actionAddPayment(){        
        (new Payment($_GET['ClCode'],$_GET['ContCode'],$_SESSION['EmBranch'],$_SESSION['EmName'],1,$_GET['PAYCONTTYPE'],$_GET['PAYSUM']))->addPayment();
        
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionDelPayment(){
        (new PaymentMod())->updPaymentLg($_GET['PayId'],$_GET['ContCode'],$_SESSION['EmName']);
        (new PaymentMod())->delPayment($_GET['PayId'],$_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionFormPayBill(){
        (new Payment($_GET['ClCode'],$_GET['ContCode'],$_SESSION['EmBranch'],$_SESSION['EmName'],1,1,0))->formPayBill($_GET['Id'],$_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionAddComment(){
        (new ATCommentMod)->AddComment($_GET['ClCode'],$_GET['ContCode'],1,$_GET['NewComment'],$_SESSION['EmName']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionUpdComment(){//изменить комментарий
        (new ATCommentMod)->UpdComment($_GET['ComID'],$_GET['CmText']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
           
    public function actionDelComment(){
        (new ATCommentMod)->DelComment($_GET['ComID']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }   
    
    public function actionWorkFinal(){
        $this->FrontSave();
        (new Status())->ChangeP1Status(98, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionWorkBrake(){
        $this->FrontSave();
        (new Status())->ChangeP1Status(99, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionCredCount(){      
        //очистить расчётную таблицу
        (new P1ContCredMod())->delPayCredList();
        //загрузить список кредитных платежей по договору
        $Sql="SELECT * FROM tbl5Payments WHERE ContCode=? AND PayType=? ORDER BY PayDate";
        $Params=[$_GET['ContCode'],5];
                    
        $List1=(new ListProcessor($Sql,$Params))->getList();
        
        //загрзить информацию по кредиту из отдельной таблицы
        $Credit=(new ContP1($_GET['ContCode']))->Credit;
        
        //расчитать массив платежей в погашение кредита
        $i=0;
        $PayDate[0]=date_create($Credit->CredDate);
        #new MyCheck($PayDate[0],0);
        //$PayDate[0]=date_create('2023-04-15');
        $DebtAfterSum[0]=$Credit->CredSum;
        $Rate=$Credit->CredRate;
        foreach($List1 as $Pay){
            $i++;
            
            $PayDate[$i]=date_create($Pay->PAYDATE);            
            $PayDays[$i]=date_diff($PayDate[$i-1],$PayDate[$i])->days;
            $DebtSum[$i]=$DebtAfterSum[$i-1];
            $PaySum[$i]=$Pay->PAYSUM;
            $PercSum[$i]=$DebtSum[$i]*($Rate/100/12/30)*$PayDays[$i];
            $MainSum[$i]=$PaySum[$i]-$PercSum[$i];
            $DebtAfterSum[$i]=$DebtSum[$i]-$MainSum[$i];
            
            //сохранить массив в таблицу
            (new P1ContCredMod())->insPayCred($_GET['ContCode'],$i,$Pay->PAYDATE,$PayDays[$i],$DebtSum[$i],$PaySum[$i],$PercSum[$i],$MainSum[$i],$DebtAfterSum[$i]);
        }
        
        
        
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");        
    }
    
    protected function FrontSave($GetParams=[]){
        if ($GetParams==[]){
            $GetParams=$_GET;
        }        
        $Params=[];
        foreach($GetParams as $Key => $Param){
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
                    
    protected function ShowFile(){    
        $this->ViewName='Досье договора '.$this->Client->CLFNAME;
        $args=['Client'=>$this->Client,
            'ContP1'=>new ContP1($_GET['ContCode']),
            'Cont'=>$this->Cont,
            'Anketa'=>$this->TblP1Anketa,
            'Front'=>$this->TblP1Front,
            'Expert'=>$this->TblP1Expert,
            'Comments'=>$this->Comments,
            'Payment'=>new Payment($_GET['ClCode'],$_GET['ContCode'],$_SESSION['EmBranch'],$_SESSION['EmName'],1),
            'Tarif'=>new TarifP1(),
        ];
        $this->render('ATContP1FileFront',$args);
    }
      
}
