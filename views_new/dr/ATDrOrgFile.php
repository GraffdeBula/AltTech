<!DOCTYPE html>
<html>
    <head>
                    
    </head>
    <body>
        <h4>Карточка организации</h4>
        <h5><?=$Org->ORGNAME?></h5>
        <form method="get" autocomplete="off">
            <?php (new MyForm('OrgDrCtrl','OrgUpd',0,0))->AddForm2();?>
            <input type='hidden' name='OrgID' value="<?=$Org->ID?>">
            <p>                
                <label>Префикс</label><input name='ORGPREF' value="<?=$Org->ORGPREF?>" size='15'>
                <label>Наименование</label><input name='ORGNAME' value='<?=$Org->ORGNAME?>' size='30'>
                <label>Полное наименование</label><input name='ORGFNAME' value='<?=$Org->ORGFNAME?>' size='90'>
            </p>
            <p>
                <label>ОГРН</label><input name='ORGOGRN' value="<?=$Org->ORGOGRN?>">
                <label>ИНН</label><input name='ORGINN' value="<?=$Org->ORGINN?>">
                <label>КПП</label><input name='ORGKPP' value="<?=$Org->ORGKPP?>">
            </p>            
            <p>
                <label>Адрес</label><input name='ORGOFADR' value='<?=$Org->ORGOFADR?>' size='80'>
                <label>e-mail</label><input name='ORGEMAIL' value='<?=$Org->ORGEMAIL?>'>
                <label>ФИО директора</label><input name='ORGDIRNAME' value='<?=$Org->ORGDIRNAME?>' size='35'> 
            </p>
            <p>
                <label>Банк</label><input name='ORGBANKNAME' value='<?=$Org->ORGBANKNAME?>' size='35'>
                <label>р/с</label><input maxlength="20" name='ORGBANKACC' value="<?=$Org->ORGBANKACC?>" size='35'>
                <label>БИК</label><input maxlength="9" name='ORGBANKBIK' value="<?=$Org->ORGBANKBIK?>" size='35'>
                <label>к/с</label><input maxlength="20" name='ORGBANKCORR' value="<?=$Org->ORGBANKCORR?>" size='35'>
            </p>
            <button type='submit' class='btn btn-warning'>СОХРАНИТЬ</button>
        </form>
        
    </body>
</html>
