<?php

#namespace AltTech\Domain;

/**
 * Description of ContP4
 *
 * @author Andrey
 */
class ContP4 {
    protected $Anketa;
    protected $Front;
    protected $Expert;
    protected $RiskList;
    protected $MinIncList;
    protected $CredList;
    protected $Pac;
    protected $PayCalend=[];
    protected $Discounts=[];
    
    public function __construct($ContCode){
        $this->Anketa=(new ATP4ContMod())->getAnketaByCode($ContCode);
        $this->Front=(new ATP4ContMod())->getFrontByCode($ContCode);
                                        
    }
    
    public function getAnketa(){
        return $this->Anketa;
    }
    
    public function getFront(){
        return $this->Front;
    }
    
    public function getExpert(){
        return $this->Expert;
    }
    
    public function getRiskList(){
        return $this->RiskList;
    }
    
    public function getMinIncList(){
        return $this->MinIncList;
    }
    
    public function getCredList(){
        return $this->CredList;
    }
    
    public function getPac(){
        return $this->Pac;
    }

    public function getPayCalend(){
        return $this->PayCalend;
    }
    public function getDiscounts(){
        return $this->Discounts;
    }
    
}
