<?php

/**
 * модель для получения логина и пароля и сохранения их в сессию
 *
 * @author andrey
 */
class WebChecker {
    protected $Data;
    protected $hash;
    protected $login;
    protected $pass;
    
    public function CheckHash(){
        session_start();
        #проверить есть ли хэшключ в сессии
        if (isset($_SESSION['hash'])){
            $this->hash=$_SESSION['hash'];
            $this->ToSession();
            return TRUE;
        }
        elseif (isset($_GET['hash'])){
            $this->hash=$_GET['hash'];
            $this->ToSession();
            return TRUE;
        }
        else (new AdminAuthController)->run();
    }
    
    public function GetLogPass($login,$pass){
        $this->login=$login;
        $this->pass=$pass;
        return $this->GetEmHashByPas();
    }
    protected function ToSession(){
        $this->GetEmPasByHash();
        $_SESSION['hash']=$this->hash;
        $_SESSION['login']=$this->login;
        $_SESSION['pass']=$this->pass;
        
    }
        
    protected function GetEmPasByHash(){
        $this->Data=db0::getInstance()->fetch_one("SELECT * FROM tblDrEmpPass WHERE empRndKey='{$this->hash}'");
        if ($this->Data){
            $this->login=$this->Data->EMPLOG;
            $this->pass=$this->Data->EMPPASS;
        }
    }
    
    protected function GetEmHashByPas(){
        $this->Data=db0::getInstance()->fetch_one("SELECT * FROM tblDrEmpPass WHERE empLog='{$this->login}' and empPass='{$this->pass}'");
        if ($this->Data){
            $this->hash=$this->Data->EMPRNDKEY;
            $this->ToSession();
            return True;
        } else return False;
    }
}
