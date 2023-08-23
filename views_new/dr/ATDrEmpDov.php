<!DOCTYPE html>
<html>
    <head>
                    
    </head>
    <body>
        <h3 class='h3_my'>
            СПРАВОЧНИК ДОВЕРЕННОСТЕЙ
        </h3>                      

        <a href="index_admin.php?controller=MenuCtrl"><button class="btn btn-primary">НАЗАД</button></a><br>
        <div class='g-row reg_ins'>
                <div class='g-5'>
                    <p>ДОБАВИТЬ ДОВЕРЕННОСТЬ</p>
                    <form method='get'>
                        <input type="hidden" name='controller' value='ATDRCtrl'>
                        <input type="hidden" name='action' value='EmpDovAdd'>
                        <label>Сотрудник</label><input type='text' name='EmName' value=''>
                        <label>Номер доверенности</label><input type='text' name='EmDov' value=''>
                        <button type='submit' class='btn btn-success'>ДОБАВИТЬ</button>
                    </form>
                </div>                                
            </div>
            <div class='g-row reg_list'>
                <div class='g-5'>
                    <table>
                        <caption>Доверенности</caption>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Номер</th>
                            <th>Дата</th>
                            <th>Окончание</th>
                            <th>Комментарий</th>                            
                        </tr>
                        <?php
                            foreach($DovList As $EmpDov){
                                echo("<form>");
                                (new MyForm('ATDRCtrl', 'EmpDovUpd',0,0))->AddForm2();
                                echo("<tr>");
                                echo("<td><input name='Id' value='{$EmpDov->ID}'></td>");
                                echo("<td><input name='EmName' value='{$EmpDov->EMNAME}'></td>");
                                echo("<td><input name='EmDov' value='{$EmpDov->EMDOV}'></td>");
                                echo("<td><input type=date name='EmDovDate' value='{$EmpDov->EMDOVDATE}'></td>");
                                echo("<td><input type=date name='EmDovEndDate' value='{$EmpDov->EMDOVENDDATE}'></td>");
                                echo("<td><input name='EmDovComment' value='{$EmpDov->EMDOVCOMMENT}'></td>");
                                echo("<td><button class='btn btn-success'>ИЗМЕНИТЬ</button></td>");
                                echo("</tr>");
                                echo("</form>");
                            }
                        ?>
                    </table>
                </div>                                
            </div>
                                                       
    </body>
</html>
