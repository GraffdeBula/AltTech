<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>ОТЧЁТ ПО СРЕДСТВАМ НА ХРАНЕНИИ</title>
        <link  href='/AltTech/css/css-framework.css' rel='stylesheet'>
        <link  href='/AltTech/css/css-my.css' rel='stylesheet'>
    </head>
    <body>
        <div class="g">
            <div class="g-row">
                <a href="/AltTech/index_admin.php?controller=report1_ctrl&repInd=rep1"><button class="f-bu f-bu-warning">НАЗАД</button></a>
            </div>
            <div class="g-row">
                <a href="/AltTech/downloads/repBranch.xlsx"><button class="f-bu f-bu-success">ВЫГРУЗИТЬ В EXCEL</button></a>
            </div>    
            <table>
                <caption>СВОДНЫЙ ОТЧЁТ ПО КОМПАНИИ</caption>
                <tr>
                    <th>clCode</th>
                    <th>contCode</th>
                    <th>Клиент</th>
                    <th>ФИЛИАЛ</th>
                    <th>ВНЕСЕНО</th>
                    <th>ВЫДАНО</th>
                    <th>ОСТАТОК</th>
                </tr>
                <?php
                foreach($rep as $client){
                    echo("<tr>");
                    echo("<td>{$client->CLCODE}</td>");
                    echo("<td>{$client->CONTCODE}</td>");
                    echo("<td>{$client->CLNAME}</td>");
                    echo("<td>{$client->BRANCH}</td>");
                    echo("<td>{$client->SUM1}</td>");
                    echo("<td>{$client->SUM2}</td>");
                    echo("<td>{$client->SUM3}</td>");
                    echo("</tr>");
                }
                ?>
            </table>
        </div>
    </body>
</html>
