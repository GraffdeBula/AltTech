<?php

/**
 * Description of BranchRec
 *
 * @author Andrey
 */
class Branch{
    protected $Rec;
    
    public function __construct($BrName){
        $this->Rec=(new BranchRec())->getBr($BrName);
    }
    
    public function getRec(){
        return $this->Rec;
    }
}
