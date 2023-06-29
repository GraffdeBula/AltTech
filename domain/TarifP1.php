<?php

#namespace AltTech\Domain;

/**
 * Description of ContP1
 *
 * @author Andrey
 */
class TarifP1 {
    protected $TarifList;
    protected $TarifFullList;
    protected $PacList;
    protected $Pac;
        
    public function __construct(){
        $this->TarifList=(new TarifMod())->getTarifList();
        $this->TarifFullList=(new TarifMod())->getTarifFullList();
        $this->PacList=(new TarifMod())->getPacList();        
    }
    
    public function getTarifList(){
        return $this->TarifList;
    }
    
    public function getTarifFullList(){
        return $this->TarifFullList;
    }
    
    public function getPacList(){
        return $this->PacList;
    }
        
    public function getTarif($TrName,$DebtSum){        
        return (new TarifMod())->getTarif($TrName,$DebtSum);
    }
    
    public function getTarifContType($Pac,$Branch){        
        return (new TarifMod())->getPacBranch($Pac,$Branch);
    }
    
    public function getPac($PacName){
        return (new Pacs())->getPacByName($PacName);
    }
}
