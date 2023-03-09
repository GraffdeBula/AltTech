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
}
