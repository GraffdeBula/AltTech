

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>СПРАВОЧНИК СОТРУДНИКОВ</title>
    </head>
    <body>
        <p>
            <a href="index_admin.php?controller=AdminMainController"><button class="btn btn-outline-secondary">На главную</button></a>
            Сотрудники компании
        </p>          
        <form method='get'>
            <div>
                <input type='hidden' name='controller' value='ATDRCtrl'>
                <input type='hidden' name='action' value='EmpAdd'>
                <label for='in1'>ФИО сотрудника</label><input type='text' id='in1' name='EmpName' value='' autocomplete="off">
               
                <label for='in2'>Филиал</label>
                <select id='in2' name='EmpBranch'>
                    <option value=''></option>
                <?php
                    foreach($BrList as $key=>$Branch){
                    echo("<option value='{$Branch->BRNAME}'>{$Branch->BRNAME}</option>");
                    }
                ?>
                </select>    
                <button class="btn btn-success">ДОБАВИТЬ</button>
            </div>               
        </form>
        <form method='get'>
            <div>
                <input type='hidden' name='controller' value='ATDRCtrl'>
                <input type='hidden' name='action' value='EmpSearch'>
                <label for='in3'>Филиал</label>
                <select id='in3' name='EmpBranch'>
                    <option value=''></option>
                <?php
                    foreach($BrList as $key=>$Branch){
                    echo("<option value='{$Branch->BRNAME}'>{$Branch->BRNAME}</option>");
                    }
                ?>
                </select>  
                <label for='in4'>Роль</label>
                <select id='in4' name='EmpRole'>
                    <option value=''></option>
                    <option value='front'>менеджер</option>
                    <option value='jurist'>юрист</option>
                    <option value='director'>руководитель филиала</option>
                    <option value='top'>сотрудник ГО</option>
                </select>  
                <button class='btn btn-success'>ПОИСК</button>
            </div>
        </form>
        <div>
            <table class='table table-hover'>
                <thead>
                    <tr>
                        <th scope="col">Код</th>
                        <th scope="col">ФИО</th>
                        <th scope="col">Филиал</th>
                        <th scope="col">Удаление</th>
                        <th scope="col">Открыть карточку</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach($EmpList as $Emp){
                        echo("<tr class='table-secondary'>");
                        echo("<td width=50px>{$Emp->ID}</td>");
                        echo("<td width=300px>{$Emp->EMNAME}</td>");
                        echo("<td width=200px>{$Emp->EMBRANCH}</td>");
                        echo("<td width=200px>"
                            ."<form method='get'>"
                            ."<input name='EmpID' type='hidden' value='{$Emp->ID}'>"
                            ."<input name='controller' type='hidden' value='ATDRCtrl'>"
                            ."<input name='action' type='hidden' value='EmpDel'>"
                            ."<button class='btn btn-danger'>УДАЛИТЬ</button>"
                            ."</form></td>");
                        echo("<td>"
                            ."<form method='get'>"
                            ."<input name='EmpID' type='hidden' value='{$Emp->ID}'>"
                            ."<input name='controller' type='hidden' value='ATEmpCtrl'>"
                            ."<input name='action' type='hidden' value='Index'>"
                            ."<button class='btn btn-info'>ОТКРЫТЬ</button>"
                            ."</form></td>");    
                        echo("</tr>");
                    }
                ?>
                </tbody>    
            </table>
        </div>
            
    </body>
</html>
