<?php
/**
 * контроллер для запуска из консоли
 *
 * @author Andrey
 */
class ErrorCtrl extends ControllerMain{
    public function actionIndex(){
        $Error=['ErrType'=>'Не сделан расчёт прожиточного минимума'];
        $this->render('ErrorView',$Error);
    }
}
