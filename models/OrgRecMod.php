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
}
