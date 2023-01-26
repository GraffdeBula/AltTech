<?php

namespace AltTech\Domain;
/**
 *для создания объекта "организация" и его использования в других классах
 *
 * @author Andrey
 */
class Organizaion {
    protected $Rec;
    
    public function __construct($OrgPref){
        $this->Rec=(new OrgRecMod())->getOrg($OrgPref);
    }
    
    public function getRec(){
        return $this->Rec;
    }
    
}
