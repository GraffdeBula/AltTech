<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExpRepMod
 *
 * @author Andrey
 */
class ExpReportMod extends Model{
    protected $Data=[];
    
    public function GetReport(){
        return $this->Data=db::getInstance()->fetch_all("SELECT FIRST 500 * FROM vwReportExp ORDER BY ContCode DESC;");
    }
    
    public function FullList(){
        return $this->Data=db::getInstance()->fetch_all("SELECT *  FROM vwReportExp;");
    }
}
