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
        $this->genCreditsArr();
    }
    
    public function getList(){
        return $this->CreditList;
    }
    
    public function getCreditByCode($CrCode){
        return $this->Credit=new Credit($CrCode);
    }
    
    public function getCreditListArr(){
        return $this->CreditListArr;
    } 
    public function genCreditsArr(){
        $this->CreditListArr=[];
        foreach($this->CreditList as $Cred){
            $Credit=new P1Credit($Cred->CRCODE);
            $this->CreditListArr[]=$Credit;
        }
    }
    
}
