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
        $Sql='SELECT * FROM tbl6DROutcomes ORDER BY Id';
        return db2::getInstance()->FetchAll($Sql,[]);
    }
    
    public function addOutcome($OutBranch,$OutDate,$OutSum,$Outcome,$Comment,$OutType){
        $Sql='INSERT INTO tbl6Outcomes (OutBranch,OutDate,OutSum,Outcome,Comment,OutcomeType) VALUES (?,?,?,?,?,?)';
        db2::getInstance()->Query($Sql,[$OutBranch,$OutDate,$OutSum,$Outcome,$Comment,$OutType]);
    }
    
    public function getTotalPayments($OutBranch,$DateF,$DateL,$ContType,$PayMethod){
        if ($OutBranch==''){
            $Sql="SELECT Sum(PaySum) As PaySum FROM tbl5Payments WHERE (PayDate BETWEEN ? AND ?) AND ContType=? AND PayMethod LIKE ? AND PayType<10"; 
            $Params=[$DateF,$DateL,$ContType,'%'.$PayMethod.'%'];
        }else{
            $Sql="SELECT Sum(PaySum) As PaySum FROM tbl5Payments WHERE ContBranch=? AND (PayDate BETWEEN ? AND ?) AND ContType=? AND PayMethod LIKE ?  AND PayType<10";
            $Params=[$OutBranch,$DateF,$DateL,$ContType,'%'.$PayMethod.'%'];
        }
         
        $this->Data=db2::getInstance()->FetchOne($Sql,$Params);
        return $this->Data;
    }
    
    public function getTotalOutcomes($OutBranch,$DateF,$DateL,$PayMethod){
        if ($OutBranch==''){
            $Sql="SELECT Sum(OutSum) As PaySum FROM tbl6Outcomes WHERE (OutDate BETWEEN ? AND ?) AND OutcomeType=? AND Outcome<>?"; 
            $Params=[$DateF,$DateL,$PayMethod,'Трансфер из ГО'];
        }else{
            $Sql="SELECT Sum(OutSum) As PaySum FROM tbl6Outcomes WHERE OutBranch=? AND (OutDate BETWEEN ? AND ?) AND OutcomeType=? AND Outcome<>?";
            $Params=[$OutBranch,$DateF,$DateL,$PayMethod,'Трансфер из ГО'];
        }
         
        $this->Data=db2::getInstance()->FetchOne($Sql,$Params);        
        return $this->Data;
    }
    
    public function getOtherIncomes($OutBranch,$DateF,$DateL,$PayMethod){
        if ($OutBranch==''){
            $Sql="SELECT Sum(OutSum) As PaySum FROM tbl6Outcomes WHERE (OutDate BETWEEN ? AND ?) AND OutcomeType=? AND Outcome=?"; 
            $Params=[$DateF,$DateL,$PayMethod,'Трансфер из ГО'];
        }else{
            $Sql="SELECT Sum(OutSum) As PaySum FROM tbl6Outcomes WHERE OutBranch=? AND (OutDate BETWEEN ? AND ?) AND OutcomeType=? AND Outcome=?";
            $Params=[$OutBranch,$DateF,$DateL,$PayMethod,'Трансфер из ГО'];
        }
         
        $this->Data=db2::getInstance()->FetchOne($Sql,$Params);        
        return $this->Data;
    }
}