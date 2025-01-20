<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>       
    </head>
    <body>     
        <a href="/<?=WORK_FOLDER?>/downloads/<?=$DocName?>.xlsx"><button class='btn btn-success'>Выгрузить в Excel</button></a>
        
        <a href="/<?=WORK_FOLDER?>/index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName=<?=$_GET['BrName']?>&DateF=<?=$_GET['DateF']?>&DateL=<?=$_GET['DateL']?>&Pays=1">
            <button class='btn btn-warning'>Показать только просрочников</button>
        </a>
        
        <a href="/<?=WORK_FOLDER?>/index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName=<?=$_GET['BrName']?>&DateF=<?=$_GET['DateF']?>&DateL=<?=$_GET['DateL']?>">
            <button class='btn btn-info'>Показать всех</button>
        </a>
        
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
                  <th scope="col">дней</th>
                </tr>
            </thead>
            <tbody>
                             
            <?php
                $Sum=0;
                foreach($PayList as $Cont){
                    $ContDate=(new PrintFunctions())->DateToStr($Cont->FRCONTDATE);
                    $LastDate=(new PrintFunctions())->DateToStr($Cont->PAYLASTDATE);
                    $PayDate=(new PrintFunctions())->DateToStr($Cont->PAYDATE);
                    
                    $CurDate=new DateTime();
                    $Targ=new DateTime($LastDate);
                    $Diff=(int)$CurDate->diff($Targ)->format('%a');
                    if ($Diff>30){
                        $RowClass='table-danger';
                    } else {
                        $RowClass='table-info';
                    }
                    
                    if (isset($_GET['Pays'])&&($Diff<=30)){
                        continue;
                    }
                    
                    $Sum=$Sum+$Cont->PAYSUM;
                    echo("<tr class='{$RowClass}'>");
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
                    echo("<td>{$Diff}</td>");
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
