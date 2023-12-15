

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>АМО панель администратора</title>
    </head>
    <body>
        <p>
            <a href="index_admin.php"><button class="btn btn-outline-secondary">На главную</button></a>            
        </p>          
        <h5>Настройки для интеграции с амоЦРМ</h5>
        
        <a href="index_admin.php?controller=AmoAdminPanelCtrl&action=GetPipeLines"><button class='btn btn-dark'>GetPipeLineList</button></a>
        
        <?php 
            if (isset($PipeeLineList)){
                foreach($PipeLineList as $PipeLine){
                    var_dump($PipeLine);
                    echo('<br>=============================================<br>');
                }
            }
        ?>
        
    </body>
</html>
