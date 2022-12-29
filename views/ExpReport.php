

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>ОТЧЁТ ПО ЭКСПЕРТИЗАМ</title>
        <link  href='/AltTech/css/css-framework.css' rel='stylesheet'>
        <link  href='/AltTech/css/css-my.css' rel='stylesheet'>
    </head>
    <body>
        <div class="g">
            <div class="g-row">
                <a href="/AltTech/index_admin.php"><button class="f-bu f-bu-warning">НАЗАД</button></a>
            </div>            
            <!--div class="g-row">
                <a href="/AltTech/downloads/reptotal.xls"><button class="f-bu f-bu-success">ВЫГРУЗИТЬ В EXCEL</button></a>
            </div-->    
            <table>
                <caption>ОТЧЁТ ПО ЭКСПЕРТИЗАМ1</caption>
                <tr>
                    <th>Код</th>
                    <th>ID</th>
                    <th>Клиент</th>
                    <th>ОП</th>
                    <th>Дата ЭПЭ</th>
                    <th>Кто провёл</th>
                    <th>Сумма долга</th>
                </tr>
                <?php
                foreach($Report as $Expertise){
                    echo("<tr>");                    
                    echo("<td>{$Expertise->CLCODE}</td>");
                    echo("<td>{$Expertise->CONTCODE}</td>");
                    echo("<td>{$Expertise->CLNAME}</td>");
                    echo("<td>{$Expertise->BRANCH}</td>");
                    echo("<td>{$Expertise->EXPDAT}</td>");
                    echo("<td>{$Expertise->EXPEMP}</td>");
                    echo("<td>{$Expertise->DEBTSUM}</td>");
                    echo("</tr>");
                }
                ?>
            </table>
            
        </div>
    </body>
</html>
