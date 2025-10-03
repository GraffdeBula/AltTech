<?php
/**
 * Description of BranchRec
 *
 * @author Andrey
 */
class InfSave{
    protected $Rec;
    protected $BranchList;
    
    public function __construct(){
        
    }
    
    public function insertInf($ContCode,$InfDate,$InfVariable,$InfValue){
        $Sql="INSERT INTO tblP1InfSave (ContCode,InfDate,InfVariable,InfValue) VALUES (?,?,?,?)";
        db2::getInstance()->Query($Sql,[$ContCode,$InfDate,$InfVariable,$InfValue]);
    }

    public function deleteInf(){
        
    }
    
    public function getInf($ContCode){
        $Sql="SELECT * FROM tblP1InfSave WHERE ContCode=?";
        return db2::getInstance()->FetchAll($Sql,[$ContCode]);
    }
}
