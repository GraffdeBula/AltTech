<?php

/* модель для работы с таблицей платежей
 * сохранение платеж
 * удаление платежа
 * получение платежа
 * 
 */

class PaymentMod extends Model{
    
    public function addPayment($Emp,$ProdCode,$ContCode,$PaySum,$PayDate,$PayPr,$PayBranch,$PayFirm,$ContBranch,$ContEmp,$ContClient,$ContPr,$PayType,$ContType){
        $Sql="INSERT INTO tbl5Payments (LgEmp,ProdCode,ContCode,PaySum,PayDate,PayPr,PayBranch,PayFirm,
            ContBranch,ContEmp,ContClient,ContPr,PayType,ContType) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        #$Sql="INSERT INTO tbl5Payments (lgEmp) VALUES ('lg')";
        $Params=[$Emp,$ProdCode,$ContCode,$PaySum,$PayDate,$PayPr,$PayBranch,$PayFirm,$ContBranch,$ContEmp,$ContClient,$ContPr,$PayType,$ContType];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function getPaymentList($ContCode,$ProdCode){
        $Sql='SELECT * FROM tbl5Payments WHERE ContCode=? AND ProdCode=? ORDER BY ID DESC';
        return db2::getInstance()->FetchAll($Sql,[$ContCode,$ProdCode]); 
    }
    
    public function getPaymentFullListDt($DateF,$DateL){
        $Sql="SELECT * FROM tbl5Payments WHERE PayDate BETWEEN ? AND ? ORDER BY ID DESC";
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL]); 
    }
    public function getPaymentFullListBrDt($DateF,$DateL,$Branch){
        $Sql="SELECT * FROM tbl5Payments WHERE (PayDate BETWEEN ? AND ?) AND PayBranch=? ORDER BY ID DESC";
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL,$Branch]); 
    }
    
    public function getPaymentAggrListDt($DateF,$DateL){
        $Sql="SELECT tbl5drpayreptypes.name as PayName,SUM(tbl5payments.paysum) as PaySum,tbl5drpayreptypes.paytype2,paybranch
            FROM tbl5payments INNER JOIN tbl5drpaytypes ON tbl5payments.paypr=tbl5drpaytypes.name
            INNER JOIN tbl5drpayreptypes ON tbl5drpaytypes.paytype2=tbl5drpayreptypes.paytype2
            WHERE paydate BETWEEN ? AND ? GROUP BY tbl5drpayreptypes.name,tbl5drpayreptypes.paytype2,paybranch ORDER BY paybranch,tbl5drpayreptypes.paytype2";
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL]); 
    }
    
    public function getPaymentAggrListBrDt($DateF,$DateL,$Branch){
        $Sql="SELECT tbl5drpayreptypes.name as PayName,SUM(tbl5payments.paysum) as PaySum,tbl5drpayreptypes.paytype2,paybranch
            FROM tbl5payments INNER JOIN tbl5drpaytypes ON tbl5payments.paypr=tbl5drpaytypes.name
            INNER JOIN tbl5drpayreptypes ON tbl5drpaytypes.paytype2=tbl5drpayreptypes.paytype2
            WHERE (paydate BETWEEN ? AND ?) AND PayBranch=? GROUP BY tbl5drpayreptypes.name,tbl5drpayreptypes.paytype2,paybranch ORDER BY paybranch,tbl5drpayreptypes.paytype2";
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL,$Branch]); 
    }


}