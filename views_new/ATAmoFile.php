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
    <h3>
        <p>РАБОТА с АМО</p>
    </h3>   
           
    <form method='get' autocomplete='off'>
        <input type="hidden" name='controller' value='ATAmoFileCtrl'>
        <input type="hidden" name='action' value='GetLead'>
        <label>AMO Lead ID</label><input type='text' name='AmoLeadID' value=''>
        <button type='submit' class='btn btn-primary'>ПОЛУЧИТЬ ЛИД</button>
    </form>
    
    <form method='get' autocomplete='off'>
        <input type="hidden" name='controller' value='ATAmoFileCtrl'>
        <input type="hidden" name='action' value='GetLeadTags'>
        <label>AMO Lead ID</label><input type='text' name='AmoLeadID' value=''>
        <button type='submit' class='btn btn-primary'>ПОЛУЧИТЬ ТЭГИ</button>
    </form>

    <form method='get' autocomplete='off'>
        <input type="hidden" name='controller' value='ATAmoFileCtrl'>
        <input type="hidden" name='action' value='GetContact'>
        <label>AMO Contact ID</label><input type='text' name='AmoContactID' value=''>
        <button type='submit' class='btn btn-primary'>ВЗЯТЬ КОНТАКТ</button>
    </form>
    
    <form method='get' autocomplete='off'>
        <input type="hidden" name='controller' value='ATAmoFileCtrl'>
        <input type="hidden" name='action' value='AddTag'>
        <label>AMO Lead ID</label><input type='text' name='LeadId' value=''>
        <label>Тэг</label><input type='text' name='TagName' value=''>
        <button type='submit' class='btn btn-primary'>Добавить тэг</button>
    </form>
    
                
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
            
            if (isset($Tags)){
                var_dump($Tags);
                /*
                foreach($Tags as $key=>$Atr){
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
                }*/
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
                foreach($Contact['_embedded']['items'][0] as $key=>$Atr){
                    echo($key." ::: ");
                    if ($key=='custom_fields'){
                        foreach($Atr as $key=>$field){
                            var_dump($field);
                            if ($field['id']==1730662){
                                echo("<br>...источник...<br>");
                            }
                            echo("<br>.....................................<br>");
                        }
                    }
                    else{
                        var_dump($Atr);
                    }
                    echo("<br>=====================================<br>");
                }
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
        
        
                                                                         
    
</body>
</html>
