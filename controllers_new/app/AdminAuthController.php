<?php

/**
 * авторизация в системе
 *
 * @author andrey
 */
class AdminAuthController extends Controller{
    public function actionIndex(){ //метод по умолчанию показывает форму для авторизации
        if(isset($_POST['usAuth'])){
            if((new WebChecker)->GetLogPass($_POST['usLogin'],$_POST['usPass'])){
                #header("Location: http://37.193.61.130/AltTech/index_admin.php");
                header("Location: index_admin.php");
            } else {
                $this->render('AdminAuthFail');
            }                  
        }
        else $this->render('AdminAuth');
        exit();
    }
    
}
