<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of JsonCtrl
 *
 * @author realb
 */
class JsonCtrl extends ControllerMain{
    protected $MyJson="{1: test}";
    
    public function actionIndex(){
        $this->render('JsonTest',['json'=>$this->MyJson]);
    }
}
