<?php

/**
 * Description of amoMethods
 *
 * @author Andrey
 */
class AmoMethods2 {
    protected $AmoLink='';
    protected $AmoHeader=false;
    protected $AmoData=[];
    protected $AmoMethod='PATCH';
    
    public function getAuth(){
        $Amo=new AmoRequests2();
        return $Amo->getAuth();
    }
}
