<?php


/**
 * контроллер для сбора в БД информации о клиенте
 *
 * @author andrey
 */
class PrintIskCtrl extends Controller{
    protected $Client; //клиент
    protected $ClientPas; //клиент
    protected $ClientPens; //клиент
    protected $ClientInn; //клиент
    protected $ClientAdr; //клиент
    protected $ClientRel; //клиент массив
    protected $Contract;
    protected $Court;
    protected $Nalog;
    protected $Creditors;
    protected $Documents;
    protected $IskPack;
    protected $IskNames;

    protected $Data; //данные для формирования иска
    protected $BookMarks;       
    protected $ClCode;
    protected $ContCode;
    
    public function actionIndex(){
        $this->ClCode=$_GET['ClCode'];
        $this->ContCode=$_GET['ContCode'];
        $this->IskPack=[
            #1=>'6ADEFCFB6-3587-40BF-AC70-0033F3EE87B5',
            2=>'2818C72E-FC0E-39FF-A57F-AA69E9A1B3CB',            
            3=>'16FB5551-717B-363F-9037-BE764201D7AB'
            
        ];
        $this->IskNames=[
            #1=>'Исковое заявление',
            2=>'Приложение 1 кредиторы',
            3=>'Приложение 2 имущество'
            
        ];
        
        if ($this->ContCode<=1){
            $this->actionFormOldIsk();
        } else {
            $this->actionFormIsk();
        }
        
    }
    
    public function actionFormOldIsk(){            
                
        $this->GetData();        
        
        foreach($this->IskPack as $i => $IskDoc){
            $Isk=new DZCtrl(); //создание нового объекта curl для формирования иска            
            $Isk->DocID=$IskDoc;
            $Isk->DocName=$this->Client->CLNAMEIP.' '.$this->IskNames[$i];
            $Isk->Data=$this->CreateData($i);            
            $Isk->run();            
        }
                
        header("Location: https://afpc24.doczilla.pro"); //
    }
    
    public function actionFormIsk(){                
        ####Формирование набора данных для иска
        $this->GetDataNew();        
        
        foreach($this->IskPack as $i => $IskDoc){
            $Isk=new DZCtrl(); //создание нового объекта curl для формирования иска            
            $Isk->DocID=$IskDoc;
            $Isk->DocName=$this->Client->CLFIO.' '.$this->IskNames[$i];
            $Isk->Data=$this->CreateData($i);            
            $Isk->run();            
            
        }

        header("Location: https://afpc24.doczilla.pro"); //
    }
          
    protected function CreateData($i){//
        $this->Data=[];

        foreach ($this->BookMarks[$i] as $BookMark) {                        
            if ($BookMark->BMARRKEY>=0){
                
                if (isset($this->{$BookMark->BMTABLE}[$BookMark->BMARRKEY]->{$BookMark->BMFIELD})){
                    
                    $this->Data[$BookMark->BMNAME]=$this->{$BookMark->BMTABLE}[$BookMark->BMARRKEY]->{$BookMark->BMFIELD};
                } else {
                    
                }
                       
            }
             
            else {
                if (isset($this->{$BookMark->BMTABLE}->{$BookMark->BMFIELD})){
                    $this->Data[$BookMark->BMNAME]=$this->{$BookMark->BMTABLE}->{$BookMark->BMFIELD};               
                }
            }
         
        }    
        
        return $this->Data;
    }
    
    protected function GetDataNew(){
        $IskData=new IskMod();
        $Client=new Client($this->ClCode);
        $this->Client=$Client->getClRec();
        $this->ClientPas=$Client->getPasport();
        $this->ClientPens=$Client->getPens();
        $this->ClientInn=$Client->getINN();
        $this->ClientAdr=$Client->getAdr();
        $this->ClientRel=$Client->getRelativeList();
        
        $Contract=new ContP1($this->ContCode);
        $this->Contract=$Contract->getAnketa();
        $this->Creditors=$Contract->getCredList();
        #var_dump($this->Contract);
        #exit();
        
        $this->BookMarks[1]=$IskData->getBookMarks2_1();
        $this->BookMarks[2]=$IskData->getBookMarks2_2();
        $this->BookMarks[3]=$IskData->getBookMarks2_3();    
    }
    
    protected function GetData(){
        $IskData=new IskMod();
        $this->Client=$IskData->getClient($this->ClCode);
        $this->Contract=$IskData->getContract($this->ContCode);
        $this->Creditors=$IskData->getCreditors($this->ContCode);
        $this->Documents=$IskData->getDocuments($this->ContCode);
        $this->Court=$IskData->getCourt($this->ContCode);
        $this->Nalog=$IskData->getNalog($this->ContCode);
        
        $this->BookMarks[1]=$IskData->getBookMarks1();
        $this->BookMarks[2]=$IskData->getBookMarks2();
        $this->BookMarks[3]=$IskData->getBookMarks3();    
    }
}
