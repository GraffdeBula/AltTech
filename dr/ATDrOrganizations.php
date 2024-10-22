<!DOCTYPE html>
<html>
    <head>
                    
    </head>
    <body>
        <h3>СПРАВОЧНИК ПРОЧИХ ОРГАНИЗАЦИЙ</h3>
        <a href="index_admin.php?controller=MenuCtrl"><button class="btn btn-primary">НАЗАД</button></a><br>
        

        <p>ДОБАВИТЬ ОРГАНИЗАЦИЮ</p>
        <form method='get' autocomplete="off">
            <?php
                (new MyForm('ATDRCtrl','OrganizationAdd'))->AddForm2();
            ?>
            <label>Вид</label><input type='text' name='ORGTYPE' value=''>
            <label>Название</label><input type='text' name='ORGNAME' value=''>
            <label>Регион</label><select type='text' name='ORGREGION' value=''>
                <option></option>
                <?php
                    foreach($RegList as $Reg){
                        echo("<option value='{$Reg->REGNAME}'>{$Reg->REGNAME}</option>");
                    }
                ?>
            </select>        
            <label>Адрес</label><input type='text' name='ORGADDRESS' value=''>
            <label>Название в адресе</label><input type='text' name='ORGADRNAME' value=''>
            <label>Телефон</label><input type='text' name='ORGPHONE' value='' autocomplete="off">
            <button type='submit' class='btn btn-success'>ДОБАВИТЬ</button>
        </form>

        <table class="table table-hover">
            <caption>ОРГАНИЗАЦИИ</caption>
            <thead>
                <th scope="col">Код</th>
                <th scope="col">Вид</th>
                <th scope="col">Название</th>
                <th scope="col">Регион</th>
                <th scope="col">Адрес</th>
                <th scope="col">Название в адресе</th>
                <th scope="col">Телефон</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </thead>
            <tbody>
                <?php                    
                    foreach($OrgList as $Org){
                        echo("<tr class='table-light'>");
                        echo("<form method='get' autocomplete='off'>");
                        (new MyForm('ATDRCtrl','OrganizationUpd'))->AddForm2();
                        echo("<td width=100px ><input name='ID' value='{$Org->ID}'></td>");
                        echo("<td width=100px><input name='ORGTYPE' value='{$Org->ORGTYPE}'></td>");
                        echo("<td width=100px><input name='ORGNAME' value='{$Org->ORGNAME}'></td>");
                        echo("<td width=100px><input name='ORGREGION' value='{$Org->ORGREGION}'></td>");
                        echo("<td width=100px><input name='ORGADDRESS' value='{$Org->ORGADDRESS}'></td>");
                        echo("<td width=100px><input name='ORGADRNAME' value='{$Org->ORGADRNAME}'></td>");
                        echo("<td width=100px><input name='ORGPHONE' value='{$Org->ORGPHONE}'></td>");                                            
                        echo("<td><button class='btn btn-info'>ИЗМЕНИТЬ</button></td>");
                        echo("</form>");
                        echo("<td>"
                            ."<form method='get'>"
                            ."<input name='ID' type='hidden' value='{$Org->ID}'>"
                            ."<input name='controller' type='hidden' value='ATDRCtrl'>"
                            ."<input name='action' type='hidden' value='OrganizationDel'>"
                            ."<button class='btn btn-danger'>УДАЛИТЬ</button>"
                            ."</form></td>");                    
                        echo("</tr>");
                    }
                ?>
            </tbody>
        </table>

    </body>
</html>
