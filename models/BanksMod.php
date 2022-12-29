<?php
/**
 * модель для работы с банками
 *
 * @author Andrey
 */
class BanksMod extends Model{
    protected $Data;
    public function GetByWName($WName){
        
    }
    public function GetByINN($INN){
        return $this->Data=db::getInstance()->fetch_one("SELECT * FROM tblDrBanks WHERE bnINN='{$INN}';");
    }
}
