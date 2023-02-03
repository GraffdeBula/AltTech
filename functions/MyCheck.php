<?php

/**
 * класс для быстрой проверки параметров передаваемых между разными объектами
 *
 * @author Andrey
 */
class MyCheck {
    protected $ParamsArr=[];
    public function __construct($Arr,$CheckType=2) {
        $this->ParamsArr=$Arr;
        if ($CheckType==2){
            $this->ShowCheck2();
        }
        if ($CheckType==1){
            $this->ShowCheck();
        }
    }
    
    public function ShowCheck(){
        echo("<h1 style='color: red'>СООБЩЕНИЕ ОБ ОШИБКЕ 1</h1>");
        foreach ($this->ParamsArr as $Param => $Value){
            echo("<br>");
            echo("{$Param} --> ");
            var_dump($Value);
        }    
        exit();
    }
    public function ShowCheck2(){
        echo("<h1 style='color: red'>СООБЩЕНИЕ ОБ ОШИБКЕ 2</h1>");
        var_dump($this->ParamsArr);
        exit();
    }
}
