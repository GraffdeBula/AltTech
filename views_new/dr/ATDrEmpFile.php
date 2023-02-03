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
          <a class="nav-link" data-bs-toggle="tab" href="#pass">Пароль</a>
        </li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active show" id="main">
            <form method='get'>            
                <button class="btn btn-warning">СОХРАНИТЬ</button>            

                <?php
                    (new MyForm('ATEmpCtrl','EmpUpd'))->AddForm2();
                    echo("<input type='hidden' name='EmpID' value={$Employee->ID}>");
                    echo("<label for='in1'>Имя</label><input id='in1' type='text' name='EMNAME' autocomplete='off' value='$Employee->EMNAME'>");
                    echo("<label for='in2'>Логин</label><input id='in2' type='text' name='EMLOGIN' autocomplete='off' value='$Employee->EMLOGIN'>");
                    echo("<label for='in3'>пол</label><input id='in3' type='text' name='EMSEX' autocomplete='off' value='$Employee->EMSEX'>");
                    echo("<label for='in4'>Филиал</label><input id='in4' type='text' name='EMBRANCH' autocomplete='off' value='$Employee->EMBRANCH'>");
                    echo("<label for='in5'>Должность</label><input id='in5' type='text' name='EMPOS' autocomplete='off' value='$Employee->EMPOS'>");
                    echo("<label for='in6'>Роль</label><input id='in6' type='text' name='EMROLE' autocomplete='off' value='$Employee->EMROLE'>");
                ?>                                

            </form>
        </div><!-- comment -->
        <div class="tab-pane fade" id="pass">
            <form method='get'>            
                <button class="btn btn-warning">СОХРАНИТЬ</button>            

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
