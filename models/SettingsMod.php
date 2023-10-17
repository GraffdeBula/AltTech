<?php

/**
 * модель для проверки авторизации
 * 
 * @author Andrey
 */
class SettingsMod {
    public function getSettings($SetType){
        $Sql="SELECT * FROM tbl0Settings WHERE SetType=? ORDER BY Id DESC";
        return db2::getInstance()->FetchAll($Sql,[$SetType]);            
    }
    
    public function addSettings($SetType,$SetComment,$SetValue){
        $Sql="INSERT INTO tbl0Settings (SetType,SetComment,SetValue) VALUES (?,?,?)";
        db2::getInstance()->Query($Sql,[$SetType,$SetComment,$SetValue]);
    }
    
    public function delSettings($Id){
        $Sql="DELETE FROM tbl0Settings WHERE Id=?";
        db2::getInstance()->Query($Sql,[$Id]);
    }
}
