<?php

/**
 * авторизация в системе
 *
 * @author andrey
 */
class AdminAuthController extends Controller{
    public function actionIndex(){ //метод по умолчанию показывает форму для авторизации
        #echo('ih bin auth');
        #exit();
        if(isset($_POST['usAuth'])){
            if((new SessionChecker)->getLogPass($_POST['usLogin'],$_POST['usPass'])){                
                header("Location: index_admin.php");//авторизация удалась переход на основной файл
            } else {
                $this->render('AdminAuthFail');//неудачная авторизация
            }                  
        }
        else $this->render('AdminAuth');//авторизации не было, показ формы авторизации
        exit();
    }
    
}
