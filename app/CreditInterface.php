<?php

/**
 *
 * @author Andrey
 */
interface CreditInterface {
    public function getCredit();
    
    public function getPayList();
    
    public function getPayCredList();
    
    public function insPayCred();
    
    public function delPayCredList();
    
}
