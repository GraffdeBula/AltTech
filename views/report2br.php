<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>ДВИЖЕНИЕ СРЕДСТВ НА ХРАНЕНИИ</title>
        <link  href='/AltTech/css/css-framework.css' rel='stylesheet'>
        <link  href='/AltTech/css/css-my.css' rel='stylesheet'>
    </head>
    <body>
        <div class="g">
            <div class="g-row">
                <a href="/AltTech/index_admin.php?controller=report1_ctrl&repInd=rep2&repDat1=<?=$_GET['repDat1']?>&repDat2=<?=$_GET['repDat2']?>"><button class="f-bu f-bu-warning">НАЗАД</button></a>
            </div>
            <div class="g-row">
                <a href="/AltTech/downloads/repBranch2.xlsx"><button class="f-bu f-bu-success">ВЫГРУЗИТЬ В EXCEL</button></a>
            </div>    
            <table>
                <caption>ОТЧЁТ ПО ФИЛИАЛУ</caption>
                <tr>                    
                    <th>contCode</th>
                    <th>Клиент</th>
                    <th>ДАТА</th>
                    <th>СУММА</th>
                    <th>ФИЛИАЛ</th>                    
                </tr>
                <?php
                foreach($rep as $client){
                    echo("<tr>");
                    echo("<td>{$client->CONTCODE}</td>");
                    echo("<td>{$client->CLIENT}</td>");
                    echo("<td>{$client->PKODAT}</td>");
                    echo("<td>{$client->PKOSUM}</td>");
                    echo("<td>{$client->PKOBRANCH}</td>");
                    echo("</tr>");
                }
                ?>
            </table>
        </div>
    </body>
</html>
