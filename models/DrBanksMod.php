<?php
/**
 * модель для работы с банками
 * для DB2 (Client2)
 * @author Andrey
 */
class DrBanksMod extends Model{
            
    public function GetByINN($INN){
        return db2::getInstance()->FetchOne("SELECT * FROM tblDrBanks WHERE bnINN='{$INN}';");
    }
}
