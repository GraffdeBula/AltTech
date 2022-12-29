

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>ОСТАТКИ СРЕДСТВ НА ХРАНЕНИИ</title>
        <link  href='/AltTech/css/css-framework.css' rel='stylesheet'>
        <link  href='/AltTech/css/css-my.css' rel='stylesheet'>
    </head>
    <body>
        <div class="g">
            <div class="g-row">
                <a href="/AltTech/index_admin.php"><button class="f-bu f-bu-warning">НАЗАД</button></a>
            </div>
            <div class="g-row">
                <a href="/AltTech/downloads/reptotal.xls"><button class="f-bu f-bu-success">ВЫГРУЗИТЬ В EXCEL</button></a>
            </div>    
            <table>
                <caption>СВОДНЫЙ ОТЧЁТ ПО КОМПАНИИ 1</caption>
                <tr>
                    <th>ФИЛИАЛ</th>
                    <th>ВНЕСЕНО</th>
                    <th>ВЫДАНО</th>
                    <th>ОСТАТОК</th>
                </tr>
                <?php
                foreach($rep as $branch){
                    echo("<tr>");
                    echo("<form method='get'>");
                    echo("<input type='hidden' name='brInd' value='{$branch->BRANCH}'>");
                    echo("<input type='hidden' name='controller' value='report1_ctrl'>");
                    echo("<input type='hidden' name='repInd' value='rep1'>");
                    echo("<td width=250px'><button class='f-bu f-bu-default'>{$branch->BRANCH}</button></td>");
                    echo("</form>");
                    echo("<td>{$branch->SUM1}</td>");
                    echo("<td>{$branch->SUM2}</td>");
                    echo("<td>{$branch->SUM3}</td>");
                    echo("</tr>");
                }
                ?>
            </table>
            
        </div>
    </body>
</html>
