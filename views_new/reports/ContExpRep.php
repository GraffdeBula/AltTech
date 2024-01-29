<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>       
    </head>
    <body>
        <div>
            <h5>Договоры Экспертизы</h5>                                              
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
                        echo("<tr class='table-secondary'>");
                        echo("<td>{$Cont->CLCODE}</td>");                              
                        echo("<td>{$Cont->CONTCODE}</td>");
                        echo("<td><a target='_blank' href='index.php?controller=ATClientFileCtrl&ClCode={$Cont->CLCODE}'><button class='btn btn-secondary'>{$Cont->CLFIO}</button></a></td>");
                        echo("<td>{$Cont->FROFFICE}</td>");
                        echo("<td>{$Cont->FRPERSMANAGER}</td>");
                        echo("<td>{$Cont->FREXPDATE}</td>");
                        echo("<td>{$Cont->PAYDATE}</td>");
                        echo("<td>{$Cont->FREXPSUM}</td>");
                        echo("<td>{$Cont->PAYSUM}</td>");
                        echo("<tr>");
                    }                    
                ?>
                </tbody>
            </table>                                                                                                                    
        </div>
    </body>
</html>
