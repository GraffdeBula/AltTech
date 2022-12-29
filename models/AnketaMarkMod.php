<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnketaMark
 *
 * @author Andrey
 */
class AnketaMarkMod extends Model{
    public function getQuestList(){
        return $this->Data=db::getInstance()->fetch_all("SELECT ANKQUESTION, ANKQUESTIONTYPE, ANKQID FROM tblClAnketaMark2 GROUP BY ANKQUESTION, ANKQUESTIONTYPE");        
    }
    
    public function getAnswerList(){
        return $this->Data=db::getInstance()->fetch_all("SELECT * FROM tblClAnketaMark2");
    }
}
