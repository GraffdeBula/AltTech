<?php

/**
 * модель для работы со статусами
 * в продукте P1
 *
 * @author andrey
 */
class ATP1StatusMod extends Model{    
    protected $Data=[];
    
    public function UpdP1Status($NewStatus,$ContCode){
        $Sql="UPDATE tblP1Anketa SET Status=? WHERE ContCode=?;";                        
        return $this->Data=db2::getInstance()->Query($Sql,[$NewStatus,$ContCode]);    
    }
    
    public function GetP1Status($ContCode){
        $Sql="SELECT Status FROM tblP1Anketa WHERE ContCode=?;";                        
        return $this->Data=db2::getInstance()->FetchOne($Sql,[$ContCode]);    
    }
    
    public function CreateStatus($StatNum=0,$StatStr=''){
        $Sql="INSERT INTO tblP1Status VALUES (?,?)";
        db2::getInstance()->Query($Sql,[$StatNum,$StatStr]);
    }
    
    public function UpdateStatus($StatNum=0,$StatStr=''){
        $Sql="UPDATE tblP1Status SET StatNum=?, Status=?";
        db2::getInstance()->Query($Sql,[$StatNum,$StatStr]);
    }
    
    public function DeleteStatus($StatNum=0,$StatStr=''){
        $Sql="DELETE FROM tblP1Status WHERE StatNum=? OR Status=?";
        db2::getInstance()->Query($Sql,[$StatNum,$StatStr]);
    }
        
}
