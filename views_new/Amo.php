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
            (new MyForm('AmoCtrl','GetLeadList',0,0))->AddForm2();
        ?>
    <input type="date" name="datef">
    <input type="date" name="datel">
    <button class='btn btn-primary btn-sm'>Получить список лидов</button><br>
    
    </form>    
    <a target="_blank" href='downloads/Leads.xlsx'><button class='btn btn-success btn-sm'>Загрузить список лидов</button></a>
    <form>
        <?php
            (new MyForm('AmoCtrl','GetLead',0,0))->AddForm2();
        ?>
        <input type="text" name="leadid">    
        <button class='btn btn-success btn-sm'>Получить лид</button><br>
    </form>
    
    <form>
        <?php
            (new MyForm('AmoCtrl','GetContact',0,0))->AddForm2();
        ?>
        <input type="text" name="contactid">    
        <button class='btn btn-info btn-sm'>Получить контакт</button><br>
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
