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
class ATContP1AnketaCtrl extends ControllerMain {
    protected $ClCode;
    protected $ContCode;
    
    protected $Params=[];
    protected $Cont=[];    
    protected $Anketa=[];    
    protected $Client=[];
    protected $CredList=[];
    protected $CredDocList=[];
    
    public function __construct(){
        if (isset($_GET['ClCode'])){
            $this->ClCode=$_GET['ClCode'];
        }
        if (isset($_GET['ContCode'])){
            $this->ContCode=$_GET['ContCode'];
        }
    }
    

    public function actionIndex(){        
        $this->LoadData();
        
        $this->ViewName='Анкета договора '.$this->Cont->CONTCODE;
        $args=['Client'=>$this->Client,'Cont'=>$this->Cont,'Anketa'=>$this->Anketa,'CredList'=>$this->CredList,'CredDocList'=>$this->CredDocList];        
        $this->render('ATContP1Anketa',$args);
    }
    
    public function actionNewCred(){
        $Model=new ATP1CredMod();
        $Model->InsP1Credit($this->ContCode);
        
        $this->UpdCredInfo();
        
        header("Location: index_admin.php?controller=ATContP1AnketaCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionCopyCred(){
        $Model=new ATP1CredMod();
        $Model->CopyP1Credit($_GET['CrCode']);
                
        header("Location: index_admin.php?controller=ATContP1AnketaCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionUpdCred(){
        $Model=new ATP1CredMod();
        $Model->UpdP1Credit(['CRBANKCONTTYPE'=>$_GET['CRBANKCONTTYPE'],'CRBANKCONTNAME'=>$_GET['CRBANKCONTNAME'],'CRBANKCONTINN'=>$_GET['CRBANKCONTINN'],
            'CRCONTNUM'=>$_GET['CRCONTNUM'],'CROPENDAT'=>$_GET['CROPENDAT'],'CROPENDAT'=>$_GET['CROPENDAT'],
            'CRBANKCURTYPE'=>$_GET['CRBANKCURTYPE'],'CRBANKCURNAME'=>$_GET['CRBANKCURNAME'],'CRBANKCURINN'=>$_GET['CRBANKCURINN'],
            'CRPROG'=>$_GET['CRPROG'],'CRSUM'=>$_GET['CRSUM'],'CRRATE'=>$_GET['CRRATE'],'CRPERIOD'=>$_GET['CRPERIOD'],
            'CRSUMREST'=>$_GET['CRSUMREST'],'CRSUMRESTMAIN'=>$_GET['CRSUMRESTMAIN'],'CRPAYSUM'=>$_GET['CRPAYSUM'],'CRPAYDAY'=>$_GET['CRPAYDAY'],
            'CRPAYLASTSUM'=>$_GET['CRPAYLASTSUM'],'CRPAYLASTDAT'=>$_GET['CRPAYLASTDAT'],'CRDELAYYN'=>$_GET['CRDELAYYN'],
            
            'CRCARDLIMITSUM'=>$_GET['CRCARDLIMITSUM'],'CRCARDUSEDSUM'=>$_GET['CRCARDUSEDSUM'],'CRCARDMINPAY'=>$_GET['CRCARDMINPAY']
                ],$_GET['CRCODE']);
        
        $this->UpdCredInfo();
        
        //меняем название банка на офф.
        $BankCont=(new DrBanksMod())->getByINN($_GET['CRBANKCONTINN']);
        $BankCur=(new DrBanksMod())->getByINN($_GET['CRBANKCURINN']);
        if ($BankCont){
            $Model->UpdBankCont($_GET['CRCODE'], $BankCont->BNNAME, $BankCont->BNTYPE, $BankCont->BNINN);
        }
        if ($BankCur){
            $Model->UpdBankCur($_GET['CRCODE'], $BankCur->BNNAME, $BankCur->BNTYPE, $BankCur->BNINN);
        }
        header("Location: index_admin.php?controller=ATContP1AnketaCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionUpdCredAdd(){
        $Model=new ATP1CredMod();
        $Model->UpdP1Credit(['CRREASON'=>$_GET['CRREASON'],'CRREASONCOMMENT'=>$_GET['CRREASONCOMMENT'],'CRCONTDOCSYN'=>$_GET['CRCONTDOCSYN'],'CRWARRANTYN'=>$_GET['CRWARRANTYN'],
            'CRWARRANTNAME'=>$_GET['CRWARRANTNAME'],'CRCODEWORD'=>$_GET['CRCODEWORD'],'CRWORKORG'=>$_GET['CRWORKORG'],'CRCONTWORKREALYN'=>$_GET['CRCONTWORKREALYN'],
            'CRINCOMEDOC'=>$_GET['CRINCOMEDOC'],'CRINCOMEOFSUM'=>$_GET['CRINCOMEOFSUM'],'CRINCOMEREALSUM'=>$_GET['CRINCOMEREALSUM'],
            'CRCOURTDESTYPE'=>$_GET['CRCOURTDESTYPE'],'CRCOURTDESDATE'=>$_GET['CRCOURTDESDATE'],
            'CRPLEDGEYN'=>$_GET['CRPLEDGEYN'],'CRPLEDGE'=>$_GET['CRPLEDGE'],'CRCOLLAGYN'=>$_GET['CRCOLLAGYN'],'CRCOLLAGNAME'=>$_GET['CRCOLLAGNAME']
            ],$_GET['CRCODE']);
        
        $this->UpdCredInfo();
        
        header("Location: index_admin.php?controller=ATContP1AnketaCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
       
    public function actionDelCred(){
        $Model=new ATP1CredMod();
        $Model->DelP1Credit($_GET['CrCode']);
        header("Location: index_admin.php?controller=ATContP1AnketaCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
        
    public function actionNewCredDoc(){
        $Model=new ATP1CredMod();
        $Model->InsCrDoc($_GET['ContCode'],$_GET['CRCODE'],$_GET['CRDOCNAME'],$_GET['CRDOCPAGES'],$_GET['CRDOCNUM'],$_GET['CRDOCDATE']);
        header("Location: index_admin.php?controller=ATContP1AnketaCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function actionDelCredDoc(){
        $Model=new ATP1CredMod();
        $Model->DelCredDoc($_GET['CrDocId'],$_GET['ContCode']);
        header("Location: index_admin.php?controller=ATContP1AnketaCtrl&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}");
    }
    
    public function ChangeStatus($StatNum){
        (new ATP1ContMod)->ChangeStatus($StatNum,$this->ContCode);
    }

    protected function LoadData(){       
        $Model=new ATClientMod();
        $this->Client=$Model->GetClientById($this->ClCode);
        
        $Model=new ATP1ContMod();
        $this->Cont=$Model->GetCont($this->ContCode);        
        $this->Anketa=$Model->GetAnketa($this->ContCode);        
        
        $Model=new ATP1CredMod();
        $this->CredList=$Model->GetP1CredList($this->ContCode);
        $this->CredDocList=[];
        foreach($this->CredList as $Cred){
            $this->CredDocList[$Cred->CRCODE]=$Model->GetCrDocList($Cred->CRCODE);            
        }
    }
    
    protected function UpdCredInfo(){
        $this->LoadData();
        $CredNum=0;
        $CredTotal=0;
        $CredMain=0;
        $PayTotal=0;
        foreach($this->CredList as $Cred){
            $CredNum=$CredNum+1;
            $CredTotal=$CredTotal+$Cred->CRSUMREST;
            $CredMain=$CredMain+$Cred->CRSUMRESTMAIN;
            $PayTotal=$PayTotal+$Cred->CRPAYSUM;
        }
        
        $Model=new ATP1ContMod();
        $Model->UpdP1Anketa(['AKCREDNUM'=>$CredNum,'AKCREDTOTSUM'=>$CredTotal,'AKCREDMAINSUM'=>$CredMain],$_GET['ContCode']);
        (new ATP1ContMod())->UpdP1Expert1([$CredTotal,$CredMain,$PayTotal,$_GET['ContCode']]);
    }
                
}
