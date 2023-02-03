<?php

?>
<!DOCTYPE html>
<html>
    <head>
                    
    </head>
    <body>
        <h4>Карточка филиала</h4>
        <h5><?=$Branch->BRNAME?></h5>
        <form method="get" autocomplete="off">
            <?php
            (new MyForm('BranchDrCtrl','BranchUpd',0,0))->AddForm2();
            foreach($Branch as $FieldName => $FieldValue){
                echo("<label>{$FieldName}</label><input type='text' name='{$FieldName}' value='{$FieldValue}'><br>");
            }
            ?>
            <button type="submit" class="btn btn-warning">СОХРАНИТЬ</button>
        </form>
    </body>
</html>
