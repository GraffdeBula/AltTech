<?php

/**
 * Контроллер для работы с базой данных ФССП через API
 *
 * @author Andrey
 */
use Fssp\Exception\FsspException;
use Fssp\Fssp;
use Fssp\Subject\Physical;
use GuzzleHttp\Exception\GuzzleException;

class FSSP{
    protected $APIKey='Qz0nKOLxyMXv';
    protected $task=''; //ключ для получения информации по отправленному запросу
    protected $answer;
    
    public function GetInfo($Client=['LastName','FirstName','SecondName','BirthDate','RegCode']){
        
        $birthday = new \DateTime($Client[3]);
        $query = new Physical($Client[0],$Client[1],$Client[2], $birthday,$Client[4]);        
        $fssp = new Fssp($this->APIKey);        
        $this->task=$fssp->search($query)['response']['task'];
        
        sleep(5);
        
        return $this->answer=$fssp->result($this->task);               
    }
}