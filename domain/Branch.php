<?php

/**
 * Description of BranchRec
 *
 * @author Andrey
 */
class Branch{
    protected $Rec;
    
    public function __construct($BrName){
        $this->Rec=(new BranchRecMod())->getBranchRec($BrName);
    }
    
    public function getRec(){
        return $this->Rec;
    }
}
