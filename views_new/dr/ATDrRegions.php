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
                    <a href="index_admin.php?controller=MenuCtrl"><button class="f-bu f-bu-default">НАЗАД</button></a><br>
                </div>
            </div>
            <div class='g-row reg_list'>
                <div class='g-5'>
                    <table>
                        <caption>РЕГИОНЫ</caption>
                    <tr>
                        <th>Код</th>
                        <th>Значение</th>
                    </tr>
                        <?php
                            foreach($RegList as $Reg){
                            echo("<tr>");
                            echo("<td width=50px>{$Reg->ID}</td>");
                            echo("<td width=500px>{$Reg->REGNAME}</td>");
                            echo("<td>"
                                ."<form method='get'>"
                                ."<input name='RegID' type='hidden' value='{$Reg->ID}'>"
                                ."<input name='controller' type='hidden' value='ATDRCtrl'>"
                                ."<input name='action' type='hidden' value='RegionDel'>"
                                ."<button class='f-bu f-bu-warning'>УДАЛИТЬ</button></td>"
                                ."</form>");

                            echo("</tr>");
                        }
                        ?>
                    </table>
                </div>                                
            </div>
            <div class='g-row reg_ins'>
                <div class='g-5'>
                    <p>ДОБАВИТЬ РЕГИОН</p>
                    <form method='get'>
                        <input type="hidden" name='controller' value='ATDRCtrl'>
                        <input type="hidden" name='action' value='RegionAdd'>
                        <input type='text' name='REGNAME' value=''>
                        <button type='submit' class='f-bu f-bu-warning'>ДОБАВИТЬ</button>
                    </form>
                </div>                                
            </div>
                                    
        </div>
    </body>
</html>
