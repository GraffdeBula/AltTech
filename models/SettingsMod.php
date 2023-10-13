<?php

/**
 * модель для проверки авторизации
 * 
 * @author Andrey
 */
class SettingsMod {
    public function getSettings($SetType){
        $Sql="SELECT * FROM tbl0Settings WHERE SetType=?";
        return db2::getInstance()->FetchAll($Sql,[$SetType]);            
    }
    
    public function addSettings($SetType,$SetComment,$SetValue){
        $Sql="INSERT INTO tbl0Settings (SetType,SetComment,SetValue) VALUES (?,?,?)";
        db2::getInstance()->Query($Sql,[$SetType,$SetComment,$SetValue]);
    }
}
