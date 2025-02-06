<?php
/*
 * для работы с сущностями АМОЦРМ
 *  */

?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <h1>AMO 04 02 2025</h1>
    
    <form>
        <?php        
            (new MyForm('AmoCtrl','Auth'))->AddForm2()
        ?>
        <button class="btn btn-primary">АВТОРИЗАЦИЯ</button>
    </form>
    
    <form>
        <?php        
            (new MyForm('AmoCtrl','GetLead'))->AddForm2()
        ?>
        <button class="btn btn-success">Получить сделку</button>
    </form>
    
    <form>
        <?php        
            (new MyForm('AmoCtrl','GetStatuses'))->AddForm2()
        ?>
        <button class="btn btn-info">Получить воронки</button>
    </form>
    
    <?php
        foreach($AmoResult as $key=>$value){
            echo($key." :: ");
            var_dump($value);        
            echo("<br>");
        }
    ?>
</body>   

</html>
