<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of logger
 *
 * @author Andrey
 */
class logger {
    const FILE_PATH='/AltTech/log/';
    protected $fileName;

    public function __construct(){
        $this->fileName=$_SERVER["DOCUMENT_ROOT"].self::FILE_PATH.date("Ymd")."log.txt";                
    }

    public function logToFile($info){
    	#$add=json_encode($info['leads']['add']);
    	#$addSubStr=explode('","',$add,2);
    	#$addSubStr=explode('":"',$addSubStr[0],2);
    	#$toLog=implode(';',$toLog);
    	#file_put_contents($this->fileName, date("Y-m-d H:i:s")." --> ".$add."\r\n", FILE_APPEND);
        #file_put_contents($this->fileName, date("Y-m-d H:i:s")." --> ".$addSubStr[0]."\r\n", FILE_APPEND);
        #file_put_contents($this->fileName, date("Y-m-d H:i:s")." --> ".$addSubStr[1]."\r\n", FILE_APPEND);
        file_put_contents($this->fileName, date("Y-m-d H:i:s")." --> ".$info."\r\n", FILE_APPEND);
        file_put_contents($this->fileName, "\r\n", FILE_APPEND);
    }

}
