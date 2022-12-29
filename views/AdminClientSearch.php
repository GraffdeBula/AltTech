<!DOCTYPE html>
<html>
    <head>
                    
    </head>
    <body>
        <div class="g">      
            <div class="g-row">
                <div class='g-12'>
                    <h3>
                        <p>ДЛЯ ПЕЧАТИ ДОКЗИЛЛЫ</p>
                    </h3>   
                   
                </div>
            </div>
            <div class="g-row">
                <div class='g-3'>
                    <a href="index_admin.php?&view=Menu/AdminMenu"><button class="f-bu f-bu-default">НАЗАД</button></a><br>
                </div>                
            </div>
            <div class='f-row'>            
                <form method='POST'>                    
                    <input type='hidden' name='controller' value='ClInfoCtrl'>
                    <input type='hidden' name='action' value='SearchData'>
                    <div class='f-input'>
                        <label for='clCode'>Код клиента</label>
                        <input type='text' name='clCode' value='' id='clCode' autocomplete="off">
                    </div>
                    <div class='f-input'>
                        <label for='contCode'>Код (ID) договора</label>
                        <input type='text' name='contCode' value='' id='contCode' autocomplete="off">
                    </div>                    
                    <div class='f-input'>
                        <label for='clFName'>Фамилия</label>
                        <input type='text' name='clFName' value='' id='clFName' autocomplete="off">
                    </div>                    
                    <div class='f-input'>
                        <label for='cl1Name'>Имя</label>
                        <input type='text' name='cl1Name' value='' id='cl1Name' autocomplete="off">
                    </div>
                    <div class='f-input'>
                        <label for='cl2Name'>Отчество</label>
                        <input type='text' name='cl2Name' value='' id='cl2Name' autocomplete="off">
                    </div>
                    
                    <div class='f-actions'>
                        <button type='submit' class='f-bu f-bu-warning'>НАЙТИ</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
