<?php

/* модель для работы с таблицей расходов
 * сохранение платеж
 * удаление платежа
 * получение платежа
 * 
 */

class OutcomesMod extends Model{
    
    public function getOutcomes($Branch,$DateF,$DateL){
        if ($Branch==''){
            $Sql='SELECT * FROM tbl6Outcomes WHERE OutDate BETWEEN ? AND ? ORDER BY Id DESC';
            $Params=[$DateF,$DateL];
        } else {
            $Sql='SELECT * FROM tbl6Outcomes WHERE OutBranch=? AND (OutDate BETWEEN ? AND ?) ORDER BY Id DESC';
            $Params=[$Branch,$DateF,$DateL];
        }
        return db2::getInstance()->FetchAll($Sql,$Params);                
    }
    
    public function getOutcomesDr(){
        $Sql='SELECT * FROM tbl6DROutcomes ORDER BY Id DESC';
        return db2::getInstance()->FetchAll($Sql,[]);
    }
    
    public function addOutcome($OutBranch,$OutDate,$OutSum,$Outcome,$Comment,$OutType){
        $Sql='INSERT INTO tbl6Outcomes (OutBranch,OutDate,OutSum,Outcome,Comment,OutcomeType) VALUES (?,?,?,?,?,?)';
        db2::getInstance()->Query($Sql,[$OutBranch,$OutDate,$OutSum,$Outcome,$Comment,$OutType]);
    }
}