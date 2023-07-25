<?php
/**
 * Description of CreditList
 *
 * @author Andrey
 */
class CreditList {
    protected $CreditList;
    protected $CreditListArr;
    protected $Credit;
    
    public function __construct($ContCode) {
        $this->CreditList=(new ATP1CredMod())->GetP1CredList($ContCode);
        $this->CreditListArr=[];
        foreach($this->CreditList as $Cred){
            $Credit=new CreditP1($Cred->CRCODE);
            $this->CreditListArr[]=$Credit;
        }
    }
    
    public function getCreditList() {
        return $this->CreditList;
    }

    public function getCreditListArr() {
        return $this->CreditListArr;
    }
        
}
