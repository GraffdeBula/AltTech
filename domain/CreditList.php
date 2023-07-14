<?php
/**
 * Description of CreditList
 *
 * @author Andrey
 */
class CreditList {
    protected $CreditList;
    protected $Credit;
    
    public function __construct($ContCode) {
        $this->CreditList=(new ATP1CredMod())->GetP1CredList($ContCode);
    }
    
    public function getList(){
        return $this->CreditList;
    }
    
    public function getCreditByCode($CrCode){
        return $this->Credit=new Credit($CrCode);
    }
    
}
