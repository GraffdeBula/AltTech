<?php

class ATPkoMod extends Model{
    public function getPkoListLast(){
        $Sql="select first 100 * from tblpko order by pkoincode desc";
        return db::getInstance()->fetch_all($Sql);
    }
    
    public function getPkoListDate($PkoDate='current_date'){
        $Sql="SELECT * FROM tblPKO WHERE pkoDat=? order by pkoincode desc";
        return db::getInstance()->fetch_all2($Sql,[$PkoDate]);
    }
    
    public function getPkoListCont($ContCode=1){
        $Sql="SELECT * FROM tblPKO WHERE pkoContCode=? order by pkoincode desc";
        return db::getInstance()->fetch_all2($Sql,[$ContCode]);
    }

    public function delPko($InCode){
        $Sql="DELETE FROM tblPko WHERE pkoInCode=?";
        return db::getInstance()->query_delete2($Sql,[$InCode]);
    }

    public function updPko($pko=[],$incode=0){

    }

}