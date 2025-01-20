<?php

?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>       
    </head>
    <body>
        <div>
            <h5>Отчёт по замечаниям андеррайтера</h5>    
            <a href='downloads/UnderErrRep.xlsx'><button class='btn btn-success'>В EXCEL</button></a>
            <form>
                    <label>Филиал</label>
                    <?php                    
                        (new EchoBranchList())->echoList('','BranchName');
                        (new MyForm('ReportsCtrl','ShowContP1AfterUnder'))->AddForm2();
                    ?>
                    <label> Дата проведения правового анализа от </label><input type='date' name='DateF'>
                    <label> до </label><input type='date' name='DateL'> 
                    <button class='btn btn-info'>Сформировать отчёт</button>
                </form>
                        
            <table class='table table-hover'>
                <thead>
                    <tr>                       
                        <th scope='col'>ClCode</th>
                        <th scope='col'>ContCode</th>
                        <th scope='col'>ФИО</th>
                        <th scope='col'>Подразделение</th>
                        <th scope='col'>Дата договора</th>
                        <th scope='col'>Дата правового анализа</th>
                        <th scope='col'>ФИО юриста</th>
                        <th scope='col'>Дата проверки</th>
                        <th scope='col'>Комментарий андеррайтера</th>
                        
                    </tr>
                </thead>
                <tbody>                    
                <?php
                    foreach ($Report as $Cont){
                        
                        echo("<tr class='table-secondary'>");
                        echo("<td><a target='_blank' href='index.php?controller=ATClientFileCtrl&ClCode={$Cont->CLCODE}'>{$Cont->CLCODE}</a></td>");                        
                        echo("<td><a target='_blank' href='index.php?controller=ATContP1FileFrontCtrl&ClCode={$Cont->CLCODE}&ContCode={$Cont->CONTCODE}'>{$Cont->CONTCODE}</a></td>");
                        echo("<td>$Cont->CLFIO</td>");
                        echo("<td>{$Cont->FROFFICE}</td>");
                        echo("<td>".(new PrintFunctions())->DateToStr($Cont->FRCONTDATE)."</td>");
                        echo("<td>".(new PrintFunctions())->DateToStr($Cont->EXRESDAT)."</td>");
                        echo("<td>{$Cont->EXJURSOGLNAME}</td>");
                        echo("<td>".(new PrintFunctions())->DateToStr($Cont->EXPUNDERDATE)."</td>");
                        echo("<td>{$Cont->EXPUNDERCOMMENT}</td>");
                        echo("<tr>");
                    }                    
                ?>
                </tbody>
            </table>                                                                                                                    
        </div>
    </body>
</html>
