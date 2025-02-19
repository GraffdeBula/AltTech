<!DOCTYPE html>
<html>
    <head>
                    
    </head>
    <body>
        <h3 class='h3_my'>
            СПРАВОЧНИК ФИЛИАЛОВ
        </h3>                      

        <a href="index_admin.php?controller=MenuCtrl"><button class="btn btn-primary">НАЗАД</button></a><br>
        <div class='g-row reg_ins'>
                <div class='g-5'>
                    <p>ДОБАВИТЬ ФИЛИАЛ</p>
                    <form method='get'>
                        <input type="hidden" name='controller' value='ATDRCtrl'>
                        <input type="hidden" name='action' value='BranchAdd'>
                        <input type='text' name='BRNAME' value=''>
                        <button type='submit' class='btn btn-success'>ДОБАВИТЬ</button>
                    </form>
                </div>                                
            </div>
            <div class='g-row reg_list'>
                <div class='g-5'>
                    <table>
                        <caption>ФИЛИАЛЫ</caption>
                    <tr>
                        <th>Код</th>
                        <th>Значение</th>
                    </tr>
                        <?php
                            foreach($BrList as $Branch){
                            echo("<tr>");
                            echo("<td width=50px>{$Branch->ID}</td>");
                            echo("<td width=500px>{$Branch->BRNAME}</td>");
                            echo("<td>"
                                ."<form method='get'>"
                                ."<input name='BranchID' type='hidden' value='{$Branch->ID}'>"
                                ."<input name='controller' type='hidden' value='BranchDrCtrl'>"
                                ."<input name='action' type='hidden' value='BranchDel'>"
                                ."<button class='btn btn-danger'>УДАЛИТЬ</button>"
                                ."</form></td>");
                            echo("<td>"
                            ."<form method='get'>"
                            ."<input name='BranchID' type='hidden' value='{$Branch->ID}'>"
                            ."<input name='controller' type='hidden' value='BranchDrCtrl'>"
                            ."<input name='action' type='hidden' value='Index'>"
                            ."<button class='btn btn-info'>ОТКРЫТЬ</button>"
                            ."</form></td>");    
                        echo("</tr>");
                            echo("</tr>");
                        }
                        ?>
                    </table>
                </div>                                
            </div>
                                                       
    </body>
</html>
