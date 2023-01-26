<?php

#namespace AltTech\Domain;

/**
 * Description of Client
 *
 * @author Andrey
 */
class Client {
    public $ClRec=[];
    protected $Pasport=[];
    
    public function __construct($ClCode) {
        $this->ClRec=(new ATClientMod())->GetClientById($ClCode);
        $this->Pasport=(new ATClientMod())->getDocument($ClCode,'паспорт');
    }
    
    public function getClRec(){
        return $this->ClRec;
    }
    
    public function getPasport(){
        return $this->Pasport;
    }
}
