<?php

/**
 * Description of OrgRec
 *
 * @author Andrey
 */
class OrgRecMod {
    public $Data=[];
    
    public function getOrg($OrgPref){ //метод возвращает строку из таблицы OrgRec    
        $pref=iconv('UTF-8','windows-1251',$OrgPref);
        return $this->Data=db::getInstance()->fetch_one("SELECT * FROM tblOrgRec WHERE orgPref='{$pref}'");                
    }
    
    //новая база
    public function getOrgByPref($OrgPref){//метод возвращает строку из таблицы OrgRec    
        return db2::getInstance()->FetchOne("SELECT * FROM tbl9DrOrgRec WHERE orgPref=?",[$OrgPref]);
    }
    
    public function getOrgById($Id){//метод возвращает строку из таблицы OrgRec    
        return db2::getInstance()->FetchOne("SELECT * FROM tbl9DrOrgRec WHERE ID=?",[$Id]);
    }
    
    public function getOrgList(){//метод возвращает список из таблицы OrgRec    
        return db2::getInstance()->FetchAll("SELECT * FROM tbl9DrOrgRec",[]);
    }
    
    public function addOrg($OrgName){
        db2::getInstance()->Query("INSERT INTO tbl9DrOrgRec (OrgName) VALUES (?)",[$OrgName]);
    }
    
    public function updOrg($Params=[],$Id){
        $NewParams=[];
        $SqlAdd='';
        $NewParams['ID']=$Id;
        foreach($Params as $Key => $Param){
            $NewParams[$Key]=$Param;
            $SqlAdd=$SqlAdd.',$Key=?';
        }
        $NewParams[]=$Id;
        db2::getInstance()->Query("UPDATE tbl9DrOrgRec SET ID=?".$SqlAdd." WHERE ID=?",[$NewParams]);
    }
    
    public function delOrgOrg($Id){
        db2::getInstance()->Query("DELETE FROM tbl9DrOrgRec WHERE ID=?",[$Id]);
    }
    
}
