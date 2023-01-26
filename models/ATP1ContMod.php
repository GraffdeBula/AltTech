<?php

/**
 * модель получения данных по договору БФЛ
 * Анкета
 * Фронт
 * Экспертиза
 *
 * @author andrey
 */
class ATP1ContMod extends Model{
    public $ClCode;
    protected $Data=[];
    
    public function GetP1ContList($ClCode){
        $Sql="SELECT * FROM vwP1ContList WHERE ClCode=?;";                
        $Params=[$ClCode];
        return $this->Data=db2::getInstance()->FetchAll($Sql,$Params);    
    }
    
    public function GetAnketa($ContCode){ //метод возвращает строку из таблицы p1Anketa
        $Sql="SELECT * FROM tblP1Anketa WHERE ContCode=?";
        $Params=[$ContCode];
        return $this->Data=db2::getInstance()->FetchOne($Sql,$Params);       
    }

    public function GetFront($ContCode){ //метод возвращает строку из таблицы p1Front
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM tblP1Front WHERE contCode='{$ContCode}';");        
    }

    public function GetExpert($ContCode){ //метод возвращает строку из таблицы p1Expert
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM tblP1Expert WHERE contCode='{$ContCode}';");        
    }
    
    public function GetCont($ContCode){ 
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM vwP1ContList WHERE contCode='{$ContCode}';");        
    }
    
    public function InsP1Anketa($ClCode,$Branch,$Emp){
        $Sql="INSERT INTO tblP1Anketa (ClCode,AkBranch,lgEmp) values (?,?,?)";
        $Params=[$ClCode,$Branch,$Emp];
        db2::getInstance()->Query($Sql,$Params); 
    }
    
    public function UpdP1Anketa($Param=[],$ContCode){
        $Sql="UPDATE tblP1Anketa SET lgdat=current_timestamp";
        $Params=[];
        foreach($Param as $Key=>$Value){
            $Sql=$Sql.", {$Key}=?";
            $Params[]=$Value;
            
        }
        $Sql=$Sql." WHERE ContCode=?";
        $Params[]=$ContCode;
        db2::getInstance()->Query($Sql,$Params); 
    }

    public function UpdP1Status($StatNum,$ContCode){
        $Sql="UPDATE tblP1Anketa SET Status=? WHERE ContCode=?";
        db2::getInstance()->Query($Sql,[$StatNum,$ContCode]);
    }
    
    public function UpdP1Expert($Params=[]){
        $Sql="UPDATE tblP1Expert SET EXTOTDEBTSUM=?, EXMAINDEBTSUM=?, EXANNTOTPAY=?,EXANNTOTINC=?, EXPRODREC=?, EXRES=?  WHERE ContCode=?";
        db2::getInstance()->Query($Sql,$Params); 
    }
    
    public function UpdP1Front($Param=[],$ContCode){                        
        $Sql="UPDATE tblP1Front SET lgEmp='{$_SESSION['EmName']}', lgDat=current_timestamp";
        $Params=[];
        foreach($Param as $Key=>$Value){
            $Sql=$Sql.", {$Key}=?";
            $Params[]=$Value;
            
        }
        $Sql=$Sql." WHERE ContCode=?";
        $Params[]=$ContCode;
        
        return $this->Data=db2::getInstance()->Query($Sql,$Params);
    }
    
    public function UpdP1FrontView($ContCode){
        $Sql="UPDATE tblP1Front WHERE contCode=?";
        $Params=[$ContCode];
        db2::getInstance()->Query($Sql,$Params); 
    }
    
    public function DelP1Anketa($ContCode){
        $Sql="DELETE FROM tblP1Anketa WHERE contCode=?";
        $Params=[$ContCode];
        db2::getInstance()->Query($Sql,$Params);  
    }
}
