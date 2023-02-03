<?php?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">        
    </head>
    <body>
        <p>
            <a href="index_admin.php?controller=AdminMainController"><button class="btn btn-outline-secondary">На главную</button></a>
            <h4>Закладки документов</h4>
        </p>          
        <form method='get'>
            <div>
                <?php
                    (new MyForm('ATDRCtrl','BookmarkAdd'))->AddForm2();
                ?>
                <p>
                <label for='in1'>Документ</label><input type='text' id='in1' name='BMDOCNAME' value='' autocomplete="off">               
                <label for='in2'>Закладка</label><input type='text' id='in2' name='BMNAME' value='' autocomplete="off">
                <label for='in3'>Модель</label><input type='text' id='in3' name='BMTABLE' value='' autocomplete="off">
                <label for='in4'>Поле</label><input type='text' id='in4' name='BMFIELD' value='' autocomplete="off">
                </p>
                <p>
                <label for='in5'>Тип данных</label><input type='text' id='in5' name='BMTYPE' value='' autocomplete="off">               
                <label for='in6'>Тип преобразования</label><input type='text' id='in6' name='BMCHANGE' value='' autocomplete="off">
                <label for='in7'>Поле для сравнения</label><input type='text' id='in7' name='BMCHECKDATA' value='' autocomplete="off">
                <label for='in8'>Значение для вставки при сравнении</label><input type='text' id='in8' name='BMINSDATA' value='' autocomplete="off">
                </p>                                
                <button class="btn btn-success">ДОБАВИТЬ</button>
            </div>        
            
        </form>
        <a href="index_admin.php?controller=ATDRCtrl&action=CopyBM"><button>копировать</button></a>
        <div>
            <table class='table table-hover'>
                <thead>
                    <tr>
                        <th scope="col">Код</th>
                        <th scope="col">Документ</th>
                        <th scope="col">BmName</th>
                        <th scope="col">Модель</th>
                        <th scope="col">Поле</th>
                        <th scope="col">Тип данных</th>
                        <th scope="col">Тип преобразования</th>
                        <th scope="col">Поле для сравнения</th>
                        <th scope="col">Значение для вставки при сравнении</th>
                        <th scope="col">delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach($BmList as $Bm){
                        echo("<tr class='table-secondary'>");
                        echo("<td width=50px>{$Bm->ID}</td>");
                        echo("<td width=70px>{$Bm->BMDOCNAME}</td>");
                        echo("<td width=70px>{$Bm->BMNAME}</td>");
                        echo("<td width=70px>{$Bm->BMTABLE}</td>");
                        echo("<td width=70px>{$Bm->BMFIELD}</td>");
                        echo("<td width=70px>{$Bm->BMTYPE}</td>");
                        echo("<td width=70px>{$Bm->BMCHANGE}</td>");
                        echo("<td width=70px>{$Bm->BMCHECKDATA}</td>");
                        echo("<td width=70px>{$Bm->BMINSDATA}</td>"); 
                        echo("<td width=50px><form>");
                        (new MyForm('ATDRCtrl','BookmarkDel'))->AddForm2();
                        echo("<input type='hidden' name=BmID value={$Bm->ID}>");
                        echo("<button class='btn btn-danger'>delete</button>");
                        echo("</form></td>");
                        echo("</tr>");
                    }
                ?>
                </tbody>    
            </table>
        </div>
            
    </body>
</html>
