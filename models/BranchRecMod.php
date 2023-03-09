<?php

#namespace AltTech\Domain;
/**
 * модель получения данных из таблицы Реквизиты филиалов
 *
 * @author Andrey
 */
class BranchRecMod extends Model{
    public $Data=[];
    //функции работы с филиалами в старой БД
    public function getBranch($brName){ //метод возвращает строку из таблицы BranchRec
        $brName=iconv('UTF-8','windows-1251',$brName);
        return $this->Data=db::getInstance()->fetch_one("SELECT * FROM vwBranchRec WHERE brName='{$brName}'");        
    }
    
    public function getBranches(){ //метод возвращает таблицу 
        return $this->Data=db::getInstance()->fetch_all("SELECT * FROM tblBranchRec");        
    }
    
    //функции работы с филиалами в новой БД Client2
    public function getBranchByName($BrName){ //метод возвращает строку из таблицы BranchRec        
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM tbl9DrBranchRec WHERE brName=?",[$BrName]);        
    }
    
    public function getBranchById($Id){ //метод возвращает строку из таблицы BranchRec        
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM tbl9DrBranchRec WHERE ID=?",[$Id]);        
    }
    
    public function getBranchList() {
        return $this->Data=db2::getInstance()->FetchAll("SELECT * FROM tbl9DrBranchRec ORDER BY BrNameOld",[]);
    }
    
    public function updBranch($Params){   
        $Sql="UPDATE tbl9DrBranchRec SET BRNAME=?,BRREGION=?,BRCITY=?,BRNAMEOLD=?,
            BRDIR=?,BRADDRESSFACT=?,BRKPP=?,BRORGPREF=?,
            BRBUCH1=?,BRKASS1=?,BRBUCH2=?,BRKASS2=?
            WHERE ID=?";
        db2::getInstance()->Query($Sql,$Params);
    }
    
}
