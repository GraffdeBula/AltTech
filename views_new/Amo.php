<?php
/*
 * для работы с сущностями АМОЦРМ
 *  */

?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <h1>AMO 111</h1>
    <div class='row'>
        <div class='col-5'>
            <form method='get'>
                <?php
                    (new MyForm('AmoCtrl','GetLeadList',0,0))->AddForm2();
                ?>
            <input type="date" name="datef">
            <input type="date" name="datel">
            <button class='btn btn-primary btn-sm' id='BtnGetList'>Получить список лидов</button><br>

            </form>    
            <a target="_blank" href='downloads/Leads.xlsx'><button class='btn btn-success btn-sm'>Загрузить список лидов</button></a><br>
            <form>
                <?php
                    (new MyForm('AmoCtrl','GetLead',0,0))->AddForm2();
                ?>
                <input type="text" name="leadid">    
                <button class='btn btn-success btn-sm'>Получить лид</button><br>
            </form>

            <form>
                <?php
                    (new MyForm('AmoCtrl','GetCustomFields',0,0))->AddForm2();
                ?>
                <input type="text" name="leadid">    
                <button class='btn btn-success btn-sm'>Получить custom fields лида</button><br>
            </form>

            <form>
                <?php
                    (new MyForm('AmoCtrl','GetTags',0,0))->AddForm2();
                ?>
                <input type="text" name="leadid">    
                <button class='btn btn-success btn-sm'>Получить тэги лида</button><br>
            </form>

            <form>
                <?php
                    (new MyForm('AmoCtrl','GetContact',0,0))->AddForm2();
                ?>
                <input type="text" name="contactid">    
                <button class='btn btn-info btn-sm'>Получить контакт</button><br>
            </form>

            <form>
                <?php
                    (new MyForm('AmoCtrl','GetPipelineList',0,0))->AddForm2();
                ?>
                <input type="text" name="contactid">    
                <button class='btn btn-warning btn-sm'>Получить список воронок</button><br>
            </form>

            <form>
                <?php
                    (new MyForm('AmoCtrl','GetUser',0,0))->AddForm2();
                ?>
                <input type="text" name="userid">    
                <button class='btn btn-success btn-sm'>Получить список пользователей</button><br>
            </form>
        </div>   
        <div class='col-4'>
            <h3>Тестирование</h3>
            <form>
                <?php
                    (new MyForm('AmoTestCtrl','TestRefCont',0,0))->AddForm2();
                ?>
                <lable>Контакт</lable><input type="text" name="ContName"><br>    
                <lable>Телефон</lable><input type="text" name="ContPhone"><br>    
                <lable>Имя сделки</lable><input type="text" name="LeadName"><br>    
                <button class='btn btn-info btn-sm'>Создать рекомендацию</button><br>
            </form>
            
        </div>
    </div>
    
    <?php
        foreach($AmoResult as $key=>$value){
            echo($key." :: ");
            var_dump($value);        
            echo("<br>");
        }
    ?>
</body>   
<script>
    var BtnGetList==document.getElementById('BtnGetList');
    BtnGetList.addEventListener('click',function(){
        event.preventDefault();
        var req1= new XMLHttpRequest();
            req1.open('GET','index_admin.php?controller=AmoCtrl&action=GetLeadList',true);
            req1.send();
    });
</script>
</html>
