<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Отчёт по разовым услугам</title>       
    </head>
    <body>
        <div>
            <p>Отчёт по разовым услугам</p>
            
            
            <form method='get' autocomplete='off'>
                <label>Филиал</label>
                <?php                    
                    (new EchoBranchList())->echoList('','BranchName');
                    (new MyForm('ReportsCtrl','ContP1Rep'))->AddForm2();
                    (new MyForm('P4ReportCtrl','ShowRep'))->AddForm2();
                ?>
                <label>Показать договоры от </label><input type='date' name='DateF'>
                <label> до </label><input type='date' name='DateL'> 
                <button class='btn btn-info'>СПИСОК</button>                
            </form>            
            <a href='/AltTech/downloads/P4Report.xlsx'><button class='btn btn-success'>Выгрузка в Excel</button></a>
                                    
            <table class='table table-hover'>
                <thead>
                    <tr>
                        <th scope='col'>CLCODE</th>
                        <th scope='col'>ID</th>
                        <th scope='col'>Клиент</th>
                        <th scope='col'>Филиал</th>
                        <th scope='col'>Менеджер</th>
                        <th scope='col'>Сумма</th>
                        <th scope='col'>Дата дог.</th>
                        <th scope='col'>Юрист</th>
                        <th scope='col'>Отрасль</th>
                        <th scope='col'>Услуга</th>
                        <th scope='col'>Комментарий</th>
                        
                    </tr>
                </thead>
                <tbody>                    
                    <?php
                        foreach ($Report as $Cont){
                            $ContDate=(new PrintFunctions())->DateToStr($Cont->FRCONTDATE);
                            echo("<tr class='table-secondary'>");
                                echo("<td><a target='_blank' href='index.php?controller=ATClientFileCtrl&ClCode={$Cont->CLCODE}'>$Cont->CLCODE</a></td>");
                                echo("<td><a target='_blank' href='index.php?controller=ATContP4FileFrontCtrl&ClCode={$Cont->CLCODE}&ContCode={$Cont->CONTCODE}'>$Cont->CONTCODE</a></td>");
                                echo("<td>$Cont->CLNAME</td>");
                                echo("<td>$Cont->FROFFICE</td>");
                                echo("<td>$Cont->FRPERSMANAGER</td>");
                                echo str_replace('.',',',"<td>$Cont->FRCONTSUM</td>");
                                echo("<td>$ContDate</td>");
                                echo("<td>$Cont->FRJURIST</td>");
                                echo("<td>$Cont->FRJURBRANCH</td>");
                                echo("<td>$Cont->FRCONTSERVICE</td>");
                                echo("<td>$Cont->FRCONTRESULT</td>");
                            echo("</tr>"); 
                        }                    
                    ?>
                </tbody>
            </table>
            
        </div>
    </body>
</html>
