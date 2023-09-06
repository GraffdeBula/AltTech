<?php

#namespace AltTech\Domain;
/**
 *для создания объекта "организация" и его использования в других классах
 *
 * @author Andrey
 */
class OrganizationOther {
    protected $OrgId;
    protected $OrgType;
    protected $OrgName;
    protected $OrgAdrName;
    protected $OrgAddress;
    protected $OrgPhone;
    protected $OrgRegion;
    
    protected $OrgRec;    
    
    public function __construct($OrgType,$OrgRegion){
        $this->Rec=(new OrganizationsMod())->getOrgByTypeRegion($OrgType,$OrgRegion);
        
    }
    
    public function getRec(){
        return $this->Rec;
    }
    
}
