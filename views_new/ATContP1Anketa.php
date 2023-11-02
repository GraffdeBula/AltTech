<?php
/*
 * Анкета договора - список кредитных договоров
 *  */
//var_dump($CredDocList);
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <div>
        <h3>ДОГОВОР БФЛ - АНКЕТА ДОГОВОРА</h3>   
    </div>
                                
        <?php
            echo("<div class='g-row'>");
            echo("<p>Клиент: {$Client->CLFNAME} {$Client->CL1NAME} {$Client->CL2NAME}</p>");
            echo("</div>");            
            echo("<p>Договор ID: {$Cont->CONTCODE}</p>");
            echo("<p>Число кредитов/займов: <strong>{$Anketa->AKCREDNUM}</strong> Сумма долга общая: <strong>{$Anketa->AKCREDTOTSUM}</strong> Сумма основного долга: <strong>{$Anketa->AKCREDMAINSUM}</strong></p>");
            echo("<a href='index_admin.php?controller=ATContP1AnketaCtrl&action=NewCred&ClCode={$Client->CLCODE}&ContCode={$Cont->CONTCODE}'><button class='btn btn-warning'>ДОБАВИТЬ КРЕДИТНЫЙ ДОГОВОР</button></a>");            
        ?>
        
    <h5>Список кредитных договоров</h5>
    <!--
    <input id="CredSearch" type='text' value="" placeholder="Поиск кредитора">
    <button id='BtnSearch' >search</button>
    <button id='Btn2' class='btn btn-primary'>btn2</button>
    -->
    <div class="accordion" id="CreditList">        
        <?php
            foreach($CredList as $Cred){
                $CrDate=(new PrintFunctions())->DateToStr($Cred->CROPENDAT);
                echo("
                <div class='accordion-item'>
                    <h2 class='accordion-header' id='heading{$Cred->CRCODE}'>
                        <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse{$Cred->CRCODE}' aria-expanded='false' aria-controls='collapse{$Cred->CRCODE}'>
                            <p>Договор с  <strong>{$Cred->CRBANKCONTNAME}</strong> Текущий кредитор: <strong>{$Cred->CRBANKCURNAME}</strong> номер <strong>{$Cred->CRCONTNUM}</strong>
                                от <strong>{$CrDate}</strong> 
                                Сумма кредита: <strong>{$Cred->CRSUM}</strong> Вид кредита: <strong>{$Cred->CRPROG}</strong> Остаток долга: <strong>{$Cred->CRSUMREST}</strong>                                    
                                
                            </p>
                        </button>                        
                    </h2>
                    <div id='collapse{$Cred->CRCODE}' class='accordion-collapse collapse' aria-labelledby='heading{$Cred->CRCODE}' data-bs-parent='#accordionExample' style=''>
                        <div class='accordion-body' style='background-color: #ede8cc;'>                           
                        ");
                        echo("
                            <ul  class='nav nav-tabs ' role='tablist'>
                                <li class='nav-item'>
                                    <a class='nav-link active' data-bs-toggle='tab' href='#credmain{$Cred->CRCODE}'>Основная информация</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link' data-bs-toggle='tab' href='#credadd{$Cred->CRCODE}'>Дополнительная информация</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link' data-bs-toggle='tab' href='#creddocs{$Cred->CRCODE}'>Документы по кредиту</a>
                                </li>
                            </ul>
                            <div id='myTabContent' class='tab-content'>
                                <div class='tab-pane fade  active show' id='credmain{$Cred->CRCODE}'>   
                            
                                <form method='get' autocomplete='off' id='frmSaveMain'>");
                                (new MyForm('ATContP1AnketaCtrl','UpdCred',$_GET['ClCode'],$_GET['ContCode']))->AddForm();
                                echo("
                                    <input type='hidden' name='CRCODE' value='{$Cred->CRCODE}'>
                                    <h5>Кредитор по договору</h5>
                                    <p>
                                    <label>Вид кредитора</label><select name='CRBANKCONTTYPE'>
                                        <option value='{$Cred->CRBANKCONTTYPE}'>{$Cred->CRBANKCONTTYPE}</option>
                                        <option value='банк'>банк</option>
                                        <option value='МФО'>МФО</option>
                                        <option value='коллектор'>коллектор</option>
                                        <option value='другая организация'>другая организация</option>
                                        <option value='управляющая компания'>управляющая компания</option>
                                        <option value='ИФНС'>ИФНС</option>
                                        <option value='физ лицо'>физ лицо</option>                                
                                    </select>
                                    <label>Кредитор по договору</label><input type='text' name='CRBANKCONTNAME' value='{$Cred->CRBANKCONTNAME}' autocomplete='off'>
                                    <label>ИНН</label><input type='text' maxlength=10 name='CRBANKCONTINN' value='{$Cred->CRBANKCONTINN}'>
                                    </p>    
                                    <p>    
                                    <label>Номер договора</label><input type='text' name='CRCONTNUM' value='$Cred->CRCONTNUM'>
                                    <label>Дата договора</label><input type='date' name='CROPENDAT' value={$Cred->CROPENDAT}>
                                    </p>
                                    <h5>Текущий кредитор</h5>
                                    <p>
                                    <label>Вид кредитора</label><select name='CRBANKCURTYPE'>
                                        <option value='{$Cred->CRBANKCURTYPE}'>{$Cred->CRBANKCURTYPE}</option>
                                        <option value='банк'>банк</option>
                                        <option value='МФО'>МФО</option>
                                        <option value='коллектор'>коллектор</option>
                                        <option value='другая организация'>другая организация</option>
                                        <option value='управляющая компания'>управляющая компания</option>
                                        <option value='ИФНС'>ИФНС</option>
                                        <option value='физ лицо'>физ лицо</option>                         
                                    </select>
                                    <label>Наименование</label><input type='text' name='CRBANKCURNAME' value='{$Cred->CRBANKCURNAME}' autocomplete='off'>
                                    <label>ИНН</label><input type='text' maxlength=10 name='CRBANKCURINN' value='{$Cred->CRBANKCURINN}' autocomplete='off'>
                                    </p>
                                    <p>
                                    <label>Вид кредита</label><select name='CRPROG'>
                                        <option value='{$Cred->CRPROG}'>{$Cred->CRPROG}</option>
                                        <option value='потребительский'>потребительский</option>
                                        <option value='кред.карта'>кред.карта</option>
                                        <option value='товарный'>товарный</option>
                                        <option value='ипотека'>ипотека</option>                              
                                        <option value='займ/микрозайм'>займ/микрозайм</option>                              
                                        <option value='залоговый'>залоговый</option>                        
                                        <option value='автокредит'>автокредит</option>                              
                                        <option value='поручительство'>поручительство</option>                              
                                        <option value='расписка'>расписка</option>                              
                                        <option value='рефинансирование'>рефинансирование</option>                              
                                    </select>
                                    <label>Сумма</label><input type='text' name='CRSUM' value='{$Cred->CRSUM}' autocomplete='off'>");
                                    if (($_SESSION['EmRole']=='admin') or ($_SESSION['EmRole']=='expert') or ($_SESSION['EmRole']=='top')){
                                        $AnketaShowField="text";                                            
                                        $AnketaEnableField="";
                                    }else{
                                        $AnketaShowField="hidden";
                                        $AnketaEnableField="disabled";
                                    }                                    
                                    echo("<label>Ставка</label><input type='{$AnketaShowField}' name='CRRATE' value='{$Cred->CRRATE}' autocomplete='off'>
                                        <label>Срок</label><input type='{$AnketaShowField}' name='CRPERIOD' value='{$Cred->CRPERIOD}' autocomplete='off'>                                    
                                        </p>
                                        <p>    
                                        <label>Остаток долга</label><input type='{$AnketaShowField}' name='CRSUMREST' value='{$Cred->CRSUMREST}' autocomplete='off'>
                                        <label>Остаток основного долга</label><input type='{$AnketaShowField}' name='CRSUMRESTMAIN' value='{$Cred->CRSUMRESTMAIN}' autocomplete='off'>
                                        </p>
                                        <p> 
                                        <label>Сумма платежа</label><input type='{$AnketaShowField}' name='CRPAYSUM' value='{$Cred->CRPAYSUM}' autocomplete='off'>
                                        <label>День платежа</label><input type='{$AnketaShowField}' name='CRPAYDAY' value='{$Cred->CRPAYDAY}' autocomplete='off'>");
                                    
                                    echo("
                                    <label>Сумма последнего платежа</label><input type='text' name='CRPAYLASTSUM' value='{$Cred->CRPAYLASTSUM}' autocomplete='off'>
                                    </p>
                                    <p>    
                                        <label>Дата последнего платежа</label><input type='date' name='CRPAYLASTDAT' value='{$Cred->CRPAYLASTDAT}' autocomplete='off'>
                                        <label>Наличие просрочки</label><select type='text' name='CRDELAYYN' autocomplete='off'>
                                            <option value='$Cred->CRDELAYYN'>{$Cred->CRDELAYYN}</option>
                                            <option value='да'>да</option>
                                            <option value='нет'>нет</option>
                                        </select>
                                        <label>Число внесённых платежей</label><input type='text' name='CRPAYSNUM' value='{$Cred->CRPAYSNUM}' maxlength='50' autocomplete='off'> 
                                        <label>Число внесённых платежей</label><input type='number' value='{$Cred->CRPAYSNUM}' autocomplete='off'> 
                                    </p>
                                    <p>
                                        <h5>Для кредитной карты</h5>
                                        <label>Общий лимит по карте</label><input type='text' name='CRCARDLIMITSUM' value='{$Cred->CRCARDLIMITSUM}' autocomplete='off'>
                                        <label>Израсходованный лимит</label><input type='text' name='CRCARDUSEDSUM' value='{$Cred->CRCARDUSEDSUM}' autocomplete='off'>
                                        <label>Минимальный платёж</label><input type='text' name='CRCARDMINPAY' value='{$Cred->CRCARDMINPAY}' autocomplete='off'>
                                    </p>
                                    <button type='submit' class='btn btn-warning' id='btnSaveMain'>Сохранить основную информацию</button>       
                                </form>    
                                <div class='row'>
                                    <div class='col-lg-5'>
                                        
                                    </div>                                
                                    <div class='col-lg-2'>");                                            
                                    if (((new CheckRole)->Check($_SESSION['EmRole'],'ATContP1AnketaCtrl','DelCred')) or ($_SESSION['EmName']=='Максим Малиновский')){    
                                        echo("<a href='index_admin.php?controller=ATContP1AnketaCtrl&action=DelCred&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}&CrCode={$Cred->CRCODE}'>
                                            <button class='btn btn-danger'>Удалить</button></a>");
                                    }
                                echo("</div>                                    
                                </div>
                            </div><!--основная инф по кредиту-->
                            <div class='tab-pane fade' id='credadd{$Cred->CRCODE}'>
                                <form method='get' autocomplete='off'>");
                                (new MyForm('ATContP1AnketaCtrl','UpdCredAdd',$_GET['ClCode'],$_GET['ContCode']))->AddForm();
                                echo("
                                    <input type='hidden' name='CRCODE' value='{$Cred->CRCODE}'>
                                    <p>
                                    <label>Цель кредита</label><select type='text' name='CRREASON''>
                                        <option value='$Cred->CRREASON'>{$Cred->CRREASON}</option>
                                        <option value='приобретение товаров и услуг'>приобретение товаров и услуг</option>
                                        <option value='покупка транспортного средства'>покупка транспортного средства</option>
                                        <option value='ремонт и отделка'>ремонт и отделка</option>
                                        <option value='туристическая поездка'>туристическая поездка</option>
                                        <option value='оплата учёбы'>оплата учёбы</option>
                                        <option value='лечение'>лечение</option>
                                        <option value='похороны'>похороны</option>
                                        <option value='иное'>иное</option>
                                        <option value='погашение действующих кредитов'>погашение действующих кредитов</option>
                                        <option value='займ родственникам'>займ родственникам</option>                                        
                                        <option value='бизнес'>бизнес</option>
                                        <option value='мошенники'>мошенники</option>
                                        <option value='иное'>иное</option>
                                    </select>
                                    <label>Описание цели</label><input type='text' name='CRREASONCOMMENT' value='{$Cred->CRREASONCOMMENT}'>
                                    </p>
                                    <p>
                                    <label>Есть ли документы по кредиту</label><select type='text' name='CRCONTDOCSYN'>
                                        <option value='$Cred->CRCONTDOCSYN'>{$Cred->CRCONTDOCSYN}</option>
                                        <option value='да'>да</option>
                                        <option value='нет'>нет</option>
                                    </select>
                                    <label>Есть ли поручитель</label><select type='text' name='CRWARRANTYN'>
                                        <option value='$Cred->CRWARRANTYN'>{$Cred->CRWARRANTYN}</option>
                                        <option value='да'>да</option>
                                        <option value='нет'>нет</option>
                                    </select>
                                    <label>ФИО поручителя</label><input type='text' name='CRWARRANTNAME' value='{$Cred->CRWARRANTNAME}'>                                        
                                    <label>Кодовое слово</label><input type='text' name='CRCODEWORD' value='{$Cred->CRCODEWORD}'>    
                                    </p>
                                    <p>    
                                    <label>Место работы на момент получения</label><input type='text' name='CRWORKORG' value='{$Cred->CRWORKORG}'>
                                    <label>Место работы в анкете соответствовало реальному</label><select type='text' name='CRCONTWORKREALYN'>
                                        <option value='$Cred->CRCONTWORKREALYN'>{$Cred->CRCONTWORKREALYN}</option>
                                        <option value='да'>да</option>
                                        <option value='нет'>нет</option>
                                    </select>
                                    </p>
                                    <p>
                                    <label>Чем был подтверждён доход</label><select type='text' name='CRINCOMEDOC'>
                                        <option value='$Cred->CRINCOMEDOC'>{$Cred->CRINCOMEDOC}</option>
                                        <option value='справка 2 НДФЛ'>справка 2 НДФЛ</option>
                                        <option value='справка по форме банка'>справка по форме банка</option>
                                        <option value='справка из ПФР'>справка из ПФР</option>
                                        <option value='декларация'>декларация</option>
                                        <option value='не подтверждался'>не подтверждался</option>
                                    </select>
                                    <label>Официальный доход</label><input type='text' name='CRINCOMEOFSUM' value='{$Cred->CRINCOMEOFSUM}'>
                                    <label>Фактический доход</label><input type='text' name='CRINCOMEREALSUM' value='{$Cred->CRINCOMEREALSUM}'>    
                                    </p>
                                    <p>
                                    <label>Вид судебного решения</label><select name='CRCOURTDESTYPE'>
                                        <option value='$Cred->CRCOURTDESTYPE'>$Cred->CRCOURTDESTYPE</option>
                                        <option value='судебный приказ'>судебный приказ</option>
                                        <option value='судебное решение'>судебное решение</option>
                                        <option valuue='исполпроизводство'>исполпроизводство</option>
                                    </select>
                                    <label>Дата</label><input type='date' name='CRCOURTDESDATE' value='{$Cred->CRCOURTDESDATE}'>
                                    </p>
                                    <p>
                                    <label>Наличие залога</label><select name='CRPLEDGEYN'>
                                        <option value='$Cred->CRPLEDGEYN'>$Cred->CRPLEDGEYN</option>
                                        <option value='да'>да</option>
                                        <option value='нет'>нет</option>                                        
                                    </select>
                                    <label>Какое имущество в залоге</label><input type='text' name='CRPLEDGE' value='{$Cred->CRPLEDGE}'>
                                    </p>
                                    <p>
                                    <label>Коллектор по агентскому договору</label><select name='CRCOLLAGYN'>
                                        <option value='$Cred->CRCOLLAGYN'>$Cred->CRCOLLAGYN</option>
                                        <option value='да'>да</option>
                                        <option value='нет'>нет</option>                                        
                                    </select>
                                    <label>Коллекторское агентство</label><input type='text' name='CRCOLLAGNAME' value='{$Cred->CRCOLLAGNAME}'>
                                    </p>
                                    <button type='submit' class='btn btn-warning'>Сохранить доп информацию</button>
                                </form>
                                <div class='row'>
                                    <div class='col-lg-4'>
                                        
                                    </div>                                
                                    <div class='col-lg-2'>");                                                                                
                                    echo("<a href='index_admin.php?controller=ATContP1AnketaCtrl&action=CopyCred&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}&CrCode={$Cred->CRCODE}'>
                                        <button class='btn btn-secondary'>Копировать кред договор</button></a>");                                    
                                echo("</div>                                    
                                </div>

                            </div><!--дополнительная инф по кредиту-->
                            <div class='tab-pane fade' id='creddocs{$Cred->CRCODE}'>
                                <form method='get' autocomplete='off'>");
                                    (new MyForm('ATContP1AnketaCtrl','NewCredDoc',$_GET['ClCode'],$_GET['ContCode']))->AddForm();
                                    echo("<input type='hidden' name='CRCODE' value='{$Cred->CRCODE}'>
                                    <label>Документ</label><input type='text' name='CRDOCNAME' value=''>
                                    <label>Сколько страниц</label><input type='text' name='CRDOCPAGES' value=''>
                                    <label>Номер документа</label><input type='text' name='CRDOCNUM' value=''>
                                    <label>Дата</label><input type='text' name='CRDOCDATE' value=''>
                                    <button type='submit' class='btn btn-warning btn-sm'>Сохранить</button>
                                </form>
                                <table class='table table-hover'>
                                    <thead>
                                        <tr>
                                            <th>Название</th>
                                            <th>Число страниц</th>
                                            <th>Номер документа</th>
                                            <th>Дата</th>
                                            <th>Удаление</th>
                                        </tr>
                                    </thead>
                                    <tbody>");
                                        foreach($CredDocList[$Cred->CRCODE] as $Doc){
                                            echo("<tr class='table-secondary'><form method='get'>");
                                            (new MyForm('ATContP1AnketaCtrl','DelCredDoc',$_GET['ClCode'],$_GET['ContCode']))->AddForm();
                                            echo("<input type='hidden' name='CrDocId' value='$Doc->ID'>");                                            
                                            echo("<td>{$Doc->CRDOCNAME}</td>");
                                            echo("<td>{$Doc->CRDOCPAGES}</td>");
                                            echo("<td>{$Doc->CRDOCNUM}</td>");
                                            echo("<td>{$Doc->CRDOCDATE}</td>");
                                            if ((new CheckRole)->Check($_SESSION['EmRole'],'ATContP1AnketaCtrl','DelCredDoc')){
                                                echo("<td><button class='btn btn-danger'>УДАЛИТЬ</button></td>");
                                            }
                                            echo("</form></tr>");
                                        }    
                                        echo("
                                    </tbody>
                                </table>
                            </div><!--документы по кредиту-->
                        </div> 
                    </div>
                </div>
                ");
                            
            }
        ?>
    </div>
    
    <script src="./js/p1anketa.js"></script>  
</body>
</html>

