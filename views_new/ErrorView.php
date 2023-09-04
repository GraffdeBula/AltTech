<?php
/*
 * досье клиента
 *  */
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <div>        
        <h3>
            <p>ОШИБКА</p>
        </h3>           
    </div>
    <div>        
        <?="<p style='color: red; font-weight: bold'>".$ErrType."</p>"?>
    </div>
    <div>        
        <a href="<?=$_SESSION['url']?>"><button class='btn btn-success' style='color: red; font-weight: bold'>ВЕРНУТЬСЯ НАЗАД</button></a>    
    </div>
        
</body>
</html>
