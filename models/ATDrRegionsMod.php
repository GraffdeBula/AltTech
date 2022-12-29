<?php

/**
 * модель для работы с таблицей Регионы (tblDrRegions)
 *
 * @author Andrey
 */
class ATDrRegionsMod extends Model{
    
    public function GetRegList(){
        $Sql='SELECT * FROM tbl9DrRegions';        
        return $this->data=db2::getInstance()->FetchAll($Sql,[]);
    }
    
    public function RegIns($RegName){
        $Sql="INSERT INTO tbl9DrRegions (RegName) VALUES (?)";
        db2::getInstance()->Query($Sql,[$RegName]);
    }
    
    public function RegUpd($RegID,$RegName){
        $Sql="UPDATE tbl9DrRegions SET RegName=? WHERE ID=?";
        db2::getInstance()->Query($Sql,[$RegName,$RegID]);
    }
    
    public function RegDel($RegID){
        $Sql="DELETE FROM tbl9DrRegions WHERE ID=?";
        db2::getInstance()->Query($Sql,[$RegID]);
    }
    
}