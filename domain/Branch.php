<?php

/**
 * Description of BranchRec
 *
 * @author Andrey
 */
class Branch{
    protected $Rec;
    protected $BranchList;
    
    public function __construct($BrName=''){
        $this->Rec=(new BranchRecMod())->getBranchByName($BrName);
        $this->BranchList=(new BranchRecMod())->getBranchList();
    }
    
    public function getRec(){
        return $this->Rec;
    }

    public function getBranchList(){
        return $this->BranchList;
    }
}
