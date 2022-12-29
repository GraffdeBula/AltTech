<!DOCTYPE html>
<html>
    <head>
                    
    </head>
    <body>
        <div class="g my_form">      
            <div class="g-row">
                <div class='g-4'>
                    <h3 class='h3_my'>
                        РЕЕСТР ПЛАТЕЖЕЙ
                    </h3>                      
                </div>
                <div class='g-3'>
                    <a href="index_admin.php?&view=AdminMenu"><button class="f-bu f-bu-default">НАЗАД</button></a><br>
                </div>
            </div>            
            <div class="f-row">
                <form method='post'>
                <label>ДАТА</label><input type='date' name='mydate'><button type='submit' class='f-bu f-bu-default'>ВЫБРАТЬ ДАТУ</button>
                <input type='hidden' name='controller' value='PkoCtrl'>
                <input type='hidden' name='action' value='DateForm'>
                </form>
            </div>
            <div class='g-row reg_list'>
                <div class='g-10'>
                    <p>ЗДЕСЬ РЕЕСТР ПЛАТЕЖЕЙ</p>
                    <?php
                        foreach($PkoList as $Pko){
                            echo("<form method='post'>");
                            echo("<div class='f-row'>");
                            foreach($Pko as $PkoAtrName => $PkoAtr){                                                                
                                echo("<label for='{$PkoAtrName}'>{$PkoAtrName}</label>");
                                echo("<input type='text' id='{$PkoAtrName}' value='{$PkoAtr}'>");                                
                            }
                            echo("<button type='submit' class='f-bu f-bu-success'>ИЗМЕНИТЬ</button>");
                            echo("<button type='submit' class='f-bu f-bu-warning'>УДАЛИТЬ</button>");
                            echo("</div>");
                            echo("</form>");
                            echo("--------------------------<br>");
                        }
                    ?>
                </div>                                
            </div>
                                                
        </div>
    </body>
</html>
