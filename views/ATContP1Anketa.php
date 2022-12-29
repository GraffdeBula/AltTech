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
    <div class="g">      
        <div class="g-row">
            <div class='g-12'>
                <h3>
                    <p>АЛЬТ-ТЕХ</p>
                </h3>   
            </div>
        </div>
        <div class="g-row">
            <div class='g-12'>
                <h3>
                    <p>ДОГОВОР БФЛ - АНКЕТА ДОГОВОРА</p>
                </h3>   
            </div>
        </div>
        <?php
            echo("<div class='g-row'>");
            echo("<p>Клиент: {$Client->CLFNAME} {$Client->CL1NAME} {$Client->CL2NAME}</p>");
            echo("</div>");
            echo("<div class='g-row'><div class='g-6'>");            
            echo("<p>Договор ID: {$Cont->CONTCODE}</p>");
            echo("</div><div class='g-5'><a href='index_admin.php?controller=ATContP1AnketaCtrl&action=NewCred&ClCode={$Client->CLCODE}&ContCode={$Cont->CONTCODE}'><button class='f-bu f-bu-warning'>ДОБАВИТЬ КРЕДИТНЫЙ ДОГОВОР</button></a>");
            echo("</div></div>");
        ?>
        <div class='g-row'>
            <div class="g-8 cont_list">
                <h5>Список кредитных договоров</h5>
                <?php
                    foreach($CredList as $Cred){
                        echo("<div class='g-row'>{$Cred->CONTCODE} --- {$Cred->CRCODE}</div>");
                    }
                ?>
            </div>
        </div>
        <div class='g-row'>
            <div class="g-8 cont_list">
                <h5>Кредитный договор</h5>
                <form method='post'>
                    <input type='text' name='CRCODE' value=''>
                    <input type='hidden' name='controller' value=''>
                    <input type='hidden' name='action' value=''>
                    
                <div class="g-row">
                    <label>Кредитор по договору</label><input type='text' name='CRBANKCONTNAME' value=''>
                    <label>Вид</label><input type='text' name='CRBANKCONTNAME' value=''>
                    <label>ИНН</label><input type='text' name='CRBANKCONTNAME' value=''>
                </div>
                </form>
            </div>
        </div>
    </div>
   
</body>
</html>
