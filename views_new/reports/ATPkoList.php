<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>ПЛАТЕЖИ</title>       
    </head>
    <body>
        <div>
            <p>РЕЕСТР ПЛАТЕЖЕЙ</p>
            <form method='get'>
                <?php (new MyForm('PkoListCtrl','FiltList'))->AddForm2();?>
                <label>Дата платежа</label><input type='date' name='PayDate' autocomplete='off'>
                <label>Номер договора</label><input type='text' name='ContCode' autocomplete='off'> 
                <button class='btn btn-info'>СПИСОК</button>
            </form>
            <form>
                <?php (new MyForm('PkoListCtrl','DelPko'))->AddForm2();?>
                <label>InCode</label><input type='text' name='InCode' autocomplete='off'> 
                <button class='btn btn-danger'>Удалить</button>
            </form>
            <table class='table table-hover'>
                <thead>
                </thead>
                <tbody>                    
                    <?php
                        foreach ($PkoList as $Pay){
                            echo("<tr class='table-secondary'>");
                            echo("<td>{$Pay->PKOINCODE}</td>");
                            foreach($Pay as $PayAtr){
                                echo("<td>{$PayAtr}</td>");
                            }                                    
                        }                    
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
