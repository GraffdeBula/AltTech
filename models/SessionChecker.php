<?php
/**
 * модель для авторизации в БД
 * а так же для проверки сессии и определения необходимости повторной авторизации
 *
 * @author realb
 */
class SessionChecker {
    protected object $Data;        
    
    public function checkSession(){
        session_start();
        if (isset($_SESSION['hash'])){
            return true;
        } else {
            (new AdminAuthController)->run();
        }
    }
    
    public function toSession(){
        
    }
    
    public function getLogPass(string $login='',string $pass=''){
        $this->Data=db2::getInstance()->FetchOne("SELECT * FROM tbl9DrEmployee WHERE EmLogin=? AND EmPass=?",[$login,md5($pass)]);
        if ($this->Data){        
            
            $_SESSION['hash']=$this->Data->EMPASS;
            $_SESSION['pass']=$this->Data->EMPASS;
            $_SESSION['login']=$this->Data->EMLOGIN;
            #var_dump($_SESSION);
            #exit();
            return true;
        } else {
            return false;
        }
    }
}
