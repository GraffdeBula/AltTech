<?php

/**
 * Description of P1SaveData
 *
 * @author Andrey
 */
class P1SaveData {
    protected $TblName;
    protected $FieldName;
    protected $ContCode;
    
    public function __construct($Table,$Field,$ContCode) {
        $this->TblName=$Table;
        $this->FieldName=$Field;
        $this->ContCode=$ContCode;
    }
    
    public function saveData(){
        $Sql="UPDATE {$this->TblName} SET {$this->FieldName}=current_date WHERE ContCode=?";
        $Params=[$this->ContCode];
        #(new MyCheck([$this],0))->ShowCheck0();
        db2::getInstance()->Query($Sql,$Params); 
    }
}
