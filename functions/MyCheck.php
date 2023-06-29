<?php

/**
 * класс для быстрой проверки параметров передаваемых между разными объектами
 *
 * @author Andrey
 */
class MyCheck {
    protected $ParamsArr=[];
    public function __construct($Arr=[],$CheckType=2) {
        $this->ParamsArr=$Arr;
        if ($CheckType==0){
            $this->ShowCheck0();
        }
        if ($CheckType==1){
            $this->ShowCheck1();
        }
        if ($CheckType==2){
            $this->ShowCheck2();
        }        
        if ($CheckType==3){
            $this->ShowCheck3();
        }        
    }
    public function ShowCheck0(){
        echo("<h1 style='color: orange'>ОТЛАДКА 0</h1>");
        var_dump($this->ParamsArr);
        exit();
    }
    
    public function ShowCheck1(){
        echo("<h1 style='color: blue'>ОТЛАДКА 1</h1>");
        foreach ($this->ParamsArr as $Param => $Value){
            echo("<br>");
            echo("{$Param} --> ");
            var_dump($Value);
        }    
        exit();
    }
    public function ShowCheck2(){
        echo("<h1 style='color: red'>ОТЛАДКА 2</h1>");
        var_dump($this->ParamsArr[0]);
        echo("<br>============<br>");
        var_dump($this->ParamsArr[1]);
        exit();
    }
            
    public function ShowCheck3(){
        echo("<h1 style='color: green'>ОТЛАДКА 3</h1>");
        echo($this->ParamsArr[0]);
        exit();
    }
    
}
