<?php
/**
 * класс для работы со статусом
 *
 * @author Andrey
 */
class Status {
    protected $StatNum=0;
    protected $StatStr='';
    
    public function __construct() {
        
    }
    
    public function ChangeP1Status($StatNum,$ContCode){
        $Model=new ATP1StatusMod();
        $OldStatus=$Model->GetP1Status($ContCode)->STATUS;
        if ($OldStatus<$StatNum){        
            $Model->UpdP1Status($StatNum,$ContCode);
        }
    }
    
    public function ChangeP4Status($StatNum,$ContCode){
        $Model=new ATP4StatusMod();
        $OldStatus=$Model->GetP4Status($ContCode)->STATUS;
        if ($OldStatus<$StatNum){        
            $Model->UpdP4Status($StatNum,$ContCode);
        }
    }
    
    
}
