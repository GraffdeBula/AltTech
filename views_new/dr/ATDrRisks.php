

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>СПРАВОЧНИК РЕЗУЛЬТАТОВ ЭПЭ для новой базы</title>
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
                    <input type='hidden' name='controller' value='ExpertDrCtrl'>
                    <input type='hidden' name='action' value='ExpRiskAdd'>
                    <label>РИСК</label><input name='ExpRisk' value='' autocomplete="off">
                    <button class="f-bu f-bu-success">ДОБАВИТЬ</button>
                </div>               
            </form>
            <div class='g-row'>
                <table>
                    <caption>РИСКИ ДЛЯ ЭКСПЕРТИЗЫ</caption>
                <tr>
                    <th>Код</th>
                    <th>Значение</th>
                </tr>
                <?php
                    foreach($RiskList as $Risk){
                        echo("<tr>");
                        echo("<td width=50px>{$Risk->ID}</td>");
                        echo("<td width=500px>{$Risk->DRVALUE}</td>");
                        echo("<td>"
                            ."<form method='get'>"
                            ."<input name='ExpRiskID' type='hidden' value='{$Risk->ID}'>"
                            ."<input name='controller' type='hidden' value='ExpertDrCtrl'>"
                            ."<input name='action' type='hidden' value='ExpRiskDel'>"
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
