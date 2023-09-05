<!DOCTYPE html>
<html>
    <head>
                    
    </head>
    <body>
        <h3>СПРАВОЧНИК ЮРЛИЦ</h3>
        <a href="index_admin.php?controller=MenuCtrl"><button class="btn btn-primary">НАЗАД</button></a><br>
        

        <p>ДОБАВИТЬ ЮРИДИЧЕСКОЕ ЛИЦО</p>
        <form method='get' autocomplete="off">
            <input type="hidden" name='controller' value='ATDRCtrl'>
            <input type="hidden" name='action' value='OrgAdd'>
            <label>Название</label><input type='text' name='ORGNAME' value=''>
            <label>Префикс</label><input type='text' name='ORGPREF' value=''>
            <button type='submit' class='btn btn-success'>ДОБАВИТЬ</button>
        </form>

        <table class="table table-hover">
            <caption>ФИЛИАЛЫ</caption>
            <thead>
                <th scope="col">Код</th>
                <th scope="col">Значение</th>
                <th scope="col">Префикс</th>
                <th scope="col">Удалить</th>
                <th scope="col">Открыть</th>
            </thead>
            <tbody>
                <?php
                    foreach($OrgList as $Org){
                    echo("<tr class='table-light'>");
                    echo("<td width=50px>{$Org->ID}</td>");
                    echo("<td width=500px>{$Org->ORGNAME}</td>");
                    echo("<td width=500px>{$Org->ORGPREF}</td>");
                    echo("<td>"
                        ."<form method='get'>"
                        ."<input name='OrgID' type='hidden' value='{$Org->ID}'>"
                        ."<input name='controller' type='hidden' value='ATDRCtrl'>"
                        ."<input name='action' type='hidden' value='OrgDel'>"
                        ."<button class='btn btn-danger'>УДАЛИТЬ</button>"
                        ."</form></td>");
                    echo("<td>"
                        ."<form method='get'>"
                        ."<input name='OrgID' type='hidden' value='{$Org->ID}'>"
                        ."<input name='controller' type='hidden' value='OrgDrCtrl'>"
                        ."<input name='action' type='hidden' value='Index'>"
                        ."<button class='btn btn-info'>ОТКРЫТЬ</button>"
                        ."</form></td>");                    
                    echo("</tr>");
                }
                ?>
            </tbody>
        </table>

    </body>
</html>
