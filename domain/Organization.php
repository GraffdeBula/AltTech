<?php

#namespace AltTech\Domain;
/**
 *для создания объекта "организация" и его использования в других классах
 *
 * @author Andrey
 */
class Organization {
    protected $Rec;
    
    public function __construct($OrgPref){
        $this->Rec=(new OrgRecMod())->getOrgByPref($OrgPref);
    }
    
    public function getRec(){
        return $this->Rec;
    }
    
}
