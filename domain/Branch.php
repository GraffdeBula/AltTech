<?php

/**
 * Description of BranchRec
 *
 * @author Andrey
 */
class Branch{
    protected $BrName;
    protected $Rec;
    protected $BranchList;
    
    public function __construct($BrName=''){
        $this->BrName=$BrName;
        $this->Rec=(new BranchRecMod())->getBranchByName($BrName);
        $this->BranchList=(new BranchRecMod())->getBranchList();
        $this->ChangeDirForDoc();
    }
    
    public function getRec(){
        return $this->Rec;
    }

    public function getBranchList(){
        return $this->BranchList;
    }
    
    protected function ChangeDirForDoc(){        
        if (($this->BrName=='ОП Центральный')&&(in_array($_SESSION['EmName'],['Илья Ковтун','Мария Мусатова']))){
            $this->Rec->BRDIR=$_SESSION['EmName'];            
        }
    }
}
