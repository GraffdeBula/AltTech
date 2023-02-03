<?php    
    if ((isset($_SESSION['EmRole']))&&($_SESSION['EmRole']=='admin')) {var_dump($_SESSION);}    
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
        
    </head>
    <body>
        <div>
            <div>                    
                <h3>                    
                    <p>Информационная система АЛЬТ-ТЕХ (КЛИЕНТ 2.0)   ООО ФПК АЛЬТЕРНАТИВА</p>
                </h3>                
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
