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
            <?php (new MyForm('BranchDrCtrl','BranchUpd',0,0))->AddForm2();?>
            <input type='hidden' name='BranchID' value='<?=$Branch->ID?>'>
            <p>
                <label>Название</label><input name='BRNAME' value='<?=$Branch->BRNAME?>'>
                <label>Регион</label><input name='BRREGION' value='<?=$Branch->BRREGION?>'>
                <label>Город</label><input name='BRCITY' value='<?=$Branch->BRCITY?>'>
                <label>Название в старой БД</label><input name='BRNAMEOLD' value='<?=$Branch->BRNAMEOLD?>'>
            </p>
            <p>
                <label>Руководитель</label><input name='BRDIR' value='<?=$Branch->BRDIR?>'>
                <label>Адрес</label><input name='BRADDRESSFACT' value='<?=$Branch->BRADDRESSFACT?>'>
                <label>КПП</label><input name='BRKPP' value='<?=$Branch->BRKPP?>'>
                <label>Префикс орг.</label><input name='BRORGPREF' value='<?=$Branch->BRORGPREF?>'>
            </p>
            <p>
                <label>Бухг</label><input name='BRBUCH1' value='<?=$Branch->BRBUCH1?>'>
                <label>Кассир</label><input name='BRKASS1' value='<?=$Branch->BRKASS1?>'>
                <label>Бухг оф.</label><input name='BRBUCH2' value='<?=$Branch->BRBUCH2?>'>
                <label>Кассир оф.</label><input name='BRKASS2' value='<?=$Branch->BRKASS2?>'>
            </p>
            <button type="submit" class="btn btn-warning">СОХРАНИТЬ</button>
        </form>
    </body>
</html>
