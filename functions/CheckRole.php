<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

class CheckRole {
    
    public function Check($Role,$Ctrl,$Action){
        return $MyRole=db2::getInstance()->FetchOne('SELECT * FROM tbl9DrRoles WHERE role=? AND controller=? AND action=?',[$Role,$Ctrl,$Action]);    
    }
}