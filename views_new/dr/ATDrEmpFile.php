<?php
/**
 * Досье сотрудника. Открывается из справочника сотрудников
 * 
 *  */
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <p>
        <a href="index_admin.php?controller=ATDRCtrl&action=ShowDREmployee"><button class="btn btn-outline-secondary">НАЗАД</button></a><br>
    </p>
    <?php
        echo("<h4>КАРТОЧКА СОТРУДНИКА: {$Employee->EMNAME}</h4>");
    ?>
    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" data-bs-toggle="tab" href="#main">Основная информация</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#pasport">Паспортные данные</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#pass">Пароль</a>
        </li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active show" id="main">
            <form method='get'>            
                
                <?php
                    (new MyForm('ATEmpCtrl','EmpUpd'))->AddForm2();
                    echo("<input type='hidden' name='EmpID' value={$Employee->ID}>");
                    echo("<p><label for='in1'>Имя</label><input id='in1' type='text' name='EMNAME' autocomplete='off' value='$Employee->EMNAME'>");
                    echo("<label for='in2'>Логин</label><input id='in2' type='text' name='EMLOGIN' autocomplete='off' value='$Employee->EMLOGIN'>");
                    echo("<label for='in3'>пол</label><input id='in3' type='text' name='EMSEX' autocomplete='off' value='$Employee->EMSEX'>");
                    echo("<label for='in7'>статус</label><select id='in7' name='EMSTATUS' value='$Employee->EMSTATUS'>"
                            . "<option value='$Employee->EMSTATUS'>$Employee->EMSTATUS</option>"
                            . "<option value='работает'>работает</option>"
                            . "<option value='в декрете'>в декрете</option>"
                            . "<option value='уволен'>уволен</option>"
                            . "</select></p>");                                        
                    echo("<p><label for='in4'>Филиал</label><input id='in4' type='text' name='EMBRANCH' autocomplete='off' value='$Employee->EMBRANCH'>");
                    echo("<label for='in5'>Должность</label><input id='in5' type='text' name='EMPOS' autocomplete='off' value='$Employee->EMPOS' size=40>");
                    echo("<label for='in6'>Роль</label><input id='in6' type='text' name='EMROLE' autocomplete='off' value='$Employee->EMROLE'></p>");
                    echo("<p><label>ФИО ИП</label><input type='text' name='EMFNAME1' autocomplete='off' value='$Employee->EMFNAME1' size=40>");
                    echo("<label>ФИО РП</label><input type='text' name='EMFNAME2' autocomplete='off' value='$Employee->EMFNAME2' size=40>");
                    echo("<label>ФИО ДП</label><input type='text' name='EMFNAME3' autocomplete='off' value='$Employee->EMFNAME3' size=40></p>");
                ?>                                
                <button class="btn btn-warning">СОХРАНИТЬ</button>            
            </form>
            
            
        </div><!-- comment -->
        <div class="tab-pane fade" id="pasport">
            <form method='get' autocomplete='off'>                                        

                <?php
                    (new MyForm('ATEmpCtrl','EmpPasportUpd'))->AddForm2();
                    echo("<input type='hidden' name='EmpID' value={$Employee->ID}>");
                    echo("<p><label>Дата рождения</label><input type='date' name='EMDATEBIRTH' value='{$Employee->EMDATEBIRTH}'>");  
                    echo("<label>Паспорт серия</label><input type='text' name='EMPASSER' value='{$Employee->EMPASSER}' size=15>");
                    echo("<label>номер</label><input type='text' name='EMPASNUM' value='{$Employee->EMPASNUM}' size=15></p>");
                    echo("<p><label>кем выдан</label><input type='text' name='EMPASORG' value='{$Employee->EMPASORG}' size=60>");  
                    echo("<label>дата выдачи</label><input type='date' name='EMPASDATE' value='{$Employee->EMPASDATE}'>");
                    echo("<label>код</label><input type='text' name='EMPASCODE' value='{$Employee->EMPASCODE}' size=15></p>");
                    echo("<p><label>Адрес регистрации</label><input type='text' name='EMADRREG' value='{$Employee->EMADRREG}' size=50></p>");
                ?>
                <button class="btn btn-warning">СОХРАНИТЬ</button>
            </form>
        </div>
        <div class="tab-pane fade" id="pass">
            <form method='get'>            
                <button class="btn btn-danger">СОХРАНИТЬ ПАРОЛЬ</button>            

                <?php
                    (new MyForm('ATEmpCtrl','EmpPassUpd'))->AddForm2();
                    echo("<input type='hidden' name='EmpID' value={$Employee->ID}>");
                    echo("<label for='in2'>Пароль</label><input id='in2' type='text' name='EMPASS' autocomplete='off' value=''>");                
                ?>                                                
            </form>
        </div>
    </div>

</body>
</html>
