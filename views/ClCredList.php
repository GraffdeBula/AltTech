<?php

?>
<!DOCTYPE html>
<html>
<head>
    <title>СПИСОК КРЕДИТОРОВ</title>
    
</head>
<body>
    <div class='g'>
	<div class='g-row'><br></div>
        <div class='g-row'> <!--фильтр по кредитору-->                
            <form method="GET">
                <p>ФИЛЬТР ПО КРЕДИТОРУ
                <input type='hidden' name='CONTCODE' value='<?=$_GET['CONTCODE']?>'>
                <input type='hidden' name='controller' value='CreditorsCtrl'>
                <input type='hidden' name='action' value='Filter'>
                <select id="my_filt" name="myFilt">
                    <?php                             
                        foreach($args['Banks'] as $Bank){
                            echo("<option>{$Bank->CRNAME}</option>");
                        }
                    ?>	
                </select>
                <button type="submit" class="f-bu f-bu-default" onclick="myFilt()">ВЫБРАТЬ</button>
                <!--button type="submit" class="f-bu f-bu-success" onclick="myFiltClear()">ОЧИСТИТЬ</button-->
                </p>
            </form>
        </div>
        <div class='g-row'> <!--табд=лица с кредитами-->
        
            <table>
            <caption>СПИСОК КРЕДИТОВ</caption>
            <thead>
                <tr>		
                    <th>Наименование</th>                
                    <th>Адрес</th>
                    <th>ИНН</th>                
                    <th>ОГРН</th>
                    <th>Текущий</th>
                    <th>По договору</th>
                    <th>Номер договора</th>
                    <th>Дата договора</th>
                    <th>Всего долг</th>
                    <th>Просроченный долг</th>
                    <th>Штрафы</th>
                    <th>Подтверждение</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $inpInd=0;//индекс строки для генерации id полей
                    foreach($args['Credits'] as $Credit){
                        $inpInd=$inpInd+1;
                        echo('<tr>');
                        echo("<form method='GET'>");
                            echo("<input type='hidden' name='CRUPD' value='CRUPD'>");
                            echo("<input type='hidden' name='CRCODE' value='{$Credit->CRCODE}'>");
                            echo("<input type='hidden' name='CONTCODE' value='{$Credit->CONTCODE}'>");
                            echo("<input type='hidden' name='controller' value='CreditorsCtrl'>");
                            #echo("<input type='hidden' name='action' value='UpdCred'>");
                            echo("<th><input type='text' disabled name='CRNAME' value='{$Credit->CRNAME}'></th>");
                            echo("<th><input type='text' disabled name='CRADDRESS' value='{$Credit->CRADDRESS}'></th>");
                            echo("<th><input type='text' name='CRINN' value='{$Credit->CRINN}'></th>");
                            echo("<th><input type='text' disabled name='CROGRN' value='{$Credit->CROGRN}'></th>");
                            echo("<th><input type='text' disabled name='CRWNAMECUR' value='{$Credit->CRWNAMECURR}'></th>");
                            echo("<th><input type='text' disabled name='CRWNAME' value='{$Credit->CRWNAME}'></th>");
                            echo("<th><input type='text' disabled name='CRCONTNUM' value='{$Credit->CRCONTNUM}'></th>");
                            echo("<th><input type='text' disabled name='CROPENDATE' value='{$Credit->CROPENDATE}'></th>");
                            echo("<th><input type='text' name='CRDEBTSUM' value='{$Credit->CRDEBTSUM}' id='debt1-{$inpInd}' class='crdebtsum'></th>");
                            echo("<th><input type='text' name='CRDEBTDELAYSUM' value='{$Credit->CRDEBTDELAYSUM}' id='debt2-{$inpInd}' class='crdebtsum'></th>");
                            echo("<th><input type='text' name='CRDEBTFEESUM' value='{$Credit->CRDEBTFEESUM}' id='debt3-{$inpInd}' class='crdebtsum'</th>");
                            echo("<th><button type='submit' class='f-bu f-bu-warning'>Сохранить</button></th>");
                        echo("</form>");
                     echo('</tr>');
                    }
                ?>
            </tbody>

            </table>   

        </div>
        <div id="my_calc">
            <h3 id="inpIndCh"></h3>
            
            <ul class="collection">
                <li class="collection-item">
                <input type="text" value="" class="calcInp">
                </li>
                <li class="collection-item">
                <input type="text" value="" class="calcInp">
                </li>
                <li class="collection-item">
                <input type="text" value="" class="calcInp">
                </li>

            </ul>
            <div class="f-input">
                <button class="f-bu f-bu-warning" onclick="myCount()">РАСЧЁТ</button>
                <button class="f-bu f-bu-success" onclick="myAdd()">ДОБАВИТЬ</button>
                <button class="f-bu f-bu-default" onclick="myCancel()">ОТМЕНА</button>
            </div>
        </div>
        <div id="my_background"></div>
    </div>
    
    <script src="./js/ClCredListView.js"></script>
</body>
</html>