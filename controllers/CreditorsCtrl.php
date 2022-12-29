<?php
/**
 * контроллер для работы со списком кредиторов
 *
 * @author Andrey
 */
class CreditorsCtrl extends Controller{    
    protected $ContCode;
    protected $CrCode;
    protected $CreditList;
    protected $BankList;
    
    public function __construct() {
        $this->getBaseParams();
    }
    
    public function actionIndex() {  //показывает весь список кредиторов      
        $this->ContCode=$_GET['CONTCODE'];
        if (isset($_GET['CRUPD']) and ($_GET['CRUPD']=='CRUPD')){
            $this->UpdateCred();            
        }
        $this->getInfo();
        $Credits=['Credits'=>$this->CreditList,'Banks'=>$this->BankList];
        $this->render('ClCredList',$Credits);
    }
    
    public function actionFilter(){ //показывает отфильтрованный список кредиторов
        $Model=new CreditorsMod;
        $this->CreditList=$Model->getCredListFilt($this->ContCode,$_GET['myFilt']);
        $this->BankList=$Model->getBankList($this->ContCode);
        $Credits=['Credits'=>$this->CreditList,'Banks'=>$this->BankList];
        $this->render('ClCredList',$Credits);
    }
    
//    public function actionUpdCred(){ //вносит изменения в кредитора
//        //получаем банк по ИНН
//        $bnINN=$_GET['CRINN'];
//        $Model=new BanksMod();
//        $Bank=$Model->GetByINN($bnINN);        
//        $CrUpd=[$Bank->BNWNAME,$_GET['CRINN'],$_GET['CRDEBTSUM'],$_GET['CRDEBTDELAYSUM'],$_GET['CRDEBTFEESUM'],$this->CrCode];
//             
//        $Model=new CreditorsMod();
//        $Model->updCredit($CrUpd);
//        $Model->UpdCredSum($this->ContCode);
//        $this->actionIndex();
//    }
    
    protected function getInfo(){
        $Model=new CreditorsMod;
        $this->CreditList=$Model->getCredList($this->ContCode);
        $this->BankList=$Model->getBankList($this->ContCode);
    }
    
    public function UpdateCred(){
        //получаем банк по ИНН
        $bnINN=$_GET['CRINN'];
        $Model=new BanksMod();
        $Bank=$Model->GetByINN($bnINN);        
        $CrUpd=[$Bank->BNWNAME,$_GET['CRINN'],$_GET['CRDEBTSUM'],$_GET['CRDEBTDELAYSUM'],$_GET['CRDEBTFEESUM'],$_GET['CRCODE']];

        $Model=new CreditorsMod();
        $Model->updCredit($CrUpd);
        $Model->UpdCredSum($this->ContCode);
    }
    
    public function getBaseParams(){        
        #var_dump($_GET);
        #exit();
        if (isset($_GET['CONTCODE'])){
            $this->ContCode=$_GET['CONTCODE'];
            #$this->CrCode=$_POST['CRCODE'];
        }
        if (isset($_GET['CRCODE'])){
            #$this->ContCode=$_GET['CONTCODE'];
            $this->CrCode=$_GET['CRCODE'];
        }        
                
    }
    
}
