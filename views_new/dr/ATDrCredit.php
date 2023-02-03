

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>СПРАВОЧНИК ПОЛЕЙ ДЛЯ АНКЕТЫ КРЕДИТА для новой базы</title>
        <link  href='/AltTech/css/css-framework.css' rel='stylesheet'>
        <link  href='/AltTech/css/css-my.css' rel='stylesheet'>
    </head>
    <body>
        <div class="g">
            <div class="g-row">
                <a href="/AltTech/index_admin.php"><button class="f-bu f-bu-warning">НАЗАД</button></a>
            </div>            
            <form method='get'>
                <div class="f-row">
                    <input type='hidden' name='controller' value='ATDRCtrl'>
                    <input type='hidden' name='action' value='CreditDrAdd'>
                    <div class="g-3">
                        <label>Свойство кредита</label><input name='DrName' value='' autocomplete="off">
                    </div>
                    <div class="g-3">
                        <label>Значение</label><input name='DrValue' value='' autocomplete="off">
                    </div>
                    <button class="f-bu f-bu-success">ДОБАВИТЬ</button>
                </div>               
            </form>
            <div class='g-row'>
                <table>
                    <caption>СПРАВОЧНИК ПОЛЕЙ ДЛЯ АНКЕТЫ КРЕДИТА</caption>
                <tr>
                    <th>Код</th>
                    <th>Вид справочника</th>
                    <th>Значение</th>
                    <th>Удалить</th>
                </tr>
                <?php
                    foreach($AnketaList as $Ank){
                        echo("<tr>");
                        echo("<td width=50px>{$Ank->ID}</td>");
                        echo("<td width=500px>{$Ank->DRNAME}</td>");
                        echo("<td width=500px>{$Ank->DRVALUE}</td>");
                        echo("<td>"
                            ."<form method='get'>"
                            ."<input name='DrID' type='hidden' value='{$Ank->ID}'>"
                            ."<input name='controller' type='hidden' value='ATDRCtrl'>"
                            ."<input name='action' type='hidden' value='CreditDrDel'>"
                            ."<button class='f-bu f-bu-warning'>УДАЛИТЬ</button></td>"
                            ."</form>");
                            
                        echo("</tr>");
                    }
                ?>
                </table>
            </div>
            
        </div>
    </body>
</html>
