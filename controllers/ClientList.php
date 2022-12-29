<?php
/**
 * Description of ClientList
 *
 * @author andrey
 */
class ClientList extends Controller{
    public function actionIndex(){
        $ClientList=(new Client())->getClientList();
        foreach($ClientList as $MyClient){
            echo($MyClient->CONTCODE);
            echo($MyClient->CLFNAME);
            echo($MyClient->CL1NAME);
            echo($MyClient->CL2NAME);
            echo("<br>");
        }
        exit();
}
}
