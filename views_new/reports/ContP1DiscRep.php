<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>       
    </head>
    <body>
        <div>
            <h5>Отчёт по скидкам</h5>    
            <a href='downloads/ContP1Disc.xlsx'><button class='btn btn-success'>В EXCEL</button></a>
            <form>
                <?php                    
                    
                    (new MyForm('ReportsCtrl','ContP1DiscRep'))->AddForm2();
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
                        <th scope='col'>ФИО</th>
                        <th scope='col'>Подразделение</th>    
                        <th scope='col'>Риски</th>
                        <th scope='col'>Дата договора</th>
                        <th scope='col'>Дата допсоглашения</th>
                        <th scope='col'>Сумма доплаты за сложность</th>
                        <th scope='col'>Тариф</th>
                        <th scope='col'>Сумма договора</th>                        
                        <th scope='col'>Скидка</th>
                        <th scope='col'>Число кредитов</th>
                        <th scope='col'>Сложных кредиторов</th>
                        <th scope='col'>Сумма долга</th>
                        
                        
                    </tr>
                </thead>
                <tbody>                    
                <?php
                    $i=0;
                    $ThisCont[0]=0;
                    foreach ($Report as $Cont){                        
                        $i++;
                        $ThisCont[$i]=$Cont->CONTCODE;
                        echo("<tr class='table-secondary'>");
                        if ($ThisCont[$i]!=$ThisCont[$i-1]){
                            echo("<td><a target='_blank' href='index.php?controller=ATClientFileCtrl&ClCode={$Cont->CLCODE}'>{$Cont->CLCODE}</a></td>");                        
                            echo("<td><a target='_blank' href='index.php?controller=ATContP1FileFrontCtrl&ClCode={$Cont->CLCODE}&ContCode={$Cont->CONTCODE}'>{$Cont->CONTCODE}</a></td>");
                            echo("<td>$Cont->CLFIO</td>");
                            echo("<td>{$Cont->FROFFICE}</td>");  
                        }else{
                            echo("<td>-</td>");
                            echo("<td>-</td>");
                            echo("<td>-</td>");
                            echo("<td>-</td>");
                        }
                        echo("<td>{$Cont->EXLISTVALUE}</td>");
                        if ($ThisCont[$i]!=$ThisCont[$i-1]){
                            echo("<td>".(new PrintFunctions())->DateToStr($Cont->FRCONTDATE)."</td>");
                            echo("<td>".(new PrintFunctions())->DateToStr($Cont->FRDOPDATE)."</td>");
                            echo str_replace('.',',',"<td>{$Cont->FRDOPSUM}</td>");
                            echo("<td>{$Cont->FRCONTTARIF}</td>");
                            echo str_replace('.',',',"<td>{$Cont->FRCONTSUM}</td>");
                            echo str_replace('.',',',"<td>{$Cont->DISCOUNTSUM}</td>");
                            echo("<td>{$Cont->FRCRNUM}</td>");
                            echo("<td>{$Cont->FRCOMPLEXCRNUM}</td>");
                            echo str_replace('.',',',"<td>{$Cont->EXTOTDEBTSUM}</td>");
                        }
                        echo("<tr>");
                    }                    
                ?>
                </tbody>
            </table>                                                                                                                    
        </div>
    </body>
</html>
