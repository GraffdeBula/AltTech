<?php

abstract class Model {
    protected $type;
    public function getType(){
        $this->type='1';
    }
    
    public function toWin($prop){
        return iconv('UTF-8','windows-1251',$prop);
    }
    
    public function toUtf($prop){
        return iconv('windows-1251','UTF-8',$prop);
    }
}

