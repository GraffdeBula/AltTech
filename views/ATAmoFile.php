<?php
/*
 * досье клиента
 *  */
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <div class="g">      
        <div class="g-row">
            <div class='g-12'>
                <h3>
                    <p>АЛЬТ-ТЕХ</p>
                </h3>   
            </div>
        </div>
        <div class="g-row">
            <div class='g-12'>
                <h3>
                    <p>РАБОТА с АМО</p>
                </h3>   
            </div>
        </div>
        <div class="f-row">
            <form method='post'>
                <input type="hidden" name='controller' value='ATAmoFileCtrl'>
                <input type="hidden" name='action' value='GetLead'>
                <label>AMO Lead ID</label><input type='text' name='AmoLeadID' value=''>
                <button type='submit' class='f-bu f-bu-warnning'>ПОЛУЧИТЬ ЛИД</button>
            </form>
        </div>
        
        <div class="f-row">
            <form method='post'>
                <input type="hidden" name='controller' value='ATAmoFileCtrl'>
                <input type="hidden" name='action' value='GetLeadList'>
                <label>AMO Lead List</label><input type='text' name='AmoLeadList' value=''>
                <button type='submit' class='f-bu f-bu-warnning'>ПОЛУЧИТЬ список лидов</button>
            </form>
        </div>
        
        <div class="f-row">
            <form method='post'>
                <input type="hidden" name='controller' value='ATAmoFileCtrl'>
                <input type="hidden" name='action' value='GetContact'>
                <label>AMO Contact ID</label><input type='text' name='AmoContactID' value=''>
                <button type='submit' class='f-bu f-bu-warnning'>ПОЛУЧИТЬ КОНТАКТ</button>
            </form>
        </div>
        
        <div class="f-row">
            <form method='post'>
                <input type="hidden" name='controller' value='ATAmoFileCtrl'>
                <input type="hidden" name='action' value='GetContactList'>
                <label>AMO Contact List</label><input type='text' name='AmoContactList' value=''>
                <button type='submit' class='f-bu f-bu-warnning'>ПОЛУЧИТЬ список контактов</button>
            </form>
        </div>
        <h4>Работа со статусами</h4>
        <div class="f-row">
            <form method='post'>
                <input type="hidden" name='controller' value='ATAmoFileCtrl'>
                <input type="hidden" name='action' value='GetPipelineList'>                
                <button type='submit' class='f-bu f-bu-warnning'>ПОЛУЧИТЬ список воронок</button>
            </form>
        </div>        
        <div class="f-row">
            <form method='post'>
                <input type="hidden" name='controller' value='ATAmoFileCtrl'>
                <input type="hidden" name='action' value='GetStatusList'>
                <label>AMO Pipeline</label><input type='text' name='AmoPipelineId' value=''>
                <button type='submit' class='f-bu f-bu-warnning'>ПОЛУЧИТЬ список статусов</button>
            </form>
        </div>        
        <div class="f-row">
            <form method='get' autocomplete="off">
                <input type="hidden" name='controller' value='ATAmoFileCtrl'>
                <input type="hidden" name='action' value='CountLeads'>
                <label>Count Leads in pipeline</label><input type='text' name='AmoPipeLineId' value=''><label> in status </label><input type='text' name='AmoStatusId' value=''>
                <button type='submit' class='f-bu f-bu-warnning'>Сосчитать Лиды</button>
            </form>
        </div>
        
        <h4>Работа с тэгами</h4>
        <div class="f-row">
            <form method='get' autocomplete="off">
                <input type="hidden" name='controller' value='ATAmoFileCtrl'>
                <input type="hidden" name='action' value='AddTag'>
                <label>Lead Id</label><input type='text' name='LeadId' value=''><label> тэг </label><input type='text' name='TagName' value=''>
                <button type='submit' class='f-bu f-bu-warnning'>Добавить тэг</button>
            </form>
        </div>
        
        <div class="f-row">
            <form method='get' autocomplete="off">
                <input type="hidden" name='controller' value='ATAmoFileCtrl'>
                <input type="hidden" name='action' value='DelTag'>
                <label>Lead Id</label><input type='text' name='LeadId' value=''>
                <button type='submit' class='f-bu f-bu-warnning'>Удалить тэги</button>
            </form>
        </div>
        
        <div class="f-row">
            <form method='post'>
                <input type="hidden" name='controller' value='ATAmoFileCtrl'>
                <input type="hidden" name='action' value='DelCustomField'>
                <label>Custom field ID</label><input type='text' name='AmoCFId' value=''>
                <button type='submit' class='f-bu f-bu-warnning'>УДАЛИТЬ CustomField</button>
            </form>
        </div>
                      
        <div class="f-row">
            <form method='get' autocomplete="off">
                <input type="hidden" name='controller' value='ATAmoFileCtrl'>
                <input type="hidden" name='action' value='ChangeStatus'>
                <label>Change Lead Status</label><input type='text' name='LeadId' value=''>
                <label> pipeline </label><input type='text' name='PipelineId' value=''>
                <label> to status </label><input type='text' name='StatusId' value=''>
                <button type='submit' class='f-bu f-bu-warnning'>Сменить</button>
            </form>
        </div>
        
        <?php
            if (isset($Lead)){
                foreach($Lead['_embedded']['items'][0] as $key=>$Atr){
                    echo($key." ::: ");
                    if ($key=='custom_fields'){
                        foreach($Atr as $key=>$field){
                            var_dump($field);
                            echo("<br>.....................................<br>");
                        }
                    }
                    else{
                        var_dump($Atr);
                    }
                    echo("<br>=====================================<br>");
                }
            }
            if (isset($LeadList)){
//                foreach($LeadList['_embedded']['leads'] as $key => $Element){
//                    echo($key." ::: ");
//                    var_dump($Element);
//                    echo("<br>");
//                }
                echo("В Статусе ".count($LeadList['_embedded']['leads'])." сделок");
            }
            if (isset($Contact)){
                var_dump("запрос контакта");
            }
            if (isset($ContactList)){
                var_dump("запрос списка контактов");
            }
            if (isset($PipelineList)){
                foreach($PipelineList['_embedded']['pipelines'] as $key=>$Atr){
                    echo($key." ::: ");
                    echo("{$Atr['id']} == {$Atr['name']}");
                    echo("<br>=====================================<br>");
                }
            }
            if (isset($StatusList)){
//                var_dump($StatusList);
                foreach($StatusList['_embedded']['statuses'] as $key=>$Atr){
                    echo($key." ::: ");
                    echo("{$Atr['id']} == {$Atr['name']}");
                    echo("<br>=====================================<br>");
                }
            }
        ?>
        
        
                                                                         
    </div>
</body>
</html>
