<?php

/**
 * Description of ContP1CurSum
 *
 * @author realb
 */
class ContP1CurSum {
    public $Curdate;
    public $Cursum;
    public $Payedsum;    
    
    public function __construct($Date,$Cursum,$Payedsum){
        $this->Curdate=$Date;
        $this->Cursum=$Cursum;
        $this->Payedsum=$Payedsum;
    }

}