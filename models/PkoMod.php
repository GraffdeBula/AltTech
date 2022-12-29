<?php

class PkoMod extends Model{
    public function getPkoList($pkoDat='current_date'){
        $sql="SELECT * FROM tblPKO WHERE pkoDat='{$pkoDat}'";
        return db::getInstance()->fetch_all($sql);
    }

    public function delPko($incode){

    }

    public function updPko($pko=[],$incode=0){

    }

}