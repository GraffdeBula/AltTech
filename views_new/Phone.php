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
    <h1>PHONE 25 03 2025</h1>
    
    <form>
        <?php        
            (new MyForm('PhoneCtrl','Auth'))->AddForm2()
        ?>
        <button class="btn btn-primary">АВТОРИЗАЦИЯ</button>
    </form>
    <form>
        <?php        
            (new MyForm('PhoneCtrl','Call'))->AddForm2()
        ?>
        <label>Номер телефона</label><input name="Phone" value="">
        <button class="btn btn-primary">ПОЗВОНИТЬ</button>
    </form>
    
    <?php
        #echo("<h2>".$Phone[0]."</h2>");
        var_dump($Phone);
    ?>
    
</body>   

</html>
