<?php

/**
 * модель для работы со статусами
 * в продукте P1
 *
 * @author andrey
 */
class ATP4StatusMod extends Model{    
    protected $Data=[];
    
    public function UpdP4Status($NewStatus,$ContCode){
        $Sql="UPDATE tblP4Anketa SET Status=? WHERE ContCode=?;";                        
        return $this->Data=db2::getInstance()->Query($Sql,[$NewStatus,$ContCode]);    
    }
    
    public function GetP4Status($ContCode){
        $Sql="SELECT Status FROM tblP4Anketa WHERE ContCode=?;";                        
        return $this->Data=db2::getInstance()->FetchOne($Sql,[$ContCode]);    
    }
    
    public function CreateStatus($StatNum=0,$StatStr=''){
        $Sql="INSERT INTO tblP4Status VALUES (?,?)";
        db2::getInstance()->Query($Sql,[$StatNum,$StatStr]);
    }
    
    public function UpdateStatus($StatNum=0,$StatStr=''){
        $Sql="UPDATE tblP4Status SET StatNum=?, Status=?";
        db2::getInstance()->Query($Sql,[$StatNum,$StatStr]);
    }
    
    public function DeleteStatus($StatNum=0,$StatStr=''){
        $Sql="DELETE FROM tblP4Status WHERE StatNum=? OR Status=?";
        db2::getInstance()->Query($Sql,[$StatNum,$StatStr]);
    }
        
}
