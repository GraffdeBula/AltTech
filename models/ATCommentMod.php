<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of ATCommentMod
 *
 * @author Andrey
 */
class ATCommentMod extends Model{
    public function GetClComments($ClCode){                
        return db2::getInstance()->FetchAll("SELECT * FROM tblClComments WHERE ClCode=? ORDER BY Id DESC",[$ClCode]);
    }
    
    public function GetContComments($ClCode,$ContCode,$ProdNum){        
        return db2::getInstance()->FetchAll("SELECT * FROM tblClComments WHERE ClCode=? AND ContCode=? AND ProdNum=? ORDER BY Id DESC",[$ClCode,$ContCode,$ProdNum]);
    }
            
    public function AddComment($ClCode=0,$ContCode=0,$ProdNum=1,$Text='',$Author='admin'){
        db2::getInstance()->Query("INSERT INTO tblClComments (ClCode,ContCode,ProdNum,CmText,CmAuthor) VALUES (?,?,?,?,?)",[$ClCode,$ContCode,$ProdNum,$Text,$Author]);
    }
    
    public function UpdComment($Id=0,$Text=''){
        db2::getInstance()->Query("UPDATE tblClComments SET CmText=? WHERE Id=?",[$Text,$Id]);
    }
    
    public function DelComment($Id){
        db2::getInstance()->Query("DELETE FROM tblClComments WHERE Id=?",[$Id]);
    }
}
