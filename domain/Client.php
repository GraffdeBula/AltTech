<?php

#namespace AltTech\Domain;

/**
 * Description of Client
 *
 * @author Andrey
 */
class Client {
    public $ClRec=[];
    protected $Pasport=[];
    protected $Phone;
    protected $Adr=[];
    protected $IncomeList;
    protected $PropertyList;
    protected $DealList;
    protected $DocList;
    protected $PhoneList;
    protected $RelativeList;
    protected $BankAccList;
    
    public function __construct($ClCode) {
        $this->ClRec=(new ATClientMod())->GetClientById($ClCode);        
        $this->Adr=new ClientRec();
        $this->Adr->CLADRREG=$this->ClRec->CLADRRZIP.
                ", ".$this->ClRec->CLADRRREG.
                ", ".$this->ClRec->CLADRRDIST.
                ", ".$this->ClRec->CLADRRCITY.
                ", ул.".$this->ClRec->CLADRRSTR.
                " д.".$this->ClRec->CLADRRHOUSE.
                " кв.".$this->ClRec->CLADRRAPP;
        
        $this->Adr->CLADRFACT=$this->ClRec->CLADRFZIP.
                ", ".$this->ClRec->CLADRFREG.
                ", ".$this->ClRec->CLADRFDIST.
                ", ".$this->ClRec->CLADRFCITY.
                ", ул.".$this->ClRec->CLADRFSTR.
                " д.".$this->ClRec->CLADRFHOUSE.
                " кв.".$this->ClRec->CLADRFAPP;
        $this->Pasport=(new ATClientMod())->getDocument($ClCode,'паспорт');
        $this->Phone=(new ATClientMod())->getPhone($ClCode,'мобильный');
        if (!$this->Phone){
            $this->Phone=new ClientRec();
        }
        //get lists
        $this->IncomeList=(new ATClientMod())->GetClIncomesList($ClCode);
        $this->PropertyList=(new ATClientMod())->GetClPropertyList($ClCode);
        $this->DealList=(new ATClientMod())->GetClDealsList($ClCode);
        $this->DocList=(new ATClientMod())->GetClDocumentsList($ClCode);
        $this->PhoneList=(new ATClientMod())->GetClPropertyList($ClCode);
        $this->RelativeList=(new ATClientMod())->GetClRelativesList($ClCode);
        $this->BankAccList=(new ATClientMod())->GetClBankAccsList($ClCode);
        #var_dump($this->ClRec);
        #echo("<br>===============================<br>");
        #var_dump($this->Adr);
        #exit();
    }
    
    public function getClRec(){
        return $this->ClRec;
    }
    
    public function getPasport(){
        return $this->Pasport;
    }
    
    public function getContPhone(){
        return $this->Phone;
    }
    
    public function getAdr(){
        return $this->Adr;
    }
    
    public function getIncomeList(){
        return $this->IncomeList;
    }
    
    public function getPropertyList(){
        return $this->PropertyList;
    }
    
    public function getDealList(){
        return $this->DealList;
    }
    
    public function getDocList(){
        return $this->DocList;
    }
    
    public function getPhoneList(){
        return $this->PhoneList;
    }
    
    public function getRelativeList(){
        return $this->RelativeList;
    }
    
    public function getBankAccList(){
        return $this->BankAccList;
    }
}
