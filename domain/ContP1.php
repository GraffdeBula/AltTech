<?php

#namespace AltTech\Domain;

/**
 * Description of ContP1
 *
 * @author Andrey
 */
class ContP1 {
    protected $Anketa;
    protected $Front;
    protected $Expert;
    protected $BackOf;
    protected $RiskList;
    protected $RiskList2;
    protected $MinIncList;
    protected $CredList;
    protected $CreditList;
    protected $DopContList;
    protected $Pac;
    protected $PayCalend=[];
    protected $PayList=[];
    protected $FirstPaySum=0;
    
    protected $Discounts=[];
    protected $DDiscounts=0;
    public $Credit=[];
    public $CreditPays=[];
    
    public function __construct($ContCode){
        $this->Anketa=(new ATP1ContMod())->GetAnketa($ContCode);
        $this->Front=(new ATP1ContMod())->GetFront($ContCode);
        $this->Expert=(new ATP1ContMod())->GetExpert($ContCode);
        $this->BackOf=(new ATP1ContMod())->GetBackOf($ContCode);
        
        $this->CreditList=new CreditList($ContCode);
        $this->CredList=$this->CreditList->getCreditList();
        
        $this->RiskList=(new ExpertMod())->GetExpRiskList($ContCode,'Jurist');
        $this->RiskList2=(new ExpertMod())->GetExpRiskList2($ContCode);
        $this->Pac=(new Pacs())->getPacByName($this->Front->FRCONTPAC);
        $this->PayCalend=(new PayCalend())->getPayCalend($ContCode);        
        $this->PayList=(new PaymentMod())->getPaymentListP1($ContCode);
        $this->Discounts=(new P1DiscountMod())->getDiscount($ContCode);
        $this->DDiscounts=(new P1DiscountMod())->getDDiscount($ContCode)->DISCOUNTSUM;
        $this->Credit=(new CreditDTO($ContCode));  
        $this->DopContList=(new ATP1ContMod())->getDopContList($ContCode);
        
        $this->MinIncList=(new ExpertMod)->getExpMinInc($ContCode);
        $NewMinInc=[];
        foreach($this->MinIncList as $Inc){
            $NewMinInc[$Inc->EXLISTVALUE]=$Inc->EXLISTVALUE2;
        }
        $this->MinIncList=$NewMinInc;
        if (isset($this->PayCalend[0]->PAYSUM)){
            $this->FirstPaySum=['FIRSTPAYSUM'=>$this->PayCalend[0]->PAYSUM];
        }else{
            $this->FirstPaySum=['FIRSTPAYSUM'=>0];
        }
        
    }
    
    public function getAnketa(){
        return $this->Anketa;
    }
    
    public function getFront(){
        return $this->Front;
    }
    
    public function getBackOf(){
        return $this->BackOf;
    }
    
    public function getExpert(){
        return $this->Expert;
    }
    
    public function getRiskList(){
        return $this->RiskList;
    }
    
    public function getRiskList2(){
        return $this->RiskList2;
    }
    
    public function getMinIncList(){
        return $this->MinIncList;
    }
    
    public function getCredList(){
        return $this->CredList;
    }
    
    public function getCreditList(){
        return $this->CreditList;
    }
    
    public function getDopContList(){
        return $this->DopContList;
    }
    
    public function getDopContSum(){
        return $this->DopContList;
    }
    
    public function getPac(){
        return $this->Pac;
    }

    public function getPayCalend(){
        return $this->PayCalend;
    }
    
    public function getFirstPaySum(){
        return $this->FirstPaySum;
    }
    
    public function getPayList(){
        return $this->PayList;
    }
    
    public function getDiscounts(){
        return $this->Discounts;
    }
    
    public function updFirstPayDate(){
            
    }
    
}
