<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>       
    </head>
    <body>
        <div>
            <h5>Расторжения Договоров БФЛ/ЗОК</h5>    
            <a href='downloads/DropContRep.xlsx'><button class='btn btn-success'>В EXCEL</button></a>
            <form>
                <p>
                    <label>Филиал</label>
                    <?php                    
                        (new EchoBranchList())->echoList('','BranchName');
                        (new MyForm('ReportsCtrl','ShowContP1DropRep'))->AddForm2();
                    ?>
                    <label>Показать договоры от </label><input type='date' name='DateF'>
                    <label> до </label><input type='date' name='DateL'> 
                </p>
                <p> 
                    <label>Показать договоры расторгнутые с </label><input type='date' name='DateDF'>
                    <label> до </label><input type='date' name='DateDL'> 
                    <button class='btn btn-info'>Сформировать отчёт</button>
                </p>    
            </form>
                        
            <table class='table table-hover'>
                <thead>
                    <tr>                       
                        <th scope='col'>ClCode</th>
                        <th scope='col'>ContCode</th>
                        <th scope='col'>ФИО</th>
                        <th scope='col'>Подразделение</th>
                        <th scope='col'>Менеджер</th>
                        <th scope='col'>Долг по ЭПЭ</th>
                        <th scope='col'>Дата договора</th>
                        <th scope='col'>Дата первого платежа</th>
                        <th scope='col'>Дата расторжения</th>
                        <th scope='col'>Программа</th>
                        <th scope='col'>Тариф</th>
                        <th scope='col'>Сумма</th>
                        <th scope='col'>Скидка</th>
                    </tr>
                </thead>
                <tbody>                    
                <?php
                    foreach ($Report as $Cont){
                        $ContDate=(new PrintFunctions())->DateToStr($Cont->FRCONTDATE);
                        $PayDate=(new PrintFunctions())->DateToStr($Cont->PAYDATE);
                        echo("<tr class='table-secondary'>");
                        echo("<td><a target='_blank' href='index.php?controller=ATClientFileCtrl&ClCode={$Cont->CLCODE}'>{$Cont->CLCODE}</a></td>");                        
                        echo("<td><a target='_blank' href='index.php?controller=ATContP1FileFrontCtrl&ClCode={$Cont->CLCODE}&ContCode={$Cont->CONTCODE}'>{$Cont->CONTCODE}</a></td>");
                        echo("<td>$Cont->CLFIO</td>");
                        echo("<td>{$Cont->FROFFICE}</td>");
                        echo("<td>{$Cont->FRPERSMANAGER}</td>");
                        echo str_replace('.',',',"<td>{$Cont->EXTOTDEBTSUM}</td>");
                        echo("<td>{$ContDate}</td>");
                        echo("<td>{$PayDate}</td>");
                        echo("<td>".(new PrintFunctions())->DateToStr($Cont->FRARCHDATE)."</td>");
                        echo("<td>{$Cont->FRCONTPROG}</td>");
                        echo("<td>{$Cont->FRCONTTARIF}</td>");
                        echo str_replace('.',',',"<td>{$Cont->FRCONTSUM}</td>");
                        echo str_replace('.',',',"<td>{$Cont->DISCOUNTSUM}</td>");
                        echo("<tr>");
                    }                    
                ?>
                </tbody>
            </table>                                                                                                                    
        </div>
    </body>
</html>
