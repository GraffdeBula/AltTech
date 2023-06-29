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
    
    public function updPaymentLg($Id,$ContCode,$LgEmp){
        $Sql='UPDATE tbl5Payments set lgEmp=? WHERE Id=? AND ContCode=? ';
        db2::getInstance()->Query($Sql,[$LgEmp,$Id,$ContCode]);
    }
    public function delPayment($Id,$ContCode){
        $Sql='DELETE FROM tbl5Payments WHERE Id=? AND ContCode=? ';
        db2::getInstance()->Query($Sql,[$Id,$ContCode]);
    }
    
    public function countPayments($ContCode,$Type1,$Type2){
        $Sql='SELECT Sum(PaySum) AS PaySum FROM tbl5Payments WHERE ContCode=? AND PayType BETWEEN ? AND ? AND ProdCode=?';
        return db2::getInstance()->FetchOne($Sql,[$ContCode,$Type1,$Type2,1]); 
    }
    
    public function getPaymentList($ContCode,$ProdCode){
        $Sql='SELECT * FROM tbl5Payments WHERE ContCode=? AND ProdCode=? ORDER BY ID DESC';
        return db2::getInstance()->FetchAll($Sql,[$ContCode,$ProdCode]); 
    }
    
    public function getPaymentFullListDt($DateF,$DateL,$ContType){        
        #new MyCheck(['111'],3);
        $Sql="SELECT * FROM tbl5Payments WHERE PayDate BETWEEN ? AND ? AND ContType>=? ORDER BY ID DESC";
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL,$ContType]); 
    }
    public function getPaymentFullListBrDt($DateF,$DateL,$Branch,$ContType){
        #new MyCheck(['222'],3);
        $Sql="SELECT * FROM tbl5Payments WHERE (PayDate BETWEEN ? AND ?) AND ContBranch=? AND ContType>=? ORDER BY ID DESC";
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL,$Branch,$ContType]); 
    }
    
    public function getPaymentAggrListDt($DateF,$DateL,$ContType){
        #new MyCheck(['333'],3);
        $Sql="SELECT tbl5drpayreptypes.name as PayName,SUM(tbl5payments.paysum) as PaySum,tbl5drpayreptypes.paytype2,contbranch
            FROM tbl5payments INNER JOIN tbl5drpaytypes ON tbl5payments.paypr=tbl5drpaytypes.name
            INNER JOIN tbl5drpayreptypes ON tbl5drpaytypes.paytype2=tbl5drpayreptypes.paytype2
            WHERE paydate BETWEEN ? AND ? AND ContType>=? GROUP BY tbl5drpayreptypes.name,tbl5drpayreptypes.paytype2,contbranch ORDER BY contbranch,tbl5drpayreptypes.paytype2";
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL,$ContType]); 
    }
    
    public function getPaymentAggrListBrDt($DateF,$DateL,$Branch,$ContType){
        #new MyCheck(['444'],3);
        $Sql="SELECT tbl5drpayreptypes.name as PayName,SUM(tbl5payments.paysum) as PaySum,tbl5drpayreptypes.paytype2,contbranch
            FROM tbl5payments INNER JOIN tbl5drpaytypes ON tbl5payments.paypr=tbl5drpaytypes.name
            INNER JOIN tbl5drpayreptypes ON tbl5drpaytypes.paytype2=tbl5drpayreptypes.paytype2
            WHERE (paydate BETWEEN ? AND ?) AND ContBranch=? AND ContType>=? GROUP BY tbl5drpayreptypes.name,tbl5drpayreptypes.paytype2,contbranch ORDER BY contbranch,tbl5drpayreptypes.paytype2";
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL,$Branch,$ContType]); 
    }
    
    public function getPaymentCompListDt($DateF,$DateL,$ContType){        
        $Sql="SELECT tbl5drpayreptypes.name as PayName,SUM(tbl5payments.paysum) as PaySum
            FROM tbl5payments INNER JOIN tbl5drpaytypes ON tbl5payments.paypr=tbl5drpaytypes.name
            INNER JOIN tbl5drpayreptypes ON tbl5drpaytypes.paytype2=tbl5drpayreptypes.paytype2
            WHERE paydate BETWEEN ? AND ? AND ContType>=? GROUP BY tbl5drpayreptypes.name,tbl5drpayreptypes.paytype2 ORDER BY tbl5drpayreptypes.paytype2";
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL,$ContType]); 
    }
    
    public function getIncomeCompTotal($DateF,$DateL){
        $Sql="SELECT SUM(tbl5payments.paysum) as PaySum
            FROM tbl5payments WHERE paydate BETWEEN ? AND ? AND PayType<?";
        return db2::getInstance()->FetchOne($Sql,[$DateF,$DateL,5]); 
    }


}