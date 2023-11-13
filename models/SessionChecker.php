<?php
/**
 * модель для авторизации в БД
 * а так же для проверки сессии и определения необходимости повторной авторизации
 *
 * @author realb
 */
class SessionChecker {
    protected $Data;        
    
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
        if (($login=='') or ($pass=='')){
            return false;
        } else {
            $this->Data=db2::getInstance()->FetchOne("SELECT * FROM tbl9DrEmployee WHERE EmLogin=? AND EmPass=? AND EmStatus=?",[$login,md5($pass),'работает']);
            if ($this->Data){        

                $_SESSION['hash']=$this->Data->EMPASS;
                $_SESSION['pass']=$this->Data->EMPASS;
                $_SESSION['login']=$this->Data->EMLOGIN;            

                return true;
            } else {
                return false;
            }
        }
    }
        
}
