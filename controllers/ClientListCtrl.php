<?php
/**
 * Description of ClientList
 *
 * @author andrey
 */
class ClientListCtrl extends Controller{
    public function actionIndex(){
        $this->render('ClientList', []);
}
}
