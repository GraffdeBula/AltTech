<?php
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>    
    <h3>АНКЕТА КЛИЕНТА</h3>   
    
    <div>
        <form>            
            <?php 
            (new MyForm('ATClientAnketaCtrl','SaveClient',$_GET['ClCode'],0))->AddForm();
            echo("<label>ФАМИЛИЯ</label><input type='text' name='CLFNAME' value='{$Client->CLFNAME}'>");
            echo("<label>ИМЯ</label><input type='text' name='CL1NAME' value='{$Client->CL1NAME}'>");
            echo("<label>ОТЧЕСТВО</label><input type='text' name='CL2NAME' value='{$Client->CL2NAME}'>");
            #echo("<br>");
            echo("<label>Дата рождения</label><input type='date' name='CLBIRTHDATE' value='{$Client->CLBIRTHDATE}'>");            
            echo("<label>Пол</label><select name='CLSEX'>"
                . "<option value={$Client->CLSEX}>{$Client->CLSEX}</option>"
                . "<option value='муж'>муж</option>"
                . "<option value='жен'>жен</option></select>");
            echo("<br>");
            echo("<label>Место рождения</label><input type='text' class='input-comment' name='CLBIRTHPLACE' value='{$Client->CLBIRTHPLACE}' size=118>");        
            echo("<br>");
            ?>
            <button class="btn btn-warning">СОХРАНИТЬ ОБЩУЮ ИНФ</button>
            <button class="btn btn-info">ПЕЧАТЬ АНКЕТЫ</button>
        </form> <!--сохранить основную информацию-->
    </div><!--основная инф о клиенте-->
    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" data-bs-toggle="tab" href="#docs">Документы</a>
        </li> 
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#adr">Адреса и контакты</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#fam">Семья</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#status">Юридический статус</a>
        </li><!-- comment -->
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#ipoteka">Ипотека</a>
        </li><!-- comment -->
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#incprop">Доходы и собственность</a>
        </li>
    </ul><!--заголовки вкладок анкеты-->
        
    <div id="myTabContent" class="tab-content"> 
        <div class="tab-pane fade" id="adr">
            <div>
                <h5>e-mail</h5>
                <form method='get' autocomplete='off'>
                    <?php
                    (new MyForm('ATClientAnketaCtrl','SaveClEmail',$_GET['ClCode'],0))->AddForm();
                    echo("<input type='text' name='CLEMAIL' value='{$Client->CLEMAIL}'>");
                    ?>
                    <button type="submit" class="btn btn-warning">Сохранить e-mail</button>
                </form>
            </div>
            <div>
                <h5>Телефоны</h5>
                <?php
                foreach($ClPhoneList as $Phone){
                    echo("<form method='get'>");
                    (new MyForm('ATClientAnketaCtrl','DelPhone',$_GET['ClCode'],0))->AddForm();
                    echo("<input type='hidden' name='ClPhID' value='{$Phone->ID}'>");
                    echo("<input type='text' name='ClPhText' value='{$Phone->CLPHTEXT}'>");
                    echo("<input type='text' name='ClPhone' value='{$Phone->CLPHONE}'>");
                    echo("<input type='text' name='ClPhComment' value='{$Phone->CLPHCOMMENT}'>");                    
                    echo("<button type='submit' class='btn btn-danger'>удалить</button></form>");
                }
                ?>
                <hr class='hr-tab'>
            </div><!--список номеров телефонов-->
            <div>
                <h5>Добавить телефон</h5>  
                <form method="GET">
                    <input type="hidden" name="controller" value="ATClientAnketaCtrl">
                    <input type="hidden" name="action" value="AddPhone">
                    <input type="hidden" name="ClCode" value="<?php echo($Client->CLCODE);?>">
                    <label>тип</label>
                    <select name="ClPhText">
                        <option value=""></option>
                        <option value="мобильный">мобильный</option>
                        <option value="домашний">домашний</option>
                        <option value="рабочий">рабочий</option>
                        <option value="другой">другой</option>
                    </select>
                    <label>Номер</label><input type="text" name="ClPhone" maxlength=11>
                    <label>Комментарий</label><input type="text"name="ClPhComment">
                    <button type="submit" class="btn btn-warning">Сохранить</button>
                </form>
            </div><!--форма ввода номера телефона-->
            <hr class='hr-tab'>
            <div>
                <form method="GET">                             
                    <h6>Адрес регистрации</h6>
                    <?php  
                        (new MyForm('ATClientAnketaCtrl','SaveClAdrR',$_GET['ClCode'],0))->AddForm();
                        echo("<p>");
                        echo("<label>ИНДЕКС</label><input type='text' name='CLADRRZIP' value='{$Client->CLADRRZIP}' maxlength=6>");
                        echo("<label>РЕГИОН</label><select name='CLADRRREG'>");
                            echo("<option value='{$Client->CLADRRREG}'>{$Client->CLADRRREG}</option>");
                            foreach($DRRegionsList as $Region){
                                echo("<option value='{$Region->REGNAME}'>{$Region->REGNAME}</option>");
                            }                            
                        echo("</select>");
                        echo("<label>РАЙОН</label><input type='text' name='CLADRRDIST' value='{$Client->CLADRRDIST}'>");
                        echo("</p>");
                        echo("<p>");
                        echo("<label>ГОРОД</label><input type='text' name='CLADRRCITY' value='{$Client->CLADRRCITY}'>");
                        echo("<label>УЛИЦА</label><input type='text' name='CLADRRSTR' value='{$Client->CLADRRSTR}'>");
                        echo("</p>");
                        echo("<p>");
                        echo("<label>ДОМ</label><input type='text' name='CLADRRHOUSE' value='{$Client->CLADRRHOUSE}'>");
                        echo("<label>КОРПУС</label><input type='text' name='CLADRRCORP' value='{$Client->CLADRRCORP}'>");
                        echo("<label>КВАРТИРА</label><input type='text' name='CLADRRAPP' value='{$Client->CLADRRAPP}'>");
                        echo("<label>ЯВЛЯЕТСЯ ЛИ СОБСТВЕННОСТЬЮ</label><select name='CLADRRPROPYN' value='{$Client->CLADRRPROPYN}'>"
                            . "<option >{$Client->CLADRRPROPYN}</option>"
                            . "<option value='да'>да</option>"
                            . "<option value='нет'>нет</option></select>");
                        
                        echo("<label>КОММЕНТАРИЙ</label><input type='text' class='input-comment' name='CLADRRCOMMENT' value='{$Client->CLADRRCOMMENT}'>");   
                        echo("</p>");
                    ?>
                    <button type="submit" class="btn btn-warning">СОХРАНИТЬ АДРЕС РЕГИСТРАЦИИ</button>
                </form>
            </div><!--Адрес регистрации-->
            <hr class='hr-tab'>
            <div>                
                <h6>Адрес проживания</h6>                    
                <?php   
                    echo("<a href='index_admin.php?controller=ATClientAnketaCtrl&action=CopyAdr&ClCode={$_GET['ClCode']}'><button class='btn btn-primary'>Совпадает с адресом регистрации</button></a>");
                    echo("<form method='get'>");
                        (new MyForm('ATClientAnketaCtrl','SaveClAdrF',$_GET['ClCode'],0))->AddForm();
                        echo("<p>");
                        echo("<label>ИНДЕКС</label><input type='text' name='CLADRFZIP' value='{$Client->CLADRFZIP}' maxlength=6>");                        
                        echo("<label>РЕГИОН</label><select name='CLADRFREG'>");
                            echo("<option value='{$Client->CLADRFREG}'>{$Client->CLADRFREG}</option>");
                            foreach($DRRegionsList as $Region){
                                echo("<option value='{$Region->REGNAME}'>{$Region->REGNAME}</option>");
                            }                            
                        echo("</select>");                        
                        echo("<label>РАЙОН</label><input type='text' name='CLADRFDIST' value='{$Client->CLADRFDIST}'>");
                        echo("</p>");
                        echo("<p>");
                        echo("<label>ГОРОД</label><input type='text' name='CLADRFCITY' value='{$Client->CLADRFCITY}'>");
                        echo("<label>УЛИЦА</label><input type='text' name='CLADRFSTR' value='{$Client->CLADRFSTR}'>");
                        echo("</p>");
                        echo("<p>");
                        echo("<label>ДОМ</label><input type='text' name='CLADRFHOUSE' value='{$Client->CLADRFHOUSE}'>");
                        echo("<label>КОРПУС</label><input type='text' name='CLADRFCORP' value='{$Client->CLADRFCORP}'>");
                        echo("<label>КВАРТИРА</label><input type='text' name='CLADRFAPP' value='{$Client->CLADRFAPP}'>");
                        echo("<label>ЯВЛЯЕТСЯ ЛИ СОБСТВЕННОСТЬЮ</label><select name='CLADRFPROPYN' value='{$Client->CLADRFPROPYN}'>"
                            . "<option >{$Client->CLADRFPROPYN}</option>"
                            . "<option value='да'>да</option>"
                            . "<option value='нет'>нет</option></select>");
                        echo("<label>КОММЕНТАРИЙ</label><input type='text' class='input-comment' name='CLADRFCOMMENT' value='{$Client->CLADRFCOMMENT}'>");  
                        echo("</p>");
                    ?>
                    <button type="submit" class="btn btn-warning">СОХРАНИТЬ АДРЕС ПРОЖИВАНИЯ</button>
                </form>
            </div><!--Адрес проживания-->                        
        </div> <!--Адреса и контакты-->
        
        <div class="tab-pane fade" id="fam">
            <h5>Семья</h5>  
            <form method="GET">
            <?php 
                (new MyForm('ATClientAnketaCtrl','SaveClFamily',$_GET['ClCode'],0))->AddForm();
                echo("<p><label>СЕМЕЙНОЕ ПОЛОЖЕНИЕ</label><select name='CLFAMSTATUS'>");
                echo("<option value='{$Client->CLFAMSTATUS}'>{$Client->CLFAMSTATUS}</option>");
                echo("<option value='холост/не замужем'>холост/не замужем</option>");
                echo("<option value='женат/замужем'>женат/замужем</option>");
                echo("<option value='в разводе'>в разводе</option>");
                echo("<option value='вдова/вдовец'>вдова/вдовец</option>");                
                echo("</select>");
                echo("<label>СУПРУГ</label><input type='text' name='CLFAMPARTNAME' value='{$Client->CLFAMPARTNAME}'>");
                echo("<label>Кол-во несовершеннолетних детей</label><input type='text' name='CLCHILDNUM' value='{$Client->CLCHILDNUM}'></p>");
                echo("<p><label>Дата заключения брака</label><input type='date' name='CLMARRIAGEDATE' value='{$Client->CLMARRIAGEDATE}'>");
                echo("<label>Дата развода</label><input type='date' name='CLDIVORCEDATE' value='{$Client->CLDIVORCEDATE}'>");
                echo("<label>Платит алименты</label><select name='CLALIMENTYN' value='{$Client->CLALIMENTYN}'>"
                    . "<option >{$Client->CLALIMENTYN}</option>"
                    . "<option value='не платит'>не платит</option>"
                    . "<option value='платит официально'>платит официально</option>"
                    . "<option value='платит не официально'>платит не официально</option></select>");
                echo("<label>Сумма алиментов</label><input type='text' name='CLALIMENTSUM' value='{$Client->CLALIMENTSUM}'></p>");
            ?>
            <button type="submit" class="btn btn-warning">СОХРАНИТЬ ИНФ О СЕМЬЕ</button>
            </form>
            <hr class='hr-tab'>
            <div>
                <h5>Несовершеннолетние дети</h5>
                <?php
                foreach($ClRelativesList as $Relative){
                    echo("<form method='get'>");
                    (new MyForm('ATClientAnketaCtrl','UpdRelative',$_GET['ClCode'],0))->AddForm();
                    echo("<input type='hidden' name='ClRelID' value='{$Relative->ID}'>");
                    echo("<label>ФИО</label>");
                    echo("<input type='text' name='ClRelName' value='{$Relative->CLRELNAME}' style='width:400'>");
                    echo("<label>кем приходится</label>");
                    echo("<input type='text' name='ClRelStatus' value='{$Relative->CLRELSTATUS}'>");
                    echo("<label>дата рождения</label>");
                    echo("<input type='date' name='ClRelBirthDate' value='{$Relative->CLRELBIRTHDATE}'><br>");
                    echo("<label>Свидетельство о рождении серия</label>");
                    echo("<input type='text' name='ClRelDocSer' value='{$Relative->CLRELDOCSER}'>");
                    echo("<label>номер</label>");
                    echo("<input type='text' name='ClRelDocNum' value='{$Relative->CLRELDOCNUM}'>");
                    echo("<label>дата выдачи</label>");
                    echo("<input type='date' name='ClRelDocDate' value='{$Relative->CLRELDOCDATE}'>");
                    
                    echo("<button type='submit' class='btn btn-success'>изменить</button></form>");
                        
                    echo("<form method='get' autocomplete='off'>");
                    (new MyForm('ATClientAnketaCtrl','DelRelative',$_GET['ClCode'],0))->AddForm();
                    echo("<input type='hidden' name='ClRelID' value='{$Relative->ID}'>");
                        
                    echo("<button type='submit' class='btn btn-danger'>удалить</button></form>");
                    
                }
                ?>
            </div>
            <hr class='hr-tab'>
            
            <div>
                <h5>Несовершеннолетние дети - добавить</h5>
                <form method="GET" autocomplete="off">                    
                    <?php
                        (new MyForm('ATClientAnketaCtrl','AddRelative',$_GET['ClCode'],0))->AddForm();
                    ?>
                    <label>Имя</label><input type="text" name="ClRelName">
                    <label>Кем приходится</label><input type="text"name="ClRelStatus">
                    <label>Дата рождения</label><input type="date"name="ClRelBirthDate"><br>
                    <label>Свидетельство о рождении серия</label><input type="text"name="ClRelDocSer">
                    <label>номер</label><input type="text"name="ClRelDocNum">
                    <label>дата</label><input type="date"name="ClRelDocDate">
                    <button type="submit" class="btn btn-warning">Сохранить</button>
                </form>
            </div>
        </div> <!--Семья-->
        
        <div class="tab-pane fade active show" id="docs">
            <h5>Документы</h5>  
            <div>         
                <?php
                    foreach($ClDocumentsList as $Document){       
                        echo("<form method='get' autocomplete='off'>");
                        (new MyForm('ATClientAnketaCtrl','UpdDocument',$_GET['ClCode'],0))->AddForm();
                        echo("<input type='hidden' name='ClDocID' value='{$Document->ID}'>");
                        echo("<p><label>Вид</label>");
                        echo("<input type='text' name='ClDocName' value='{$Document->CLDOCNAME}'>");
                        echo("<label>серия</label>");
                        echo("<input type='text' name='ClDocSer' value='{$Document->CLDOCSER}'>");
                        echo("<label>Номер</label>");
                        echo("<input type='text' name='ClDocNum' value='{$Document->CLDOCNUM}'>");
                        echo("<label>Комментарий</label>");
                        echo("<input type='text' name='ClDocComment' value='{$Document->CLDOCCOMMENT}'></p>");    
                        echo("<p><label>Кем выдан</label>");
                        echo("<input size='80' type='text' name='ClDocOrg' value='{$Document->CLDOCORG}'>");
                        echo("<label>Дата выдачи</label>");
                        echo("<input type='date' name='ClDocDate' value='{$Document->CLDOCDATE}'></p>");                        
                        echo("<p><label>Код подр.</label>");
                        echo("<input type='text' name='ClDocAttr1' value='{$Document->CLDOCATTR1}'>");
                        echo("<button type='submit' class='btn btn-success'>изменить</button></form>");
                        
                        echo("<form method='get' autocomplete='off'>");
                        (new MyForm('ATClientAnketaCtrl','DelDocument',$_GET['ClCode'],0))->AddForm();
                        echo("<input type='hidden' name='ClDocID' value='{$Document->ID}'>");
                        
                        echo("<button type='submit' class='btn btn-danger'>удалить</button></p></form>");
                    }
                ?>
                <hr class='hr-tab'>
            </div><!--список документов-->
            <div>
                <h5>Добавить документ</h5>  
                <form method="GET">
                    <input type="hidden" name="controller" value="ATClientAnketaCtrl">
                    <input type="hidden" name="action" value="AddDocument">
                    <input type="hidden" name="ClCode" value="<?php echo($Client->CLCODE);?>">
                    <p>
                    <label>вид документа</label>
                    <select name="ClDocName" value="">
                        <option value=""></option>
                        <option value="паспорт">паспорт</option>
                        <option value="СНИЛС">СНИЛС</option>
                        <option value="ИНН">ИНН</option>
                        <option value="брачный договор">брачный договор</option>
                        <option value="свидетельство о браке">свидетельство о браке</option>
                        <option value="свидетельство о расторжении брака">свидетельство о расторжении брака</option>
                        <option value="свидетельство о смерти">свидетельство о смерти</option>
                        <option value="иной документ">иной документ</option>
                    </select>
                    <label>серия</label><input type="text" name="ClDocSer">
                    <label>номер</label><input type="text" name="ClDocNum">
                    <label>Комментарий</label><input type="text" name="ClDocComment">
                    </p>
                    <p>
                        <label>Кем выдан</label><input size='80' type="text" name="ClDocOrg">
                        <label>Дата выдачи</label><input type="date" name="ClDocDate">
                    </p>
                        <label>код подразд.</label><input type="text" name="ClDocAttr1">
                        <label>Доп реквизит</label><input type="text" name="ClDocAttr2">
                        <label>Доп реквизит</label><input type="text" name="ClDocAttr3">
                    <p>
                    </p>    
                    <button type="submit" class="btn btn-warning">Сохранить</button>
                </form>
            </div><!--форма добавления документов-->            
        </div> <!--Документы-->
        
        <div class="tab-pane fade" id="status">
            <!--ДЕЛИМ НА ВКЛАДКИ-->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" data-bs-toggle="tab" href="#ForDocs">Для документов</a>
                </li>
                
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#business">Регистрация ИП/ООО</a>
                </li>
                
            </ul><!--заголовки вкладок вкладки Юридический статус-->
            <div id="myTabContent" class="tab-content"> 
                
                <div class="tab-pane fade active show" id="ForDocs">
                    <form method='get'>
                        <?php (new MyForm('ATClientAnketaCtrl','SaveClForDocs',$_GET['ClCode'],0))->AddForm(); 
                        echo("<p><label>ФИО родительный падеж (кого)</label><input type='text' name='ClNameRP' value='{$Client->CLNAMERP}'></p>");
                        echo("<p><label>ФИО дательный падеж (кому)</label><input type='text' name='ClNameDP' value='{$Client->CLNAMEDP}'></p>");
                        echo("<p><label>ФИО творительный падеж (кем)</label><input type='text' name='ClNameTP' value='{$Client->CLNAMETP}'></p>");

                        echo("<p><label>Факт привлечения к административной ответственности</label><select type='text' name='CLADMRESPYN'>");
                        echo("<option value='{$Client->CLADMRESPYN}'>{$Client->CLADMRESPYN}</option>");
                        echo("<option value='да'>да</option>");
                        echo("<option value='нет'>нет</option>");
                        echo("</select></p>");

                        echo("<p><label>Наличие снятой/непогашенной судимости</label><select type='text' name='CLCRIMINALRESPYN'>");
                        echo("<option value='{$Client->CLCRIMINALRESPYN}'>{$Client->CLCRIMINALRESPYN}</option>");
                        echo("<option value='да'>да</option>");
                        echo("<option value='нет'>нет</option>");
                        echo("</select></p>");
                        ?>
                        <button type="submit" class="btn btn-warning">СОХРАНИТЬ ИНФ ДЛЯ ДОКУМЕНТОВ</button>
                    </form>    
                </div>
                                
                <div class="tab-pane fade" id="business">
                    <form method='get'>
                        <?php
                            (new MyForm('ATClientAnketaCtrl','SaveClBusiness',$_GET['ClCode'],0))->AddForm();
                            echo("<p><label>Факт регистрации ИП</label><select type='text' name='CLINDENTRYN'>"); 
                            echo("    <option value='{$Client->CLINDENTRYN}'>{$Client->CLINDENTRYN}</option>"); 
                            echo("    <option value='да'>да</option>"); 
                            echo("    <option value='нет'>нет</option>"); 
                            echo("</select>"); 
                            echo("<label>Действующий статус</label><select type='text' name='CLINDENTRACT'>"); 
                            echo("    <option value='{$Client->CLINDENTRACT}'>{$Client->CLINDENTRACT}</option>"); 
                            echo("    <option value='открыто'>открыто</option>"); 
                            echo("    <option value='закрыто'>закрыто</option>"); 
                            echo("</select>");
                            echo("<label>Дата открытия</label><input type='date' name='CLINDENTROPENDATE' value='{$Client->CLINDENTROPENDATE}'>"); 
                            echo("<label>Дата закрытия</label><input type='date' name='CLINDENTRCLOSEDATE' value='{$Client->CLINDENTRCLOSEDATE}'></p>"); 

                            echo("<p><label>Факт регистрации ООО</label><Select type='text' name='CLLTDYN'>");
                            echo("    <option value='{$Client->CLLTDYN}'>{$Client->CLLTDYN}</option>");
                            echo("    <option value='да'>да</option>");
                            echo("    <option value='нет'>нет</option>");
                            echo("</select>");
                            echo("<label>Действующий статус</label><select type='text' name='CLLTDACT'>");
                            echo("    <option value='{$Client->CLLTDACT}'>{$Client->CLLTDACT}</option>"); 
                            echo("    <option value='действующее'>действующее</option>"); 
                            echo("    <option value='ликвидировано'>ликвидировано</option>"); 
                            echo("</select>");                            
                            echo("<label>Дата открытия</label><input type='date' name='CLLTDOPENDATE' value='{$Client->CLLTDOPENDATE}'>");
                            echo("<label>Дата закрытия</label><input type='date' name='CLLTDCLOSEDATE' value='{$Client->CLLTDCLOSEDATE}'></p>");

                        ?>
                        <button type="submit" class="btn btn-warning" type="submit" class="btn btn-warning">СОХРАНИТЬ ИНФ О РЕГИСТРАЦИИ ООО/ИП</button>
                    </form>
                </div>
                
            </div>
        </div> <!--Юридический статус-->
        <div class="tab-pane fade" id="ipoteka">
            <form>
            <?php
                (new MyForm('ATClientAnketaCtrl','SaveClIpoteka',$_GET['ClCode'],0))->AddForm();
                echo("<p><label>Наличие ипотеки</label><select type='text' name='ClIpotekaYN''>");
                echo("    <option value='{$Client->CLIPOTEKAYN}'>{$Client->CLIPOTEKAYN}</option>");
                echo("    <option value='да'>да</option>");
                echo("    <option value='нет'>нет</option>");
                echo("</select>");                               
                echo("<label>Кем является</label><select type='text' name='ClIpotekaStatus' >");
                echo("    <option value='{$Client->CLIPOTEKASTATUS}'>{$Client->CLIPOTEKASTATUS}</option>");
                echo("    <option value='заёмщик'>заёмщик</option>");
                echo("    <option value='созаёмщик'>созаёмщик</option>");
                echo("    <option value='поручитель'>поручитель</option>");
                echo("</select>");                                                   
                echo("<label>Название банка</label><input type='text' name='ClIpotekaBank' value='{$Client->CLIPOTEKABANK}'></p>");

                echo("<p><label>Вид залога</label><select name='ClIpotekaType'>");
                echo("    <option value='{$Client->CLIPOTEKATYPE}'>{$Client->CLIPOTEKATYPE}</option>");
                echo("    <option value='квартира'>квартира</option>");
                echo("    <option value='дом'>дом</option>");
                echo("    <option value='земельный участок'>земельный участок</option>");
                echo("    <option value='дом с участком'>дом с участком</option>");
                echo("    <option value='иное'>иное</option>");
                echo("</select>"); 
                echo("<label>Описание</label><input type='text' name='ClIpotekaComment' value='{$Client->CLIPOTEKACOMMENT}'></p>");
                echo("<label>Адрес объекта залога</label><input type='text' name='ClIpotekaAdr' value='{$Client->CLIPOTEKAADR}'></p>");
                echo("<p><label>Текущая рыночная стоимость</label><input type='text' name='ClIpotekaCost' value='{$Client->CLIPOTEKACOST}'>");
                echo("<label>Примерный остаток долга</label><input type='text' name='ClIpotekaCurSum' value='{$Client->CLIPOTEKACURSUM}'></p>"); 
            ?>   
            <p><button type="submit" class="btn btn-warning">СОХРАНИТЬ ИНФ ОБ ИПОТЕКЕ</button></p>
            </form>
        </div><!<!-- ипотека -->
        
        <div class="tab-pane fade" id="incprop">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" data-bs-toggle="tab" href="#incomes">Доходы</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#work">Работа</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#property">Собственность</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#deals">Сделки</a>
                </li> 
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#accounts">Счета в банках</a>
                </li>
            </ul><!--заголовки вкладок вкладки Доходы и собственность-->    
            <div id="myTabContent" class="tab-content"> 
                <div class="tab-pane fade active show" id="incomes">
                    <h5>Доходы</h5>  
                    <div>       
                        <table class='table table-hover'>
                            <thead>
                                <tr>
                                    <th>Вид</th>
                                    <th>Сумма</th>
                                    <th>Сумма оф.</th>
                                    <th>% удержания</th>
                                    <th>Сумма факт.</th>
                                    <th>На карту</th>
                                    <th>Банк</th>
                                    <th>Дата назначения пенсии</th>
                                    <th>Комментарий</th>
                                    <th>---</th>
                                    <th>---</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($ClIncomesList as $Income){                
                                    $IncomePensDate=(new PrintFunctions())->DateToStr($Income->CLINCPENSDATE);
                                    echo("<tr class='table-secondary'><form method='get'>");
                                    (new MyForm('ATClientAnketaCtrl','DelIncome',$_GET['ClCode'],0))->AddForm();
                                    echo("<input type='hidden' name='ClIncID' value='{$Income->ID}'>");
                                    echo("<td>$Income->CLINCNAME</td>");
                                    echo("<td>$Income->CLINCSUM</td>");
                                    echo("<td>$Income->CLINCSUMOF</td>");
                                    echo("<td>$Income->CLINCDEDUCT</td>");
                                    echo("<td>$Income->CLINCSUMREAL</td>");
                                    echo("<td>$Income->CLINCCARDYN</td>");
                                    echo("<td>$Income->CLINCBANK</td>");
                                    echo("<td>$IncomePensDate</td>");
                                    echo("<td>$Income->CLINCCOMMENT</td>");
                                    #echo("<td><button type='submit' class='btn btn-success'>Изменить</button></td>");
                                    echo("<td><button type='submit' class='btn btn-danger'>Удалить</button></td></form>");
                                    echo("</tr>");
                                }
                            ?>
                            </tbody>
                        </table>
                        <hr class='hr-tab'>
                    </div><!--список доходов-->
                    <div>
                        <h5>Добавить доход</h5>  
                        <form>
                            <?php (new MyForm('ATClientAnketaCtrl','AddIncome',$_GET['ClCode']))->AddForm();?>
                            <p>
                                <label>Вид дохода</label><select type='text' name='ClIncName'>
                                    <option value=''></option>
                                    <option value='зарплата'>зарплата</option>
                                    <option value='совместительство'>совместительство</option>
                                    <option value='подработка'>подработка</option>
                                    <option value='пенсия'>пенсия</option>
                                    <option value='аренда'>аренда</option>
                                    <option value='алименты'>алименты</option>
                                    <option value='декретные выплаты'>декретные выплаты</option>
                                    <option value='пособия'>пособия</option>
                                    <option value='пенсия на ребёнка'>пенсия на ребёнка</option>
                                    <option value='доход супруга'>доход супруга</option>
                                </select>
                                <label>Сумма</label><input type='text' name='ClIncSum' autocomplete='off'>                                
                                <label>Официальная сумма</label><input type='text' name='ClIncSumOf'  autocomplete='off'>
                            </p>
                            <p>                                
                                <label>Размер удержаний (%)</label><input type='text' name='ClIncDeduct' autocomplete='off'>
                                <label>Сумма на руки</label><input type='text' name='ClIncSumReal' autocomplete='off'>
                            </p>
                            <p>                                
                                <label>На карту</label><input type='text' name='ClIncCardYN' autocomplete='off'>
                                <label>Банк</label><input type='text' name='ClIncBank' autocomplete='off'>
                                <label>Комментарий</label><input type='text' name='ClIncComment' autocomplete='off'>
                                <label>Дата назначения пенсии</label><input type='date' name='ClIncPensDate' autocomplete='off'>
                            </p>                            
                            <button class='btn btn-warning'>Сохранить</button>
                        </form>                        
                    </div><!--добавить доход-->
                    
                </div><!--Доходы-->
                
                <div class="tab-pane fade" id="work">
                    <form method='get'>
                        <?php
                            (new MyForm('ATClientAnketaCtrl','SaveClWork',$_GET['ClCode'],0))->AddForm();

                            echo("<p><label>Вид занятости</label><select type='text' name='CLWORKSTATUS'>");
                            echo("<option value='{$Client->CLWORKSTATUS}'>{$Client->CLWORKSTATUS}</option>");
                            echo("<option value='официально'>официально</option>");
                            echo("<option value='неофициально'>неофициально</option>");
                            echo("<option value='ИП'>ИП</option>");
                            echo("<option value='самозанятый'>самозанятый</option>");
                            echo("<option value='в декрете'>в декрете</option>");
                            echo("<option value='пенсионер'>пенсионер</option>");
                            echo("<option value='не работает'>не работает</option>");
                            echo("</select>");
                            echo("<label>Место работы (организация)</label><input type='text' name='CLWORKORG' value='{$Client->CLWORKORG}'>");
                            echo("<label>Должность</label><input type='text' name='CLWORKPOS' value='{$Client->CLWORKPOS}'>");
                            echo("<label>Стаж на последнем месте</label><input type='text' name='CLWORKPERIOD' value='{$Client->CLWORKPERIOD}'></p>");

                            echo("<p><label>Адрес работы</label><input type='text' name='CLWORKORGADR' value='{$Client->CLWORKORGADR}'>");
                            echo("<label>ИНН работодателя</label><input type='text' name='CLWORKORGINN' value='{$Client->CLWORKORGINN}'></p>");

                            echo("<p><label>Вид занятости супруга</label><select type='text' name='CLWORKPARTSTATUS'>");
                            echo("<option value='{$Client->CLWORKPARTSTATUS}'>{$Client->CLWORKPARTSTATUS}</option>");
                            echo("<option value='официально'>официально</option>");
                            echo("<option value='неофициально'>неофициально</option>");
                            echo("<option value='ИП'>ИП</option>");
                            echo("<option value='самозанятый'>самозанятый</option>");
                            echo("<option value='в декрете'>в декрете</option>");
                            echo("<option value='пенсионер'>пенсионер</option>");
                            echo("<option value='не работает'>не работает</option>");
                            echo("</select>");
                            echo("<label>Место работы супруга</label><input type='text' name='CLWORKPARTORG' value='{$Client->CLWORKPARTORG}'>"); 
                            echo("<label>Должность супруга</label><input type='text' name='CLWORKPARTPOS' value='{$Client->CLWORKPARTPOS}'></p>");   
                        ?>                    
                        <p>
                            <button type="submit" class="btn btn-warning">СОХРАНИТЬ ИНФ О РАБОТЕ</button>
                        </p>
                    </form>
                </div>
                
                <div class="tab-pane fade" id="property">
                    <h5>Собственность</h5>  
                    <div>         
                        <table class='table table-hover'>
                            <thead>
                                <tr>
                                    <th>Вид</th>
                                    <th>Собственник</th>
                                    <th>Описание</th>
                                    <th>Стоимость</th>
                                    <th>Дата приобретения</th>
                                    <th>Комментарий</th>
                                    <th>Есть доки на ЭПЭ</th>
                                    <th>---</th>
                                    <th>---</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($ClPropertyList as $Property){                
                                    echo("<tr class='table-secondary'><form method='get'>");
                                    (new MyForm('ATClientAnketaCtrl','UpdProperty',$_GET['ClCode'],0))->AddForm();
                                    echo("<input type='hidden' name='ClPropID' value='{$Property->ID}'>");
                                    echo("<td><input type='text' value='{$Property->CLPROPTYPE}' name='CLPROPTYPE'</td>");
                                    echo("<td><input type='text' value='{$Property->CLPROPOWNER}' name='CLPROPOWNER'</td>");
                                    echo("<td><input type='text' value='{$Property->CLPROPDESC}' name='CLPROPDESC'</td>");
                                    echo("<td><input type='text' value='{$Property->CLPROPCOST}' name='CLPROPCOST'</td>");
                                    echo("<td><input type='date' value='{$Property->CLPROPDATE}' name='CLPROPDATE'</td>");
                                    echo("<td><input type='text' value='{$Property->CLPROPCOMMENT}' name='CLPROPCOMMENT'</td>");                                    
                                    echo("<td><input type='text' value='{$Property->CLPROPDOCUMENTSYN}' name='CLPROPDOCUMENTSYN'</td>");     
                                    
                                    echo("<td><button type='submit' class='btn btn-success'>изменить</button></td></form>");
                        
                                    echo("<form method='get' autocomplete='off'>");
                                    (new MyForm('ATClientAnketaCtrl','DelProp',$_GET['ClCode'],0))->AddForm();
                                    echo("<input type='hidden' name='ClPropID' value='{$Property->ID}'>");
                                    
                                    echo("<td><button type='submit' class='btn btn-danger'>Удалить</button></td></form>");
                                    echo("</tr>");
                                }
                            ?>
                            </tbody>
                        </table>
                        <hr class='hr-tab'>
                    </div><!--список собственности-->
                    <div>
                        <h5>Добавить собственность</h5>  
                        <form>
                            <?php (new MyForm('ATClientAnketaCtrl','AddProperty',$_GET['ClCode']))->AddForm();?>
                            <p>
                                <label>Вид имущества</label><select type='text' name='ClPropType'>
                                    <option></option>
                                    <option value='автомобиль'>автомобиль</option>
                                    <option value='квартира'>квартира</option>
                                    <option value='дом'>дом</option>
                                    <option value='земельный участок'>земельный участок</option>
                                    <option value='иное имущество'>иное имущество</option>
                                </select>
                                <label>Собственник</label><select type='text' name='ClPropOwner'>                                
                                    <option></option>
                                    <option value='клиент'>клиент</option>
                                    <option value='супруг'>супруг</option>
                                    <option value='совместно нажитое'>совместно нажитое</option>
                                    <option value='бывший супруг'>бывший супруг</option>
                                </select>
                                <label>Описание</label><input type='text' name='ClPropDesc'>                                
                            </p>
                            <p>                                
                                <label>Стоимость</label><input type='text' name='ClPropCost'>
                                <label>Дата приобретения</label><input type='date' name='ClPropDate'>
                                <label>Комментарий</label><input type='text' name='ClPropComment'>
                                <label>Предоставил доки</label><select type='text' name='ClPropDocumentsYN'>
                                    <option></option>
                                    <option value="да">да</option>
                                    <option value="нет">нет</option>
                                </select>
                            </p>                                                        
                            <button class='btn btn-warning'>Сохранить</button>
                        </form>                        
                    </div><!--добавить собственность-->
                </div><!--Собственность-->
                <div class="tab-pane fade" id="deals">
                    <h5>Сделки</h5>  
                    <div>         
                        <table class='table table-hover'>
                            <thead>
                                <tr>
                                    <th>Вид</th>
                                    <th>Собственник</th>
                                    <th>Предмет сделки</th>
                                    <th>Стоимость</th>                                    
                                    <th>Дата сделки</th>
                                    <th>Комментарий</th>
                                    <th>Есть доки на ЭПЭ</th>
                                    <th>---</th>
                                    <th>---</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($ClDealsList as $Deal){                
                                    echo("<tr class='table-secondary'><form method='get'>");
                                    (new MyForm('ATClientAnketaCtrl','UpdDeal',$_GET['ClCode'],0))->AddForm();
                                    echo("<input type='hidden' name='ClDlID' value='{$Deal->ID}'>");
                                    echo("<td><input type='text' value='{$Deal->CLDLTYPE}' name='CLDLTYPE'</td>");
                                    echo("<td><input type='text' value='{$Deal->CLDLOWNER}' name='CLDLOWNER'</td>");
                                    echo("<td><input type='text' value='{$Deal->CLDLOBJ}' name='CLDLOBJ'</td>");
                                    echo("<td><input type='text' value='{$Deal->CLDLSUM}' name='CLDLSUM'</td>");                                    
                                    echo("<td><input type='date' value='{$Deal->CLDLDATE}' name='CLDLDATE'</td>");
                                    echo("<td><input type='text' value='{$Deal->CLDLCOMMENT}' name='CLDLCOMMENT'</td>");    
                                    echo("<td><input type='text' value='{$Deal->CLDLDOCUMENTSYN}' name='CLDLDOCUMENTSYN'</td>");
                                    echo("<td><button type='submit' class='btn btn-success'>изменить</button></td></form>");
                        
                                    echo("<form method='get' autocomplete='off'>");
                                    (new MyForm('ATClientAnketaCtrl','DelDeal',$_GET['ClCode'],0))->AddForm();
                                    echo("<input type='hidden' name='ClDlID' value='{$Deal->ID}'>");
                                    echo("<td><button type='submit' class='btn btn-danger'>Удалить</button></td></form>");
                                    echo("</tr>");
                                }
                            ?>
                            </tbody>
                        </table>
                        <hr class='hr-tab'>
                    </div><!--список сделок-->
                    <div>
                        <h5>Добавить сделку</h5>  
                        <form>
                            <?php (new MyForm('ATClientAnketaCtrl','AddDeal',$_GET['ClCode']))->AddForm();?>
                            <p>
                                <label>Вид сделки</label><select type='text' name='ClDlType'>
                                    <option></option>
                                    <option value='купля/продажа'>купля/продажа</option>
                                    <option value='дарение'>дарение</option>
                                    <option value='наследство'>наследство</option>
                                    <option value='иное'>иное</option>
                                </select>
                                <label>Объект</label><select type='text' name='ClDlObj'>                                
                                    <option></option>
                                    <option value='автомобиль'>автомобиль</option>
                                    <option value='квартира'>квартира</option>
                                    <option value='дом'>дом</option>
                                    <option value='земельный участок'>земельный участок</option>
                                    <option value='иное имущество'>иное имущество</option>
                                </select>
                                <label>Собственник</label><select type='text' name='ClDlOwner'>                                
                                    <option></option>
                                    <option value='клиент'>клиент</option>
                                    <option value='супруг'>супруг</option>
                                    <option value='совместно нажитое'>совместно нажитое</option>
                                    <option value='бывший супруг'>бывший супруг</option>
                                </select>
                            </p>
                            <p>                                
                                <label>Сумма</label><input type='text' name='ClDlSum'>
                                <label>Дата</label><input type='date' name='ClDlDate'>
                                <label>Комментарий</label><input type='text' name='ClDlComment'>
                                <label>Предоставил доки</label><select type='text' name='ClDlDocumentsYN'>
                                    <option></option>
                                    <option value="да">да</option>
                                    <option value="нет">нет</option>
                                </select>
                            </p>
                            <button class='btn btn-warning'>Сохранить</button>
                        </form>                        
                    </div><!--добавить сделку-->
                </div><!--Сделки-->
                <div class="tab-pane fade" id="accounts">
                    <h5>Счета в банках</h5>  
                    <div>         
                       <table class='table table-hover'>
                            <thead>
                                <tr>
                                    <th>Банк</th>
                                    <th>Номер счёта</th>
                                    <th>Сумма остатка</th>                                    
                                    <th>Дата открытия</th>
                                    <th>Дата закрытия</th>
                                    <th>Комментарий</th>
                                    <th>---</th>
                                    <th>---</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach($ClBankAccsList as $Acc){        
                                    $OpenDate=(new PrintFunctions())->DateToStr($Acc->CLBNOPENDAT);
                                    $CloseDate=(new PrintFunctions())->DateToStr($Acc->CLBNCLOSEDAT);
                                    echo("<tr class='table-secondary'><form method='get'>");
                                    (new MyForm('ATClientAnketaCtrl','DelBankAcc',$_GET['ClCode'],0))->AddForm();
                                    echo("<input type='hidden' name='ClAccID' value='{$Acc->ID}'>");
                                    echo("<td>$Acc->CLBNNAME</td>");
                                    echo("<td>$Acc->CLBNACC</td>");
                                    echo("<td>$Acc->CLBNSUM</td>");                                    
                                    echo("<td>$OpenDate</td>");
                                    echo("<td>$CloseDate</td>");
                                    echo("<td>$Acc->CLBNCOMMENT</td>");  
                                    #echo("<td><button type='submit' class='btn btn-success'>Изменить</button></td>");
                                    echo("<td><button type='submit' class='btn btn-danger'>Удалить</button></td></form>");
                                    echo("</tr>");
                                }
                            ?>
                            </tbody>
                        </table>
                        <hr class='hr-tab'>
                    </div><!--список счетов-->
                    <div>
                        <h5>Добавить счёт</h5>  
                        <form>
                            <?php (new MyForm('ATClientAnketaCtrl','AddBankAcc',$_GET['ClCode']))->AddForm();?>
                            <p>
                                <label>Банк</label><input type='text' name='ClBnName'>
                                <label>Номер сч.</label><input type='text' name='ClBnAcc'>
                                <label>Сумма</label><input type='text' name='ClBnSum'>
                            </p>
                            <p>
                                <label>Открыт</label><input type='date' name='ClBnOpenDate'>
                                <label>Закрыт</label><input type='date' name='ClBnCloseDate'>
                                <label>Комментарий</label><input type='text' name='ClBnComment'>
                            </p>
                            <button class='btn btn-warning'>Сохранить</button>
                        </form>                        
                    </div><!--добавить счёт-->
                </div><!--Счета-->
            </div> <!--вкладки вкладки доходы и собственность-->
        </div> <!--Доходы и собственность-->
    </div> <!--вкладки анкеты-->
    
</body>
</html>

