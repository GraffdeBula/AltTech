<?php 
    echo('TEST');
    $MyName='';
    $MyRole='';
    if ((isset($_SESSION['EmRole']))&&($_SESSION['EmRole']=='admin')) {var_dump($_SESSION);}
    if (isset($_SESSION['EmName'])){$MyName=$_SESSION['EmName'];}
    if (isset($_SESSION['EmRole'])){$MyRole=$_SESSION['EmRole'];}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?=$title?></title>
        <!--
        <link rel="stylesheet" type="text/css" href="https://bootswatch.com/5/sandstone/bootstrap.min.css">
        -->
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/_bootswatch.scss">
        <link rel="stylesheet" type="text/css" href="css/_variables.scss">
        <style>
            body{
            background-color: <?=VIEW_BACKGROUND?>; /* Цвет фона веб-страницы */
       } 
    </style>
    </head>
    <body>
        
        <div>
            <div>                    
                <h4>                    
                    <p>Информационная система АЛЬТ-ТЕХ
                        <a href="index_admin.php?controller=ATMainFormCtrl&action=Exit"><button class='btn btn-secondary'>ВЫХОД</button></a>
                    </p>
                    <p>Добрый день, <?=$MyName?><input type='hidden' id='SessionEmRole' name='SessionEmRole' value='<?=$MyRole?>'></p>
                </h4>                
            </div>
            <?=$content?>
        </div>
        
        <script src="js/jquery.min.js"></script>
        
        <script src="js/bootstrap.bundle.min.js"></script>
        
        <script src="js/prism.js" data-manual=""></script>
        <!--
        
        
        -->
    </body>
</html>
