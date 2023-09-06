<?php
/**
 * Description of CreditDTO
 * 
 * @author Andrey
 * 
 * в перспективе надо разделить на CreditProcessor (для создания ДТО) и CreditDTO (сама ДТО для передачи данных)
 */
class CreditDTO {
    public $CredSum=0;
    public $CredRate=0;
    public $CredPeriod=0;
    public $CredDate='';
    public $CredPaysList=[];
    
    public function __construct($ContCode) {
        $Model=new P1ContCredMod();
        
        $Cred=$Model->getContCred($ContCode);
        if ($Cred==false){
            $this->CredSum=0;
            $this->CredRate=0;
            $this->CredPeriod=0;            
            $this->CredDate='';            
        }
        if ($Cred){
            $this->CredSum=$Cred->CREDSUM;
            $this->CredRate=$Cred->CREDRATE;
            $this->CredPeriod=$Cred->CREDPERIOD;            
            $this->CredDate=$Cred->CREDDATE;            
        }
        
        $CredList=$Model->getPayCredList($ContCode);
        if ($Cred==false){
            $this->CredPaysList=[];            
        }
        if ($Cred){
            $this->CredPaysList=$CredList;            
        }
                
    }
}
