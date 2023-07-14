<?php
/**
 * объект Кредит по договору
 *
 * @author Andrey
 */
class Credit {
    protected $Rec;
    
    public function __construct($CrCode) {
        $this->Rec=(new ATP1CredMod())->GetP1Credit($CrCode);
    }
    
    public function getRec(){
        return $this->Rec;
    }
}
