<!DOCTYPE html>
<html>
    <head>
                    
    </head>
    <body>
        <div class="g my_form">      
            <div class="g-row">
                <div class='g-4'>
                    <h3 class='h3_my'>
                        СПРАВОЧНИК РЕГИОНОВ
                    </h3>                      
                </div>
                <div class='g-3'>
                    <a href="index_admin.php?&view=Menu/AdminMenu"><button class="f-bu f-bu-default">НАЗАД</button></a><br>
                </div>
            </div>
            <div class='g-row reg_list'>
                <div class='g-5'>
                    <p>ЗДЕСЬ СПИСОК РЕГИОНОВ</p>
                    <?php
                        var_dump($RegList);
                    ?>
                </div>                                
            </div>
            <div class='g-row reg_ins'>
                <div class='g-5'>
                    <p>ДОБАВИТЬ РЕГИОН</p>
                    <form method='POST'>
                        <input type="hidden" name='controller' value='RegListCtrl'>
                        <input type="hidden" name='action' value='RegIns'>
                        <input type='test' name='REGNAME' value=''>
                        <button type='submit' class='f-bu f-bu-warning'>ДОБАВИТЬ</button>
                    </form>
                </div>                                
            </div>
                                    
        </div>
    </body>
</html>
