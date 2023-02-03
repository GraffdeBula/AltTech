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
                <?php (new MyForm('P4ReportCtrl','ShowRep'))->AddForm2();?>
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
                        <th scope='col'>Результат</th>
                        
                    </tr>
                </thead>
                <tbody>                    
                    <?php
                        foreach ($Report as $Cont){
                            echo("<tr class='table-secondary'>");
                            foreach($Cont as $ContAtr){
                                echo("<td>{$ContAtr}</td>");
                            }                                    
                        }                    
                    ?>
                </tbody>
            </table>
            
        </div>
    </body>
</html>
