<?php

namespace AltTech\Domain;

/**
 * Description of ContP1
 *
 * @author Andrey
 */
class ContP1 {
    protected $Anketa;
    protected $Front;
    protected $Expert;
    
    public function __construct($ContCode){
        $this->Anketa=(new ATP1ContMod())->GetAnketa($ContCode);
        $this->Front=(new ATP1ContMod())->GetFront($ContCode);
        $this->Expert=(new ATP1ContMod())->GetExpert($ContCode);
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
    
}
