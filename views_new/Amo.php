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
    <h1>AMO</h1>
    <form method='get'>
        <?php
            (new MyForm('AmoCtrl','GetList',0,0))->AddForm2();
        ?>
    <input type="date" name="datefirst">
    <input type="date" name="datelast">
    <button class='btn btn-secondary btn-sm'>ЗАГРУЗИТЬ СПИСОК</button><br>
    </form>
    <?php
        if(isset($LeadList)){
            var_dump($LeadList);
            foreach($LeadList as $key=>$Lead){
                var_dump($Lead);
                echo("<br>============<br>");
            }
        }
    ?>
</body>   
</html>
