<?php

/**
 * модель для проверки авторизации
 * 
 * @author Andrey
 */
class AuthMod {
    public function getAuthByLP($Login,$Pass){
        $Sql="SELECT * FROM tbl9DrEmployee WHERE EmLogin=? AND EmPas=?";
        $Auth=db2::getInstance()->FetchOne($Sql,[$Login,$Pass]);
        var_dump($Auth);
         
        
    }
}
