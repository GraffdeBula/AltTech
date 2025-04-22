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
    protected $TblP1Front=['FROFFICE','FRPERSMANAGER','FREXPDATE','FREXPSUM','FREXPGETDATE','FREXPSENTDATE','FREXPACTDATE',
        'FRCONTDATE','FRDOVDATE','FRCONTSUM','FRDOPDATE','FRDOPSUM','FRCONTFIRSTSUM','FRCONTTOTSUM','CONTPAC','FRCONTPROG','FRCONTTARIF',
        'FRARCHDATE','FRTOTALWORKSUM','FRARCHCOMMENT','FRCRNUM','FRCOMPLEXCRNUM','FRSMALLCRED','FREASYCASE','FRCONTPERIIOD','FRCONTDROPWHO','FRDIFCOST1'];
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
    
    public function actionChangeLeadId(){   
        (new ATP1ContMod())->UpdP1Anketa(['AKLEADID'=>$_GET['LeadId']],$_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
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
    
    public function actionExpGet(){                        
        $this->FrontSave();
        (new Status())->ChangeP1Status(16, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionExpReady(){                        
        $this->FrontSave();
        (new Status())->ChangeP1Status(17, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionExpSigned(){                        
        $this->FrontSave();
        (new Status())->ChangeP1Status(18, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionExpSent(){                        
        $this->FrontSave();
        (new Status())->ChangeP1Status(5, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionDopSigned(){                
        $Cont=new ContP1($_GET['ContCode']);
        
        $this->FrontSave([
            'CONTCODE'=>$_GET['ContCode'],
            'FRDOPDATE'=>$_GET['FRDOPDATE'],
            'FRDOPSUM'=>$_GET['FRDOPSUM'],
            'FRCONTSUM'=>$_GET['FRDOPSUM']+$Cont->getFront()->FRCONTFIRSTSUM
        ]);
        $this->SaveTypeCalend();
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionExpAct(){                
        $this->FrontSave();
        (new Status())->ChangeP1Status(12, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionChangeBranch(){      
        $this->FrontSave();
        (new ATClientMod())->updClient(['CLBRANCH'=>$_GET['FROFFICE']],$_GET['ClCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionTest(){
        $ContFront=(new ContP1($_GET['ContCode']))->getFront();
        $CountFirstSum=[
            'Число кредитов'=>$ContFront->FRCRNUM,
            'Сложных кредиторов'=>$ContFront->FRCOMPLEXCRNUM,
            'Маленькая сумма'=>$ContFront->FRSMALLCRED,
            'Простой случай'=>$ContFront->FREASYCASE,
            'Срок договора (мес)'=>$ContFront->FRCONTPERIOD,
        ];
        new MyCheck(json_encode($CountFirstSum),0);
        $this->FrontSave([
            'CONTCODE'=>$_GET['ContCode'],
            'FRCONTFIRSTSUMCOUNT'=>$CountFirstSum
        ]);
    }
    
    public function actionTarifChoose(){                        
        $Discount=0;
        $DiscountName='';
        if (isset($_GET['DISCACTION'])&&($_GET['DISCACTION']!='')){
            $Disc=explode(":_",$_GET['DISCACTION']);
            $DiscountName=$Disc[0];
            $Discount=$Disc[1];
        }
        if (isset($_GET['DISCDIRECTOR'])&&($_GET['DISCDIRECTOR']>0)){
            $DiscountName='Скидка руководителя';
            $Discount=$_GET['DISCDIRECTOR'];
        }
        
        $Model=new P1DiscountMod();
        $Model->delDiscountList($_GET['ContCode']);
        $Model->addDiscount($_GET['ContCode'], $Discount, $DiscountName, 'НД', $_SESSION['EmName']);
                
        $Params=[            
            'FRCONTPROG'=>$_GET['FRCONTPROG'],
            'FRCONTTARIF'=>$_GET['FRCONTTARIF']            
        ];        
        (new ATP1ContMod())->UpdP1Front($Params,$_GET['ContCode']);
        
        $Cont=new ContP1($_GET['ContCode']);
        if ($Cont->getFront()->FROFFICE==''){
            $Branch=$_SESSION['EmBranch'];
        } else {
            $Branch=$Cont->getFront()->FROFFICE;
        }                        
        $Tarif=(new TarifMod())->getTarif($Cont->getFront()->FRCONTTARIF,$Cont->getExpert()->EXTOTDEBTSUM,$Branch);         
        $Pac=(new TarifP1())->getTarifContType($Tarif->TRPAC,$Branch);        
        $ContSum=$Tarif->TRSUMFIX;
        #увеличение стоимости потарифу классический для 11 и более кредиторов
        $MailExp=0;
        if (($Cont->getAnketa()->AKCREDNUM>10)&&(in_array($Tarif->TRPAC,['pac85','pac86','pac87','pac88','pac89']))){
            $ContSum=$ContSum+10000;
        }
        
        if (isset($_GET['FRCRNUM'])){
            
            $DopSum=0;
            
            if (($_GET['FRCRNUM']>=11)&&($_GET['FRCRNUM']<=20)){
                $DopSum=9000;
            }
            if (($_GET['FRCRNUM']>=21)&&($_GET['FRCRNUM']<=40)){
                $DopSum=18000;
            }
            if (($_GET['FRCRNUM']>=41)&&($_GET['FRCRNUM']<=460)){
                $DopSum=27000;
            }
            if ($_GET['FRCRNUM']>=61){
                $DopSum=36000;
            }
            
            
            $ContSum=$ContSum+$DopSum;                        
        }
        
        if (isset($_GET['FRCOMPLEXCRNUM'])){
            $ContSum=$ContSum+9000*$_GET['FRCOMPLEXCRNUM'];
        }
        
        if (isset($_GET['FRSMALLCRED'])){
            $ContSum=$ContSum-36000;
        }
        
        if (isset($_GET['FREASYCASE'])){
            $ContSum=$ContSum-18000;
        }
        $ContSum=$ContSum-$Discount; //применена скидка
        
        $Params=[            
            'FRCONTSUM'=>$ContSum,
            'FRCONTPAC'=>$Tarif->TRPAC,
            'FRCONTTYPE'=>$Pac->PACCONTTYPE
        ];        
        (new ATP1ContMod())->UpdP1Front($Params,$_GET['ContCode']);
        
        $Params=[
            'FRCRNUM'=>$_GET['FRCRNUM'],
            'FRCOMPLEXCRNUM'=>$_GET['FRCOMPLEXCRNUM'],
            'FRCONTPERIOD'=>$_GET['FRCONTPERIOD'],
            'FRDIFCOST1'=>$_GET['FRDIFCOST1']
        ];
        
        if (isset($_GET['FRSMALLCRED'])){
            $Params['FRSMALLCRED']=1;
        } else {
            $Params['FRSMALLCRED']=0;
        }
        
        if (isset($_GET['FREASYCASE'])){
            $Params['FREASYCASE']=1;
        } else {
            $Params['FREASYCASE']=0;
        }
                           
        (new ATP1ContMod())->UpdP1Front($Params,$_GET['ContCode']);
        
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
        
    public function actionChangeSum(){
        $Params=[
            'FRCONTSUM'=>$_GET['FRCONTSUM']            
        ];
        (new ATP1ContMod())->UpdP1Front($Params,$_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionSaveCalend(){
        $this->FrontSave();
        $this->SaveTypeCalend();
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }    
    
    public function SaveTypeCalend(){
        $Cont=new ContP1($_GET['ContCode']);
        
        
        if  (in_array($Cont->getFront()->FRCONTPAC,['pac105','pac106','pac107','pac108'])){
            $Period=$Cont->getFront()->FRCONTPERIOD;
            
            if ((isset($_GET['FIRSTPAYSUM']))&&($_GET['FIRSTPAYSUM']!='')){
                $FirstPaySum=$_GET['FIRSTPAYSUM'];                
            }else{
                $FirstPaySum=9000;
            }
            
            $PaySum=round(($Cont->getFront()->FRCONTSUM-$FirstPaySum)/$Period,-2);
            $PayLeft=$Cont->getFront()->FRCONTSUM-$FirstPaySum;
            if ($Cont->getFront()->FRCONTDATE!=null){
                $PayDate=new DateTime($Cont->getFront()->FRCONTDATE);
            }else{
                $PayDate=new DateTime(date("d.m.Y"));
            }
            $Model=new PayCalend();
            $Model->delAllPlanPays($_GET['ContCode']);
            //сохранение первого платежа
            $Model->addPlanPay($_GET['ContCode'],0,$FirstPaySum,$PayDate->format('d.m.Y'));
            $PayDate=(new ConvertFunctions())->AddMonth($PayDate);

            //сохранение последующих платежей
            for ($i=1; $i<=$Period; $i++){
                $j=$i-1;
                if ($i<$Period){
                    $Model->addPlanPay($_GET['ContCode'],$i,$PaySum,$PayDate->format('d.m.Y'));
                } else {
                    $Model->addPlanPay($_GET['ContCode'],$i,$PayLeft-$PaySum*($i-1),$PayDate->format('d.m.Y'));
                }
                $PayDate=(new ConvertFunctions())->AddMonth($PayDate);
            }    
        } else {    
            if ($Cont->getFront()->FRCONTPERIOD>1){
                $Period=$Cont->getFront()->FRCONTPERIOD;
            }else{
                $Period=(new TarifP1())->getPac($Cont->getFront()->FRCONTPAC)->PCPERIOD;
            }                       
            $PaySum=round($Cont->getFront()->FRCONTSUM/$Period,-2);
            $PayLeft=$Cont->getFront()->FRCONTSUM;
            if ($Cont->getFront()->FRCONTDATE!=null){
                $PayDate=new DateTime($Cont->getFront()->FRCONTDATE);
            }else{
                $PayDate=new DateTime(date("d.m.Y"));
            }
            $Model=new PayCalend();
            $Model->delAllPlanPays($_GET['ContCode']);
            for ($i=1; $i<=$Period; $i++){
                $j=$i-1;
                if ($i<$Period){
                    $Model->addPlanPay($_GET['ContCode'],$i,$PaySum,$PayDate->format('d.m.Y'));
                } else {
                    $Model->addPlanPay($_GET['ContCode'],$i,$PayLeft-$PaySum*($i-1),$PayDate->format('d.m.Y'));
                }
                $PayDate=(new ConvertFunctions())->AddMonth($PayDate);
            }
        }       
    }
        
    public function actionDelCalend(){
        (new PayCalend())->delAllPlanPays($_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionAddIndPayCalend(){//Сформировать индивидуальный график
        #new MyCheck($_GET,0);
        $ContCode=$_GET['ContCode'];
        $Model=new PayCalend();
        $FirstPay=0;
        if (isset($_GET['FIRSTPAYSUM'])){
            $FirstPay=$_GET['FIRSTPAYSUM'];
            $PayDate=new DateTime($_GET['ContDate']);
            $Model->addPlanPay($ContCode,0,$FirstPay,$PayDate->format('d.m.Y'));
        }
        $Num=$_GET['PayCount'];
        $PayNum=$_GET['PayNum'];
        
        if ((isset($_GET['CalendType']))&&($_GET['CalendType']=='AnnSum')){
            $PaySum=$_GET['PaySum'];
        } elseif ((isset($_GET['CalendType']))&&($_GET['CalendType']=='TotSum')){
            $PaySum=($_GET['PaySum']-$FirstPay)/$Num;
        }
                
        $PayDate=new DateTime($_GET['PayDate']);          
        for ($i=1; $i<=$Num; $i++){                        
            $Model->addPlanPay($ContCode,$PayNum+$i-1,$PaySum,$PayDate->format('d.m.Y'));
            
            $PayMonth=substr($PayDate->format('d.m.Y'),3,2);
            if(substr($PayMonth,0,1)==0){
                $PayMonth=substr($PayMonth,1,1);
            } 
            
            $PayDate->modify("+1 month");
            
            $PayMonthNew=substr($PayDate->format('d.m.Y'),3,2);
            if(substr($PayMonthNew,0,1)==0){
                $PayMonthNew=substr($PayMonthNew,1,1);
            }
                      
            while ($PayMonthNew-1>$PayMonth){
                $PayDate->modify("-1 day");
                $PayMonthNew=substr($PayDate->format('d.m.Y'),3,2);
                if(substr($PayMonthNew,0,1)==0){
                    $PayMonthNew=substr($PayMonthNew,1,1);
                }
            }            
        }
        
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
        
    public function actionAddPayCalend(){//добавить платёж в график
        $Model=new PayCalend();
        $Model->addPlanPay($_GET['ContCode'],$_GET['PayNum'],$_GET['PaySum'],$_GET['PayDate']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionUpdPayCalend(){//исправить
        $Model=new PayCalend();
        $Model->updPlanPay($_GET['PayNum'],$_GET['PayDate'],$_GET['PaySum'],$_GET['ContCode'],$_GET['ID']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionDelPayCalend(){//удалить платёж из графика
        $Model=new PayCalend();
        $Model->delPlanPay($_GET['ContCode'],$_GET['ID']);
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
    
    public function actionRequestDiscount(){        
        $Params=[
            'FRDISCSUM'=>$_GET['FRDISCSUM'],
            'FRDISCCOMMENT'=>$_GET['FRDISCCOMMENT'],
            'FRDISCQUERYDATE'=>Date("d.m.Y"),            
        ];        
        (new ATP1ContMod())->UpdP1Front($Params,$_GET['ContCode']);
        
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionApproveDiscount(){
        $Params=[
            'FRDISCAPPROVECOMMENT'=>$_GET['FRDISCAPPROVECOMMENT'],
            'FRDISCAPPROVEEMP'=>$_SESSION['EmName'],
            'FRDISCAPPROVEDATE'=>Date("d.m.Y"),            
        ];        
        (new ATP1ContMod())->UpdP1Front($Params,$_GET['ContCode']);
        
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionDelDiscount(){
        (new P1DiscountMod())->delDiscount($_GET['DiscId']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionContSigned(){       
        $Cont=new ContP1($_GET['ContCode']);
                
        $this->FrontSave([
            'CONTCODE'=>$_GET['ContCode'],
            'FRCONTDATE'=>$_GET['FRCONTDATE'],
            'FRCONTFIRSTSUM'=>$Cont->getFront()->FRCONTSUM,            
        ]);
        (new Status())->ChangeP1Status(15, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionDovGet(){
        $this->FrontSave();
        (new Status())->ChangeP1Status(19, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }

    public function actionAddPayment(){        
        (new Payment($_GET['ClCode'],$_GET['ContCode'],$_SESSION['EmBranch'],$_SESSION['EmName'],1,$_GET['PAYCONTTYPE'],$_GET['PAYSUM'],'','',$_GET['PAYMETHOD']))->addPayment();
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionDelPayment(){
        if (in_array($_SESSION['EmRole'],['top','admin'])){
            (new PaymentMod())->updPaymentLg($_GET['PayId'],$_GET['ContCode'],$_SESSION['EmName']);
            (new PaymentMod())->delPayment($_GET['PayId'],$_GET['ContCode']);
        }
        #header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionDownloadPayBill(){
        $DocName=UPPER_ROOT.'/payments/'.$_GET['PayID'];
        if(file_exists(UPPER_ROOT.'/payments/'.$_GET['PayID'].'.xlsx')){
            header("Location: ".'payments/'.$_GET['PayID'].'.xlsx');
        } else {
            (new Payment($_GET['ClCode'],$_GET['ContCode'],$_SESSION['EmBranch'],$_SESSION['EmName'],1,1,0))->formPayBill($_GET['PayID'],$_GET['ContCode'],1);
            
            header("Location: ".'payments/'.$_GET['PayID'].'.xlsx');
        }
        
    }
    public function actionFormPayBill(){
        (new Payment($_GET['ClCode'],$_GET['ContCode'],$_SESSION['EmBranch'],$_SESSION['EmName'],1,1,0))->formPayBill($_GET['Id'],$_GET['ContCode'],1);
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
    
    public function actionWorkBrake2(){
        $this->FrontSave();
        (new Status())->ChangeP1Status(99, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionWorkBrake(){
        $this->FrontSave();
        (new Status())->ChangeP1Status(91, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionExpBrake(){
        $this->FrontSave();
        (new Status())->ChangeP1Status(97, $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionContStopPay(){        
        (new Status())->ChangeP1Status(89, $_GET['ContCode']);
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
