<?php
/**
 * Description of CreditP1
 *
 * @author Andrey
 */
class CreditP1 {
    protected $CrRec;
    protected $BnCurRec;
    protected $BnContRec;
    
    public function __construct($CrCode){
        $this->CrRec=(new ATP1CredMod())->GetP1Credit($CrCode);
        
        if ((new AT8BanksMod())->getBankByINN($this->CrRec->CRBANKCURINN)){
            $this->BnCurRec=(new AT8BanksMod())->getBankByINN($this->CrRec->CRBANKCURINN);
        } else {
             $this->BnCurRec=new BnRec();
        }
        
        if ((new AT8BanksMod())->getBankByINN($this->CrRec->CRBANKCONTINN)){
            $this->BnContRec=(new AT8BanksMod())->getBankByINN($this->CrRec->CRBANKCONTINN);
        } else {
             $this->BnContRec=new BnRec();
        }        
    }
    
    public function getCrRec(){
        return $this->CrRec;
    }
    
    public function getBnCurRec() {
        return $this->BnCurRec;
    }

    public function getBnContRec() {
        return $this->BnContRec;
    }
}
