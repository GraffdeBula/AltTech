<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of AsynchTestCtrl
 *тестирование асинхронного обращения к базе данных:
 * 1. асинхронное сохранение
 * 2. передача данных в асинхронный запрос
 * 3. получение и отображение данных без перезагрузки страницы
 * 
 * @author realb
 */
class AsynchTestCtrl extends ControllerMain{
    protected $MyJson="{1: test}";
    
    public function actionIndex(){
        $this->MyJson=(new SettingsMod())->getSettings('test1');
        #new MyCheck($this->MyJson,0);
        $this->render('AsynchTest',['json'=>$this->MyJson]);
    }
    
    public function actionSave(){
        (new SettingsMod())->addSettings($_GET['SetComment'],$_GET['SetValue']);
        $this->render('AsynchTest',['json'=>$this->MyJson]);
    }
}
