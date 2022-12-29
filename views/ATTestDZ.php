<?php
/*
 * досье клиента
 *  */
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <div class="g">      
        <div class="g-row">
            <div class='g-12'>
                <h3>
                    <p>АЛЬТ-ТЕХ</p>
                </h3>   
            </div>
        </div>
        <div class="g-row">
            <div class='g-12'>
                <h3>
                    <p>DOCZILLA TEST</p>
                </h3>   
            </div>
        </div>
        
        <div class='g-row'>                                                                      
            <a href="index_admin.php?controller=ATNewDZTest&action=Auth"><button class='f-bu f-bu-success'>АВТОРИЗАЦИЯ</button></a>
            <a href="index_admin.php?controller=ATNewDZTest&action=DocList"><button class='f-bu f-bu-success'>ПОКАЗАТЬ СПИСКОК Документов</button></a>
            <a href="index_admin.php?controller=ATNewDZTest&action=FolderList"><button class='f-bu f-bu-default'>ПОКАЗАТЬ СПИСКОК Каталогов</button></a>
        </div>
        <div class='g-row'>
            <a href="index_admin.php?controller=ATNewDZTest&action=ReadDoc"><button class='f-bu f-bu-success'>Показать документ</button></a>
            <a href="index_admin.php?controller=ATNewDZTest&action=CreateDoc"><button class='f-bu f-bu-default'>Создать Документ</button></a>
            <a href="index_admin.php?controller=ATNewDZTest&action=GetDoc"><button class='f-bu f-bu-warning'>Скачать документ</button></a>
            <a href="index_admin.php?controller=ATNewDZTest&action=CopyDoc"><button class='f-bu f-bu-default'>Копировать документ</button></a>
            <a href="index_admin.php?controller=ATNewDZTest&action=FillDoc"><button class='f-bu f-bu-default'>Заполнить документ</button></a>
        </div>
        <form method='get' autocomplete="off">
            <div class='f-row'>            
                <h4>Получить документ по Id</h4>
                <input type='hidden' name='controller' value='ATNewDZTest' >
                <input type='hidden' name='action' value='GetById'>
                <label>File Id</label><input type='text' value='' name='FileId'>
                <button type='submit'>ПОЛУЧИТЬ</button>
            </div>
        </form>
        <form method='get' autocomplete="off">
            <div class='f-row'>            
                <h4>Скачать документ по Id</h4>
                <input type='hidden' name='controller' value='ATNewDZTest' >
                <input type='hidden' name='action' value='GetDoc'>
                <label>File Id</label><input type='text' value='' name='FileId'>
                <label>Document Id</label><input type='text' value='' name='DocumentId'>
                <button type='submit'>ПОЛУЧИТЬ</button>
            </div>
        </form>
        
    </div>
    <?php
        echo('<br>');
        foreach($List as $key=>$Doc){
            var_dump($Doc);
            echo('<br>=====================================================================================================================<br>');
        }
    ?>
</body>
</html>
