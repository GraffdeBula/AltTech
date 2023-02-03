<!DOCTYPE html>
<html>
    <head>
                    
    </head>
    <body>
        <h3>СПРАВОЧНИК ОРГАНИЗАЦИЙ</h3>
        <a href="index_admin.php?controller=MenuCtrl"><button class="btn btn-priary">НАЗАД</button></a><br>
        

        <p>ДОБАВИТЬ ФИЛИАЛ</p>
        <form method='get'>
            <input type="hidden" name='controller' value='ATDRCtrl'>
            <input type="hidden" name='action' value='BranchAdd'>
            <input type='text' name='BRNAME' value=''>
            <button type='submit' class='btn btn-ыгссуыы'>ДОБАВИТЬ</button>
        </form>

        <table class="table table-hover">
            <caption>ФИЛИАЛЫ</caption>
            <thead>
                <th scope="col">Код</th>
                <th scope="col">Значение</th>
                <th scope="col">Префикс</th>
                <th scope="col">Открыть</th>
                <th scope="col">Удалить</th>
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
