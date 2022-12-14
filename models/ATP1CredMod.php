<?php

/**
 * модель работы с кредитами (
 *
 * @author andrey
 */
class ATP1CredMod extends Model{
    public $CrCode;
    public $ContCode;
    public $Cred;
    protected $Data=[];
    
    public function GetP1CredList($ContCode){ //получение списка 
        $Sql="SELECT * FROM tblP1Credits WHERE ContCode=? ORDER BY CrCode;";                
        $Params=[$ContCode];
        return $this->Data=db2::getInstance()->FetchAll($Sql,$Params);    
    }
    
    public function GetP1CredList($ContCode){ //получение списка 
        $Sql="SELECT * FROM tblP1Credits WHERE ContCode=? ORDER BY CrCode;";                

        return $this->Data=db2::getInstance()->FetchAll($Sql,[$ContCode]);    
    }
    
    public function GetP1Credit($CrCode){ 
        $Sql="SELECT * FROM tblP1Credits WHERE CrCode=?;";                
        $Params=[$CrCode];
        return $this->Data=db2::getInstance()->FetchOne($Sql,$Params);        
    }
    
    public function InsP1Credit($ContCode){
        $Sql="INSERT INTO tblP1Credits (ContCode,lgEmp) values (?,?)";
        $Params=[$ContCode,'admin'];
        db2::getInstance()->Query($Sql,$Params); 
    }
    
    public function UpdP1Credit($Param,$CrCode){             
        $Sql="UPDATE tblP1Credits SET lgEmp='{$_SESSION['EmName']} and lgDat=CURRENT_TIMESTAMP";
        $Params=[];
        foreach($Param as $key=>$value){
            $Sql=$Sql.", {$key}=?";            
            $Params[]=$value;                        
        }
        $Sql=$Sql." WHERE CrCode=?";
        $Params[]=$CrCode;      
          
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function UpdBankCont($CrCode,$BnName,$BnType,$BnINN){
        $Sql="UPDATE tblP1Credits SET CrBankContName=?, CrBankContType=?, CrBankContINN=? WHERE CrCode=?";
        $Params=[$BnName,$BnType,$BnINN,$CrCode];
        db2::getInstance()->Query($Sql,$Params);
    }
    public function UpdBankCur($CrCode,$BnName,$BnType,$BnINN){
        $Sql="UPDATE tblP1Credits SET CrBankCurName=?, CrBankCurType=?, CrBankCurINN=? WHERE CrCode=?";
        $Params=[$BnName,$BnType,$BnINN,$CrCode];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function DelP1Credit($CrCode){
        $Sql="DELETE FROM tblP1Credits WHERE CrCode=?";
        $Params=[$CrCode];
        db2::getInstance()->Query($Sql,$Params);  
    }
    //получение списка документов
    public function GetCrDocList($CrCode){
        return db2::getInstance()->FetchAll('SELECT * FROM tblP1CrDocs WHERE CrCode=? ORDER BY ID',[$CrCode]);
    }
    //сохранение документа в список
    public function InsCrDoc($ContCode,$CrCode,$CrDocName,$CrDocPages,$CrDocNum,$CrDocDate){
        $Sql="INSERT INTO tblP1CrDocs (ContCode,CrCode,CrDocName,CrDocPages,CrDocNum,CrDocDate)VALUES (?,?,?,?,?,?)";
        $Params=[$ContCode,$CrCode,$CrDocName,$CrDocPages,$CrDocNum,$CrDocDate];
        db2::getInstance()->Query($Sql,$Params);
    }
    //работа со списками для анкеты
    public function GetAnketaDr($DrName){ //получить справочник списков
        return db2::getInstance()->FetchAll('SELECT * FROM tbl1DrAnketaList WHERE DrName=? ORDER BY ID',[$DrName]);
    }
    
    public function GetAnketaDrList(){ //получить справочник списков
        return db2::getInstance()->FetchAll('SELECT * FROM tbl1DrAnketaList ORDER BY ID DESC',[]);
    }
    
    public function AddAnketaDr($DrName,$DrValue){//добавить запись в справочник
        return db2::getInstance()->Query('INSERT INTO tbl1DrAnketaList (DrName,DrValue) VALUES (?,?)',[$DrName,$DrValue]);
    }
    
    public function DelAnketaDr($DrID){//удалить запись из справочника
        return db2::getInstance()->Query('DELETE FROM tbl1DrAnketaList WHERE id=?',[$DrID]);
    }
}
