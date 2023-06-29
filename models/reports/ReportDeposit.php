<?php


class ReportDeposit extends Model{
    protected $Data;    
    
    public function getTotalRep() {
        $sql="SELECT * from vwDepositTotal where (SUM1>0 or SUM2>0) and BRANCH<>'';";
        return $this->Data=db2::getInstance()->FetchAll($sql); 
    }
    
    public function getBranchRep($branch){
        $sql="SELECT * from vwDepositBranch where (SUM1>0 or SUM2>0) and BRANCH='{$branch}';";
        return $this->Data=db2::getInstance()->FetchAll($sql); 
    }
    /*добавляем метод получения выборки за период.
     * нужны вьюхи приход и расход с указанием даты и филиала
     * payCode, inCode, branch, sum, payDate
     * vwDepositInout ContCode, Client, Sum, Date, RBanch, Type
     * для свода отбираем сумму в разрезе филиала 2 раза. сначала 11 потом 12
     */
    
    public function getTotalRep2($dat1,$dat2){
        $sql="select brName,brSum1,brSum2*(-1) as brSum2 from tbl9drBranchRec "
            ."left join (select Sum(paySum) as BrSum1,payBranch as br1 from vwdepositinout "
            ."where payType=11 and payDate between '{$dat1}' and '{$dat2}' group by payBranch) on tbl9drBranchRec.brName=br1 "
            ."left join (select Sum(paySum) as BrSum2,payBranch as br2 from vwdepositinout "
            ."where payType=12 and payDate between '{$dat1}' and '{$dat2}' group by payBranch) on tbl9drBranchRec.brName=br2";        
                
        $this->Data=db2::getInstance()->FetchAll($sql);
        
        return $this->Data;
        
    }
    
    public function getBranchRep2($branch,$dat1,$dat2) {                
        $sql="select * from vwdepositinout where (payDate between ? and ?) and payBranch=?;";

        $params=[$dat1,$dat2,$branch];
        $this->Data=db2::getInstance()->FetchAll($sql,$params);

        return $this->Data;
        
    }
     
}
