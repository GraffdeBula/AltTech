<?php
/**
 * модель для работы с банками
 *
 * @author Andrey
 */
class OrganizationsMod extends Model{
    protected $Data;
    
    public function addOrganization($OrgName='',$OrgType='',$OrgRegion='',$OrgAddress='',$OrgAdrName='',$OrgPhone=''){
        $Sql="INSERT INTO tbl8DROrganizations (OrgName,OrgType,OrgRegion,OrgAddress,OrgAdrName,OrgPhone) VALUES (?,?,?,?,?,?)";
        db2::getInstance()->Query($Sql,[$OrgName,$OrgType,$OrgRegion,$OrgAddress,$OrgAdrName,$OrgPhone]);
    }
    
    public function updOrganization($Id=0,$OrgName='',$OrgType='',$OrgRegion='',$OrgAddress='',$OrgAdrName='',$OrgPhone=''){
        $Sql="UPDATE tbl8DROrganizations SET OrgName=?,OrgType=?,OrgRegion=?,OrgAddress=?,OrgAdrName=?,OrgPhone=? WHERE Id=?";
        db2::getInstance()->Query($Sql,[$OrgName,$OrgType,$OrgRegion,$OrgAddress,$OrgAdrName,$OrgPhone,$Id]);
    }
    
    public function getOrgList(){
        $Sql="SELECT * FROM tbl8DROrganizations WHERE Id>? ORDER BY Id DESC";
        return db2::getInstance()->FetchAll($Sql,[0]);
    }
    
    public function delOrganization($Id){
        $Sql="DELETE FROM tbl8DROrganizations WHERE Id=?";
        db2::getInstance()->Query($Sql,[$Id]);
    }
    
    public function getOrgByTypeRegion($OrgType='',$OrgRegion=''){
        $Sql="SELECT * FROM tbl8DROrganizations WHERE OrgType=? AND OrgRegion=?";
        return db2::getInstance()->FetchOne($Sql,[$OrgType,$OrgRegion]);
    }

}
