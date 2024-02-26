<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>       
    </head>
    <body>
        <div>
            <h5>Договоры Экспертизы</h5>                                              
            <a href='downloads/NewExpRep.xlsx'><button class='btn btn-success'>В EXCEL</button></a>
            <table class='table table-hover'>
                <thead>
                    <tr>                       
                        <th scope='col'>Переход</th>
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
                        echo("<tr class='table-secondary'>");
                        echo("<td><a target='_blank' href='index.php?controller=ATClientFileCtrl&ClCode={$Cont->CLCODE}'><button class='btn btn-success'>В ДОСЬЕ</button></a></td>");
                        echo("<td>{$Cont->CLCODE}</td>");
                        echo("<td>{$Cont->CONTCODE}</td>");
                        echo("<td>{$Cont->CLFIO}</td>");
                        echo("<td>{$Cont->FROFFICE}</td>");
                        echo("<td>{$Cont->FRPERSMANAGER}</td>");
                        echo("<td>{$Cont->FREXPDATE}</td>");
                        echo("<td>{$Cont->PAYDATE}</td>");
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
