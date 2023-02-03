<?php

/**
 * класс, который в определённом месте добавляет обязательные поля для формы
 * контроллер
 * экшн
 * код клиента
 * код договора
 *
 * @author Andrey
 */
class MyForm{
    protected $CtrlName;
    protected $ActionName='Index';
    protected $ClCode=0;
    protected $ContCode=0; 
    
    public function __construct($CtrlName,$ActionName,$ClCode='',$ContCode=''){
        $this->CtrlName=$CtrlName;
        $this->ActionName=$ActionName;
        $this->ClCode=$ClCode;
        $this->ContCode=$ContCode;
    }

    public function AddForm(){
        echo("<input type='hidden' name='controller' value='{$this->CtrlName}'>");
        echo("<input type='hidden' name='action' value='{$this->ActionName}'>");
        echo("<input type='hidden' name='ClCode' value='{$this->ClCode}'>");
        echo("<input type='hidden' name='ContCode' value='{$this->ContCode}'>");
    }
    
    public function AddForm2(){
        echo("<input type='hidden' name='controller' value='{$this->CtrlName}'>");
        echo("<input type='hidden' name='action' value='{$this->ActionName}'>");        
    }
    
}
