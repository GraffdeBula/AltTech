<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>       
    </head>
    <body>
        <div>
            <h5>Договоры Экспертизы</h5>                                              
            <div>
                <a href='downloads/NewExpRep.xlsx'><button class='btn btn-success'>В EXCEL</button></a>
                <select></select>
            </div>
            <table class='table table-hover'>
                <thead>
                    <tr>                                               
                        <th scope='col'>ClCode</th>
                        <th scope='col'>ContCode</th>
                        <th scope='col'>ФИО</th>
                        <th scope='col'>Подразделение</th>
                        <th scope='col'>Менеджер</th>                        
                        <th scope='col'>Дата договора</th>
                        <th scope='col'>Дата первого платежа</th>
                        <th scope='col'>Стоимость ЭПЭ</th>
                        <th scope='col'>Всего внесено за ЭПЭ</th>
                    </tr>
                </thead>
                <tbody>                    
                <?php
                    foreach ($Report as $Cont){
                        $ContDate=(new PrintFunctions())->DateToStr($Cont->FREXPDATE);
                        $PayDate=(new PrintFunctions())->DateToStr($Cont->PAYDATE);
                        echo("<tr class='table-secondary'>");                                    
                        echo("<td><a target='_blank' href='index.php?controller=ATClientFileCtrl&ClCode={$Cont->CLCODE}'>{$Cont->CLCODE}</a></td>");                        
                        echo("<td><a target='_blank' href='index.php?controller=ATContP1FileFrontCtrl&ClCode={$Cont->CLCODE}&ContCode={$Cont->CONTCODE}'>{$Cont->CONTCODE}</a></td>");
                        echo("<td>{$Cont->CLFIO}</td>");
                        echo("<td>{$Cont->FROFFICE}</td>");
                        echo("<td>{$Cont->FRPERSMANAGER}</td>");
                        echo("<td>$ContDate</td>");
                        echo("<td>$PayDate</td>");
                        echo str_replace('.',',',"<td>{$Cont->FREXPSUM}</td>");
                        echo str_replace('.',',',"<td>{$Cont->PAYSUM}</td>");
                        echo("<tr>");
                    }                    
                ?>
                </tbody>
            </table>                                                                                                                    
        </div>
    </body>
</html>
