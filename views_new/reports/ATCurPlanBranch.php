<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>       
    </head>
    <body>     
        <a href="/AltTech/downloads/<?=$DocName?>.xlsx"><button class='btn btn-success'>Выгрузить в Excel</button></a>
        <table class="table table-hover">
            <thead>
                <tr>                      
                  <th scope="col">ClCode</th>
                  <th scope="col">ContCode</th>
                  <th scope="col">ФИО</th>
                  <th scope="col">ДатаДоговора</th>
                  <th scope="col">Программа</th>
                  <th scope="col">Тариф</th>
                  <th scope="col">Сумма договора</th>
                  <th scope="col">Внесено по договору</th>
                  <th scope="col">Последний платёж</th>
                  <th scope="col">Сумма платежа</th>
                  <th scope="col">Дата платежа</th>
                </tr>
            </thead>
            <tbody>
                             
            <?php
                $Sum=0;
                foreach($PayList as $Cont){
                    $ContDate=(new PrintFunctions())->DateToStr($Cont->FRCONTDATE);
                    $LastDate=(new PrintFunctions())->DateToStr($Cont->PAYLASTDATE);
                    $PayDate=(new PrintFunctions())->DateToStr($Cont->PAYDATE);
                    $Sum=$Sum+$Cont->PAYSUM;
                    echo("<tr class='table-info'>");
                    echo("<td>{$Cont->CLCODE}</td>");
                    echo("<td>{$Cont->CONTCODE}</td>");
                    echo("<td><a target='_blanc' href='index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$Cont->CLCODE}&ContCode={$Cont->CONTCODE}'>{$Cont->CLFIO}</a></td>");
                    echo("<td>{$ContDate}</td>");
                    echo("<td>{$Cont->FRCONTPROG}</td>");
                    echo("<td>{$Cont->FRCONTTARIF}</td>");
                    echo("<td>{$Cont->FRCONTSUM}</td>");
                    echo("<td>{$Cont->PAYTOTSUM}</td>");
                    echo("<td>{$LastDate}</td>");
                    echo("<td>{$Cont->PAYSUM}</td>");
                    echo("<td>{$PayDate}</td>");
                    echo("</tr>");
                }
            ?>
                <tr class='table-active'>
                    <td></td>
                    <td></td>
                    <td>ИТОГО</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?=$Sum?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
