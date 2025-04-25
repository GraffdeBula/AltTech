<?php

/* модель для работы с таблицей платежей
 * сохранение платеж
 * удаление платежа
 * получение платежа
 * 
 */

class PaymentMod extends Model{
    
    public function addPayment($Emp,$ProdCode,$ContCode,$PaySum,$PayDate,$PayPr,$PayBranch,$PayFirm,$ContBranch,$ContEmp,$ContClient,$ContPr,$PayType,$ContType,$PayMethod,$ClCode=0){
        $Sql="INSERT INTO tbl5Payments (LgEmp,ProdCode,ContCode,PaySum,PayDate,PayPr,PayBranch,PayFirm,
            ContBranch,ContEmp,ContClient,ContPr,PayType,ContType,PayMethod,ClCode) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        
        $Params=[$Emp,$ProdCode,$ContCode,$PaySum,$PayDate,$PayPr,$PayBranch,$PayFirm,$ContBranch,$ContEmp,$ContClient,$ContPr,$PayType,$ContType,$PayMethod,$ClCode];        
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
    
    public function countPayments2($ContCode,$Type=[]){
        $Types='';
        $Params=[$ContCode,1];
        foreach($Type as $Key=>$Value){
            if ($Key==0){
                $Types=$Types.'?';
            } else {
                $Types=$Types.',?';
            }
            $Params[]=$Value;
        }
        $Sql='SELECT Sum(PaySum) AS PaySum FROM tbl5Payments WHERE ContCode=? AND ProdCode=? AND PayType IN ('.$Types.')';
        return db2::getInstance()->FetchOne($Sql,$Params); 
    }
    
    public function getPaymentById($Id,$ContCode,$ProdCode){
        $Sql='SELECT * FROM tbl5Payments WHERE Id=? AND ContCode=? AND ProdCode=?';
        return db2::getInstance()->FetchOne($Sql,[$Id,$ContCode,$ProdCode]); 
    }
    
    public function getPaymentList($ContCode,$ProdCode){
        $Sql='SELECT * FROM tbl5Payments WHERE ContCode=? AND ProdCode=? ORDER BY ID DESC';
        return db2::getInstance()->FetchAll($Sql,[$ContCode,$ProdCode]); 
    }
    
    public function getPaymentListP1($ContCode){
        $Sql='SELECT * FROM tbl5Payments WHERE ContCode=? AND ProdCode=1 AND PayType in (3,4,5,6,7,8,9) ORDER BY ID DESC';
        return db2::getInstance()->FetchAll($Sql,[$ContCode]); 
    }
    
    public function getPaymentFullListDt($DateF,$DateL,$ContType,$PayType1=1,$PayType2=20){        
        #new MyCheck(['111'],3);
        $Sql="SELECT * FROM tbl5Payments WHERE PayDate BETWEEN ? AND ? AND ContType>=? AND (PayType BETWEEN ? AND ?) ORDER BY ID DESC";
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL,$ContType,$PayType1,$PayType2]); 
    }
    public function getPaymentFullListBrDt($DateF,$DateL,$Branch,$ContType,$PayType1=1,$PayType2=20){
        $Sql="SELECT * FROM tbl5Payments WHERE (PayDate BETWEEN ? AND ?) AND ContBranch=? AND ContType>=? AND (PayType BETWEEN ? AND ?) ORDER BY ID DESC";
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL,$Branch,$ContType,$PayType1,$PayType2]); 
    }
    
    public function getPaymentAggrListDt($DateF,$DateL,$ContType,$PayType1=1,$PayType2=20){
        $Sql="SELECT tbl5drpayreptypes.name as PayName,SUM(tbl5payments.paysum) as PaySum,tbl5drpayreptypes.paytype2,contbranch
            FROM tbl5payments INNER JOIN tbl5drpaytypes ON tbl5payments.paypr=tbl5drpaytypes.name
            INNER JOIN tbl5drpayreptypes ON tbl5drpaytypes.paytype2=tbl5drpayreptypes.paytype2
            WHERE paydate BETWEEN ? AND ? AND ContType>=? AND (PayType BETWEEN ? AND ?) 
            GROUP BY tbl5drpayreptypes.name,tbl5drpayreptypes.paytype2,contbranch ORDER BY contbranch,tbl5drpayreptypes.paytype2";
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL,$ContType,$PayType1,$PayType2]); 
    }
    
    public function getPaymentAggrListBrDt($DateF,$DateL,$Branch,$ContType,$PayType1=1,$PayType2=20){
        $Sql="SELECT tbl5drpayreptypes.name as PayName,SUM(tbl5payments.paysum) as PaySum,tbl5drpayreptypes.paytype2,contbranch
            FROM tbl5payments INNER JOIN tbl5drpaytypes ON tbl5payments.paypr=tbl5drpaytypes.name
            INNER JOIN tbl5drpayreptypes ON tbl5drpaytypes.paytype2=tbl5drpayreptypes.paytype2
            WHERE (paydate BETWEEN ? AND ?) AND ContBranch=? AND ContType>=? AND (PayType BETWEEN ? AND ?) 
            GROUP BY tbl5drpayreptypes.name,tbl5drpayreptypes.paytype2,contbranch ORDER BY contbranch,tbl5drpayreptypes.paytype2";
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL,$Branch,$ContType,$PayType1,$PayType2]); 
    }
    
    public function getPaymentCompListDt($DateF,$DateL,$ContType,$PayType1=1,$PayType2=20){        
        $Sql="SELECT tbl5drpayreptypes.name as PayName,SUM(tbl5payments.paysum) as PaySum
            FROM tbl5payments INNER JOIN tbl5drpaytypes ON tbl5payments.paypr=tbl5drpaytypes.name
            INNER JOIN tbl5drpayreptypes ON tbl5drpaytypes.paytype2=tbl5drpayreptypes.paytype2
            WHERE paydate BETWEEN ? AND ? AND ContType>=? AND (PayType BETWEEN ? AND ?) 
            GROUP BY tbl5drpayreptypes.name,tbl5drpayreptypes.paytype2 ORDER BY tbl5drpayreptypes.paytype2";
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL,$ContType,$PayType1,$PayType2]); 
    }
    
    public function getPaymentMethCompListDt($DateF,$DateL,$ContType){        
        $Sql="SELECT '' as ContBranch,PayMethod,SUM(tbl5payments.paysum) as PaySum
            FROM tbl5payments
            WHERE (paydate BETWEEN ? AND ?) AND (ContType BETWEEN ? AND ?) AND (PayType BETWEEN ? AND ?)
            GROUP BY PayMethod ORDER BY PayMethod";
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL,$ContType,9,1,9]); 
    }
    
    public function getPaymentMethBrListDt($DateF,$DateL,$ContType){        
        $Sql="SELECT ContBranch,PayMethod,SUM(tbl5payments.paysum) as PaySum
            FROM tbl5payments
            WHERE paydate BETWEEN ? AND ? AND ContType>=? 
            GROUP BY ContBranch,PayMethod ORDER BY ContBranch,PayMethod";
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL,$ContType]); 
    }
        
    public function getIncomeCompTotal($DateF,$DateL){
        $Sql="SELECT SUM(tbl5payments.paysum) as PaySum
            FROM tbl5payments WHERE paydate BETWEEN ? AND ? AND PayType in (1,2,3,4,5,7,8,9)";
        return db2::getInstance()->FetchOne($Sql,[$DateF,$DateL]); 
    }


}