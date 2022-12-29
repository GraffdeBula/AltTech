<?php


class Report1 extends Model{
    protected $Data;    
    
    public function getTotalRep() {
        $sql="SELECT * from vwDepositTotal where (SUM1>0 or SUM2>0) and BRANCH<>'';";
        return $this->Data=db::getInstance()->fetch_all($sql); 
        //return $this->Data=user::getInstance()->userConnection()->fetch_all($sql); 
    }
    
    public function getBranchRep($branch){
        $sql="SELECT * from vwDepositBranch where (SUM1>0 or SUM2>0) and BRANCH='{$this->toWin($branch)}';";
        return $this->Data=db::getInstance()->fetch_all($sql); 
    }
    /*добавляем метод получения выборки за период.
     * нужны вьюхи приход и расход с указанием даты и филиала
     * pkoCode, inCode, branch, sum, pkoDat
     * vwDepositInout ContCode, Client, Sum, Date, RBanch, Type
     * для свода отбираем сумму в разрезе филиала 2 раза. сначала 11 потом 12
     */
    
    public function getTotalRep2($dat1,$dat2){
        $sql="select brName,brSum1,brSum2*(-1) as brSum2 from tbldrBranch "
            ."left join (select Sum(pkoSum) as BrSum1,pkoBranch as br1 from vwdepositinout "
            ."where pkoType=11 and pkoDat between '{$dat1}' and '{$dat2}' group by pkoBranch) on tblDrBranch.brName=br1 "
            ."left join (select Sum(pkoSum) as BrSum2,pkoBranch as br2 from vwdepositinout "
            ."where pkoType=12 and pkoDat between '{$dat1}' and '{$dat2}' group by pkoBranch) on tblDrBranch.brName=br2";        
                
        $this->Data=db::getInstance()->fetch_all($sql);
        
        return $this->Data;
        
    }
    
    public function getBranchRep2($branch,$dat1,$dat2) {                
        $sql="select * from vwdepositinout where (pkoDat between ? and ?) and pkoBranch=?;";
        //echo("<br>".$sql);
        $params=[$dat1,$dat2,$branch];
        $this->Data=db::getInstance()->fetch_all2($sql,$params);
        //echo("<br> это модель:   ");
        //var_dump($this->Data);
        return $this->Data;
        
    }
    
//    public function getBranchRep2($branch,$dat1,$dat2) {        
//        $sql="select contcode,client from vwdepositinout where (pkoDat between '{$dat1}' and '{$dat2}') and pkoBranch='{$branch}';";
//        //echo("<br>".$sql);
//        $params=[$dat1,$dat2,$branch];
//        $this->Data=db::getInstance()->fetch_all($sql);
//        echo("<br> это модель:   ");
//        var_dump($this->Data);
//        return $this->Data;
//        
//    }
    
}
