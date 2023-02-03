<?php
/**
 * Контроллер для загрузки отчёта по экспертизам
 *
 * @author Andrey
 */
class PkoListCtrl extends ControllerMain{
    
    public function actionIndex() {
        $PkoList=(new ATPkoMod)->getPkoListLast();
        
        $this->render('reports/ATPkoList',['PkoList'=>$PkoList]);
    }
    
    public function actionFiltList() {
        if ((isset($_GET['PayDate']))&&($_GET['PayDate']!='')){
            $PkoList=(new ATPkoMod)->getPkoListDate($_GET['PayDate']);
        }
        if (isset($_GET['ContCode'])){
            $PkoList=(new ATPkoMod)->getPkoListCont($_GET['ContCode']);
        }
            
        
        
        $this->render('reports/ATPkoList',['PkoList'=>$PkoList]);
    }
    public function actionDelPko() {
        (new ATPkoMod)->delPko($_GET['InCode']);
        
        header("Location: index_admin.php?controller=PkoListCtrl");
    }
}
