<?php
/**
 * модель для работы с банками
 * для DB2 (Client2)
 * @author Andrey
 */
class DrBanksMod extends Model{
            
    public function getByINN($INN){
        return db2::getInstance()->FetchOne("SELECT * FROM tbl8DrBanks WHERE bnINN='{$INN}';");
    }
}
