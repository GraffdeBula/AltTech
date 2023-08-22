<?php
/**
 * Description of ClProperty
 *
 * @author Andrey
 */
class ClProperty {
    protected $ClCode=0;
    protected $ClPropDesc='';
    
    public function __construct($ClCode,$ClPropDesc='') {
        $this->ClCode=$ClCode;
        $this->ClPropDesc=$ClPropDesc;
    }
    
    public function CheckProperty(){
        $CheckProperty=(new ATClientMod())->GetClPropertyByDesc($this->ClCode,$this->ClPropDesc);
        if ($CheckProperty){
            #new MyCheck(true,0);
        } else {
            #new MyCheck(false,0);
            (new ATClientMod())->InsProperty($_GET['ClCode'],'ед.жильё','клиент',$this->ClPropDesc,'','','','');
        }
    }
    
    public function AddProperty(){
        
    }
                        
}
