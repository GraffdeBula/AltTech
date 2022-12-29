<?php
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <div class="g">      
        <div class="g-row">
            <div class='g-4'>
                <h3>
                    <p>АЛЬТ-ТЕХ</p>
                </h3>   
            </div>
            <div class='g-4'>
                <h3>
                    <p>АНКЕТА КЛИЕНТА</p>
                </h3>   
            </div>
        </div>
        <hr class="hr-block">        
        <div class="g-row"></div>            
            <h4>ОБЩАЯ ИНФОРМАЦИЯ</h4>                                                
        </div>    
    
        <div class="g-row">
            <div class="g-12">
                <?php                 
                echo("<label>ФАМИЛИЯ</label><input type='text' name='CLFNAME' value={$Client->CLFNAME}>");
                echo("<label>ИМЯ</label><input type='text' name='CL1NAME' value={$Client->CL1NAME}>");
                echo("<label>ОТЧЕСТВО</label><input type='text' name='CL2NAME' value={$Client->CL2NAME}>");
                echo("<br>");
                echo("<label>Дата рождения</label><input type='date' name='CLBIRTHDATE' value={$Client->CLBIRTHDATE}>");
                echo("<label>Место рождения</label><input type='text' class='input-comment' name='CLBIRTHPLACE' value={$Client->CLBIRTHPLACE}>");
                ?>
            </div>                
        </div>
        <hr class="hr-block">
        <div class="g-row">            
            <h4>АДРЕСА И КОНТАКТЫ</h4>  
        </div>    
        <div class="g-row">            
            <div>
                <?php
                foreach($ClPhoneList as $Phone){
                    echo("<input type='hidden' name='controller' value='ATClientAnketaCtrl'>");
                    echo("<input type='text' name='ClPhText' value='{$Phone->CLPHTEXT}'>");
                    echo("<input type='text' name='ClPhone' value='{$Phone->CLPHONE}'>");
                    echo("<input type='text' name='ClPhComment' value='{$Phone->CLPHCOMMENT}'><br>");
                    echo("<hr class='hr-tab'>");
                }
                ?>
            </div>
            
            <h4>добавить телефон</h4>  
            <form method="GET">
                <input type="hidden" name="controller" value="ATClientAnketaCtrl">
                <input type="hidden" name="action" value="AddPhone">
                <input type="hidden" name="ClCode" value="<?php echo($Client->CLCODE);?>">
                <label>тип</label>
                <select name="ClPhText">
                    <option value=""></option>
                    <option value="мобильный">мобильный</option>
                    <option value="домашний">домашний</option>
                    <option value="рабочий">домашний</option>
                    <option value="другой">другой</option>
                </select>
                <label>Номер</label><input type="text" name="ClPhone">
                <label>Комментарий</label><input type="text"name="ClPhComment">
                <button type="submit" class="f-bu f-bu-success">ДОБАВИТЬ</button>
            </form>
        </div>
        <div class="g-row">
            <form method="GET">
                <input type="hidden" name="controller" value="ATClientAnketaCtrl">
                <input type="hidden" name="action" value="SaveClAddress">
                <h5>АДРЕС РЕГИСТРАЦИИ</h5>
                <?php  
                    echo("<div class='g-row'>");
                    echo("<label>ИНДЕКС</label><input type='text' name='CLADRRZIP' value={$Client->CLADRRZIP}>");
                    echo("<label>РЕГИОН</label><input type='text' name='CLADRRREG' value={$Client->CLADRRREG}>");
                    echo("<label>РАЙОН</label><input type='text' name='CLADRRDIST' value={$Client->CLADRRDIST}>");
                    echo("</div>");
                    echo("<div class='g-row'>");
                    echo("<label>ГОРОД</label><input type='text' name='CLADRRCITY' value={$Client->CLADRRCITY}>");
                    echo("<label>УЛИЦА</label><input type='text' name='CLADRRSTR' value={$Client->CLADRRSTR}>");
                    echo("</div>");
                    echo("<div class='g-row'>");
                    echo("<label>ДОМ</label><input type='text' name='CLADRRHOUSE' value={$Client->CLADRRHOUSE}>");
                    echo("<label>КВАРТИРА</label><input type='text' name='CLADRRAPP' value={$Client->CLADRRAPP}>");
                    echo("<label>ЯВЛЯЕТСЯ ЛИ СОБСТВЕННОСТЮ</label><input type='text' name='CLADRRPROPYN' value={$Client->CLADRRPROPYN}>");
                    echo("<label>КОММЕНТАРИЙ</label><input type='text' class='input-comment' name='CLADRRCOMMENT' value={$Client->CLADRRCOMMENT}>");   
                    echo("</div>");
                ?>
                <div class="g-row">
                    <h5>АДРЕС ПРОЖИВАНИЯ</h5>
                </div>
                <?php   

                    echo("<div class='g-row'>");
                    echo("<label>ИНДЕКС</label><input type='text' name='CLADRFZIP' value={$Client->CLADRFZIP}>");
                    echo("<label>РЕГИОН</label><input type='text' name='CLADRFREG' value={$Client->CLADRFREG}>");
                    echo("<label>РАЙОН</label><input type='text' name='CLADRFDIST' value={$Client->CLADRFDIST}>");
                    echo("</div>");
                    echo("<div class='g-row'>");
                    echo("<label>ГОРОД</label><input type='text' name='CLADRFCITY' value={$Client->CLADRFCITY}>");
                    echo("<label>УЛИЦА</label><input type='text' name='CLADRFSTR' value={$Client->CLADRFSTR}>");
                    echo("</div>");
                    echo("<div class='g-row'>");
                    echo("<label>ДОМ</label><input type='text' name='CLADRFHOUSE' value={$Client->CLADRFHOUSE}>");
                    echo("<label>КВАРТИРА</label><input type='text' name='CLADRFAPP' value={$Client->CLADRFAPP}>");
                    echo("<label>ЯВЛЯЕТСЯ ЛИ СОБСТВЕННОСТЮ</label><input type='text' name='CLADRFPROPYN' value={$Client->CLADRFPROPYN}>");
                    echo("<label>КОММЕНТАРИЙ</label><input type='text' class='input-comment' name='CLADRFCOMMENT' value={$Client->CLADRFCOMMENT}>");  
                    echo("</div>");
                ?>
                <div class="g-row">
                    <button class="f-bu f-bu-success">СОХРАНИТЬ</button>
                </div>
            </form>
        </div>
        <hr class="hr-block">
        <div class="g-row">         
            <h4>СЕМЬЯ</h4>  
        </div>
    
        <div class="g-row">         
            <?php 
                echo("<label>СЕМЕЙНЫЙ СТАТУС</label><input type='text' name='CLFAMSTATUS' value={$Client->CLFAMSTATUS}>");
                echo("<label>СУПРУГ</label><input type='text' name='CLFAMPARTNAME' value={$Client->CLFAMPARTNAME}>");
            ?>
            <div>
                <?php
                foreach($ClRelativesList as $Relative){
                    echo("<input type='hidden' name='controller' value='ATClientAnketaCtrl'>");
                    echo("<label>Имя</label>");
                    echo("<input type='text' name='ClRelName' value='{$Relative->CLRELNAME}'>");
                    echo("<label>кем приходится</label>");
                    echo("<input type='text' name='ClRelStatus' value='{$Relative->CLRELSTATUS}'>");
                    echo("<label>дата рождения</label>");
                    echo("<input type='date' name='ClRelBirthDate' value='{$Relative->CLRELBIRTHDATE}'><br>");
                    echo("<input type='text' name='ClRelDocSer' value='{$Relative->CLRELDOCSER}'>");
                    echo("<input type='text' name='ClRelDocNum' value='{$Relative->CLRELDOCNUM}'>");
                    echo("<input type='date' name='ClRelDocDate' value='{$Relative->CLRELDOCDATE}'><br>");
                    echo("<hr class='hr-tab'>");
                }
                ?>
            </div>
            <h4>добавить ребёнка</h4>
            <form method="GET">
                <input type="hidden" name="controller" value="ATClientAnketaCtrl">
                <input type="hidden" name="action" value="AddRelative">
                <input type="hidden" name="ClCode" value="<?php echo($Client->CLCODE);?>">
                <label>Имя</label><input type="text" name="ClRelName">
                <label>Кем приходится</label><input type="text"name="ClRelStatus">
                <label>Дата рождения</label><input type="date"name="ClRelBirthDate"><br>
                <label>Свидетельство о рождении серия</label><input type="text"name="ClRelDocSer">
                <label>номер</label><input type="text"name="ClRelDocNum">
                <label>дата</label><input type="date"name="ClRelDocDate">
                <button type="submit" class="f-bu f-bu-success">ДОБАВИТЬ</button>
            </form>
            
        </div>
        <hr class="hr-block">
        <div class="g-row">         
            <h4>ДОКУМЕНТЫ</h4>  
            <div class="g-row">         
            <?php
            foreach($ClDocumentsList as $Document){                
                echo("<input type='hidden' name='controller' value='ATClientAnketaCtrl'>");
                echo("<label>Вид</label>");
                echo("<input type='text' name='ClDocName' value='{$Document->CLDOCNAME}'>");
                echo("<label>серия</label>");
                echo("<input type='text' name='ClDocSer' value='{$Document->CLDOCSER}'>");
                echo("<label>Номер</label>");
                echo("<input type='text' name='ClDocNum' value='{$Document->CLDOCNUM}'>");
                echo("<label>Комментарий</label>");
                echo("<input type='text' name='ClDocComment' value='{$Document->CLDOCCOMMENT}'><br>");
                echo("<hr class='hr-tab'>");                
                
            }
            ?>
            </div>
            <div class="g-row">
            <h4>добавить документ</h4>  
            <form method="GET">
                <input type="hidden" name="controller" value="ATClientAnketaCtrl">
                <input type="hidden" name="action" value="AddDocument">
                <input type="hidden" name="ClCode" value="<?php echo($Client->CLCODE);?>">
                <label>вид документа</label>
                <select name="ClDocName" value="">
                    <option value=""></option>
                    <option value="паспорт">паспорт</option>
                    <option value="СНИЛС">СНИЛС</option>
                    <option value="Брачный договор">Брачный договор</option>
                    <option value="Свидетельство о браке">Свидетельство о браке</option>
                    <option value="Свидетельство о расторжении брака">Свидетельство о расторжении брака</option>
                    <option value="Свидетельство о смерти">Свидетельство о смерти</option>
                </select>
                <label>серия</label><input type="text" name="ClDocSer">
                <label>номер</label><input type="text" name="ClDocNum">
                <label>Комментарий</label><input type="text" name="ClDocComment">
                <button type="submit" class="f-bu f-bu-success">ДОБАВИТЬ</button>
            </form>
            </div>
            <hr class="hr-block">    
        </div>
        
        <div class="g-row">         
            <h4>ЮРИДИЧЕСКИЙ СТАТУС</h4>  
            <hr class="hr-block">
        </div>
        
        <div class="g-row">         
            <h4>РАБОТА</h4>  
            <hr class="hr-block">
        </div>
        
        <div class="g-row">         
            <h4>ДОХОДЫ</h4>  
                        
            <?php
            foreach($ClIncomesList as $Income){
                echo("<input type='hidden' name='controller' value='ATClientAnketaCtrl'>");
                echo("<label>Вид</label>");
                echo("<input type='text' name='ClIncName' value='{$Income->CLINCNAME}'>");
                echo("<label>Сумма вся</label>");
                echo("<input type='text' name='ClIncSum' value='{$Income->CLINCSUM}'>");
                echo("<label>Сумма официальная</label>");
                echo("<input type='text' name='ClIncSumOf' value='{$Income->CLINCSUMOF}'>");
                echo("<label>На карту</label>");
                echo("<input type='text' name='ClIncCardYN' value='{$Income->CLINCCARDYN}'><br>");
                echo("<label>Банк</label>");
                echo("<input type='text' name='ClIncBank' value='{$Income->CLINCBANK}'>");
                echo("<label>Процент удержания</label>");
                echo("<input type='text' name='ClIncDeduct' value='{$Income->CLINCDEDUCT}'>");
                echo("<label>Доход после удержания</label>");
                echo("<input type='text' name='ClIncSumReal' value='{$Income->CLINCSUMREAL}'>");
                echo("<label>Комментарий</label>");
                echo("<input type='text' name='ClIncComment' value='{$Income->CLINCCOMMENT}'><br>");
                echo("<hr class='hr-tab'>");
            }
            ?>
            
            <div class="g-row">         
            <h4>добавить доход</h4>  
            <form method="GET">
                <input type="hidden" name="controller" value="ATClientAnketaCtrl">
                <input type="hidden" name="action" value="AddIncome">
                <input type="hidden" name="ClCode" value="<?php echo($Client->CLCODE);?>">
                <label>тип</label>
                <select name="ClIncName" value="">
                    <option value=""></option>
                    <option value="зарплата">зарплата</option>
                    <option value="совместительство">совместительство</option>
                    <option value="пенсия">пенсия</option>
                    <option value="пособие">пособие</option>
                    <option value="аренда">аренда</option>
                </select>
                <label>Сумма</label><input type="text" name="ClIncSum">
                <label>Сумма официальная</label><input type="text" name="ClIncSumOf"><br>
                <label>На карту</label><input type="text" name="ClIncCardYN">
                <label>Банк</label><input type="text" name="ClIncBank">
                <label>Процент удержания</label><input type="text" name="ClIncDeduct">
                <label>Доход после удержания</label><input type="text" name="ClIncSumReal">                                
                <label>Комментарий</label><input type="text"name="ClIncComment">
                <button type="submit" class="f-bu f-bu-success">ДОБАВИТЬ</button>
            </form>
            </div>
        </div>
        
        <hr class="hr-block">
        <div class="g-row">         
            <h4>ИМУЩЕСТВО</h4>  
            <?php
            foreach($ClPropertyList as $Property){
                echo("<input type='hidden' name='controller' value='ATClientAnketaCtrl'>");
                echo("<label>Вид</label>");
                echo("<input type='text' name='ClPropType' value='{$Property->CLPROPTYPE}'>");
                echo("<label>Владелец</label>");
                echo("<input type='text' name='ClPropOwner' value='{$Property->CLPROPOWNER}'>");
                echo("<label>Описание</label>");
                echo("<input type='text' name='ClPropDesc' value='{$Property->CLPROPDESC}'>");
                echo("<label>Стоимость</label>");
                echo("<input type='text' name='ClPropCost' value='{$Property->CLPROPCOST}'>");
                echo("<label>Дата приобретения</label>");
                echo("<input type='date' name='ClPropComment' value='{$Property->CLPROPCOMMENT}'><br>");
                echo("<hr class='hr-tab'>");
            }
            ?>
            
            <div class="g-row">         
            <h4>добавить имущество</h4>  
            <form method="GET">
                <input type="hidden" name="controller" value="ATClientAnketaCtrl">
                <input type="hidden" name="action" value="AddProperty">
                <input type="hidden" name="ClCode" value="<?php echo($Client->CLCODE);?>">
                <label>тип</label>
                <select name="ClPropType" value="">
                    <option value=""></option>
                    <option value="автомобиль">зарплата</option>
                    <option value="недвижимость">совместительство</option>
                    <option value="земельный участок">пенсия</option>
                    <option value="ценные бумаги">пособие</option>
                    <option value="депозит в банке">аренда</option>
                    <option value="иное имущество">аренда</option>
                </select>
                <label>Владелец</label><select name="ClPropOwner" value="">
                    <option value=""></option>
                    <option value="клиент">клиент</option>
                    <option value="супруг">супруг</option>
                </select>
                <label>Описание</label><input type="text" name="ClPropDesc"><br>
                <label>Стоимость</label><input type="text" name="ClPropCost">
                <label>Дата приобретения</label><input type="date" name="ClPropDate">                                             
                <label>Комментарий</label><input type="text"name="ClPropComment">
                <button type="submit" class="f-bu f-bu-success">ДОБАВИТЬ</button>
            </form>
            </div>
        </div>
        <hr class="hr-block">
        <div class="g-row">         
            <h4>СДЕЛКИ С ИМУЩЕСТВОМ</h4>  
            <?php
            foreach($ClDealsList as $Deal){
                echo("<input type='hidden' name='controller' value='ATClientAnketaCtrl'>");
                echo("<label>Вид сделки</label>");
                echo("<input type='text' name='ClDlType' value='{$Deal->CLDLTYPE}'>");
                echo("<label>Объект</label>");
                echo("<input type='text' name='ClDlObj' value='{$Deal->CLDLOBJ}'>");
                echo("<label>Стоимость</label>");
                echo("<input type='text' name='ClDlSum' value='{$Deal->CLDLSUM}'>");
                echo("<label>Дата</label>");
                echo("<input type='date' name='ClDlDate' value='{$Deal->CLDLDATE}'>");
                echo("<label>Комментарий</label>");
                echo("<input type='text' name='ClDlComment' value='{$Deal->CLDLCOMMENT}'><br>");
                echo("<hr class='hr-tab'>");
            }
            ?>
            
            <div class="g-row">     
            <h4>добавить сделку</h4>  
            <form method="GET">
                <input type="hidden" name="controller" value="ATClientAnketaCtrl">
                <input type="hidden" name="action" value="AddDeal">
                <input type="hidden" name="ClCode" value="<?php echo($Client->CLCODE);?>">
                <label>Вид сделки</label>
                <select name="ClDlType" value="">
                    <option value=""></option>
                    <option value="покупка">покупка</option>
                    <option value="продажа">продажа</option>
                </select>
                <label>Объект</label><input type="text" name="ClDlObj">                
                <label>Стоимость</label><input type="text" name="ClDlSum">
                <label>Дата</label><input type="date" name="ClDlDate">                                             
                <label>Комментарий</label><input type="text" name="ClDlComment">
                <button type="submit" class="f-bu f-bu-success">ДОБАВИТЬ</button>
            </form>
            </div>
        </div>
        <hr class="hr-block">
        <div class="g-row">         
            <h4>СЧЕТА В БАНКАХ</h4>
            <?php
            foreach($ClBankAccsList as $BankAcc){
                echo("<input type='hidden' name='controller' value='ATClientAnketaCtrl'>");
                echo("<label>Банк</label>");
                echo("<input type='text' name='ClBnName' value='{$BankAcc->CLBNNAME}'>");
                echo("<label>Комментарий</label>");
                echo("<input type='text' name='ClBnComment' value='{$BankAcc->CLBNCOMMENT}'>");
                echo("<label>Сумма</label>");
                echo("<input type='text' name='ClBnSum' value='{$BankAcc->CLBNSUM}'><br>");
                echo("<label>Номер счёта</label>");
                echo("<input type='text' name='ClBnAcc' value='{$BankAcc->CLBNACC}'>");
                echo("<label>Дата открытия</label>");
                echo("<input type='date' name='ClBnOpenDat' value='{$BankAcc->CLBNOPENDAT}'>");
                echo("<label>Дата закрытия</label>");
                echo("<input type='date' name='ClBnCloseDat' value='{$BankAcc->CLBNCLOSEDAT}'><br>");
                echo("<hr class='hr-tab'>");
            }
            ?>
            
            <div class="g-row">     
            <h4>добавить счёт в банке</h4>  
            <form method="GET">
                <input type="hidden" name="controller" value="ATClientAnketaCtrl">
                <input type="hidden" name="action" value="AddBankAcc">
                <input type="hidden" name="ClCode" value="<?php echo($Client->CLCODE);?>">
                <label>Банк</label><input type="text" name="ClBnName">                
                <label>Комментарий</label><input type="text" name="ClBnComment">                
                <label>Сумма</label><input type="text" name="ClBnSum">
                <label>Номер счёта</label><input type="text" name="ClBnAcc">
                <label>Дата открытия</label><input type="date" name="ClBnOpenDat">                                             
                <label>Дата закрытия</label><input type="date" name="ClBnCloseDat">
                <button type="submit" class="f-bu f-bu-success">ДОБАВИТЬ</button>
            </form>
            </div>            
        </div>
        <hr class="hr-block">
        
    </div>
</body>
</html>

