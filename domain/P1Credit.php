<?php
/**
 * объект Кредит по договору
 * для формирования списка кредитов по договору в досте юриста
 * @author Andrey
 */
class P1Credit {
    protected $Rec;
    protected $BnContRec;
    protected $BnCurRec;
    
    public function __construct($CrCode) {
        $this->Rec=(new ATP1CredMod())->GetP1Credit($CrCode);
        $this->BnContRec=(new AT8BanksMod())->getBankByINN($this->Rec->CRBANKCONTINN);
        if ($this->BnContRec==false){
            $this->BnContRec=new BankRec();
        }        
        $this->BnCurRec=(new AT8BanksMod())->getBankByINN($this->Rec->CRBANKCURINN);
        if ($this->BnCurRec==false){
            $this->BnCurRec=new BankRec();
        }
        
    }
    
    public function getRec(){
        return $this->Rec;
    }
    
    public function getBnContRec(){
        return $this->BnContRec;
    }
    
    public function getBnCurRec(){
        return $this->BnCurRec;
    }
}
