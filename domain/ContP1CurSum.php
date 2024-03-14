<?php

/**
 * Description of ContP1CurSum
 *
 * @author realb
 */
class ContP1CurSum {
    public $Curdate;
    public $Cursum;
    
    public function __construct($Date,$Sum){
        $this->Curdate=$Date;
        $this->Cursum=$Sum;
    }

}