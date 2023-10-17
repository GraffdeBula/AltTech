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
        $this->render('AsynchTest',[]);
    }
    
    public function actionGetSetList(){
        $SetList=(new SettingsMod())->getSettings('test111');
        echo json_encode($SetList);
    }
    
    public function actionSave1(){
        (new SettingsMod())->addSettings('test111',$_GET['SetComment'],$_GET['SetValue']);        
    }
    
    public function actionSave2(){
        (new SettingsMod())->addSettings('test222',$_GET['SetComment'],$_GET['SetValue']);        
    }
    
    public function actionDel(){
        (new SettingsMod())->delSettings($_GET['Id']);        
    }
    
    
}
