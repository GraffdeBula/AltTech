<?php

/**
 * модель получения данных из таблицы Реквизиты филиалов
 *
 * @author Andrey
 */
class BranchRec {
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
    public function GetBranchRec($BrName){ //метод возвращает строку из таблицы BranchRec        
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM vwBranchRec WHERE brName=?",[$BrName]);        
    }
    
    public function GetBranchList() {
        return $this->Data=db2::getInstance()->FetchAll("SELECT * FROM tbl9DrBranchRec ORDER BY BrNameOld",[]);
    }
}
