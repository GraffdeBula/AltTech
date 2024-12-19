<?php
/**
 * Description of ListProcessor
 *
 * @author Andrey
 */
class ListProcessor {
    public $Sql="";
    public $Params=[];
    
    public function __construct($Sql,$Params) {
        $this->Sql=$Sql;
        $this->Params=$Params;
    }
    
    public function getList(){
        return db2::getInstance()->FetchAll($this->Sql,$this->Params);
    }
}
