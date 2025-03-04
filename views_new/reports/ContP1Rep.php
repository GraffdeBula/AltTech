<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>       
    </head>
    <body>
        <div>
            <h5>Договоры БФЛ/ЗОК</h5>    
            <a href='downloads/NewContRep.xlsx'><button class='btn btn-success'>В EXCEL</button></a>
            <form>
                    <label>Филиал</label>
                    <?php                    
                        (new EchoBranchList())->echoList('','BranchName');
                        (new MyForm('ReportsCtrl','ContP1Rep'))->AddForm2();
                    ?>
                    <label>Показать договоры от </label><input type='date' name='DateF'>
                    <label> до </label><input type='date' name='DateL'> 
                    <button class='btn btn-info'>Сформировать отчёт</button>
                </form>
                        
            <table class='table table-hover'>
                <thead>
                    <tr>                       
                        <th scope='col'>ClCode</th>
                        <th scope='col'>ContCode</th>
                        <th scope='col'>AMO</th>
                        <th scope='col'>ФИО</th>
                        <th scope='col'>Подразделение</th>
                        <th scope='col'>Менеджер</th>                        
                        <th scope='col'>Дата договора</th>
                        <th scope='col'>Дата первого платежа</th>
                        <th scope='col'>Программа</th>
                        <th scope='col'>Тариф</th>
                        <th scope='col'>Сумма договора</th>
                        <th scope='col'>Скидка</th>
                        <th scope='col'>Число платежей</th>
                        <th scope='col'>Внесено по договору</th>                        
                    </tr>
                </thead>
                <tbody>                    
                <?php
                    foreach ($Report as $Cont){                        
                        echo("<tr class='table-secondary'>");
                        echo("<td><a target='_blank' href='index.php?controller=ATClientFileCtrl&ClCode={$Cont->CLCODE}'>{$Cont->CLCODE}</a></td>");                        
                        echo("<td><a target='_blank' href='index.php?controller=ATContP1FileFrontCtrl&ClCode={$Cont->CLCODE}&ContCode={$Cont->CONTCODE}'>{$Cont->CONTCODE}</a></td>");
                        echo("<td><a target='_blank' href='https://fpcalternative.amocrm.ru/leads/detail/{$Cont->AKLEADID}'>$Cont->AKLEADID</a></td>");
                        echo("<td>$Cont->CLFIO</td>");
                        echo("<td>{$Cont->FROFFICE}</td>");
                        echo("<td>{$Cont->FRPERSMANAGER}</td>");                        
                        echo("<td>".(new PrintFunctions())->DateToStr($Cont->FRCONTDATE)."</td>");
                        echo("<td>".(new PrintFunctions())->DateToStr($Cont->PAYDATE)."</td>");
                        echo("<td>{$Cont->FRCONTPROG}</td>");
                        echo("<td>{$Cont->FRCONTTARIF}</td>");
                        echo str_replace('.',',',"<td>{$Cont->FRCONTSUM}</td>");
                        echo str_replace('.',',',"<td>{$Cont->DISCOUNTSUM}</td>");
                        echo ("<td>{$Cont->PAYNUM}</td>");
                        echo ("<td>".$Cont->PAYSUM."</td>");
                        echo("<tr>");
                    }                    
                ?>
                </tbody>
            </table>                                                                                                                    
        </div>
    </body>
</html>
