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
    protected $RiskList;
    protected $CredList;
    protected $Pac;
    
    public function __construct($ContCode){
        $this->Anketa=(new ATP1ContMod())->GetAnketa($ContCode);
        $this->Front=(new ATP1ContMod())->GetFront($ContCode);
        $this->Expert=(new ATP1ContMod())->GetExpert($ContCode);
        $this->CredList=(new ATP1CredMod())->GetP1CredList($ContCode);
        $this->RiskList=(new ExpertMod())->GetExpRiskList($ContCode);
        $this->Pac=(new Pacs())->getPacByName($this->Front->FRCONTPAC);
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
    
    public function getCredList(){
        return $this->CredList;
    }
    
    public function getPac(){
        return $this->Pac;
    }
    
}
