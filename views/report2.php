<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>ДВИЖЕНИЕ СРЕДСТВ НА ХРАНЕНИИ</title>
        <link  href='/AltTech/css/css-framework.css' rel='stylesheet'>
        <link  href='/AltTech/css/css-my.css' rel='stylesheet'>
    </head>
    <body>
        <div class="g">
            <div class="g-row">
                <a href="/AltTech/index_admin.php"><button class="f-bu f-bu-warning">НАЗАД</button></a>
            </div>
            <div class="g-row">
                <a href="/AltTech/downloads/reptotal2.xlsx"><button class="f-bu f-bu-success">ВЫГРУЗИТЬ В EXCEL</button></a>
            </div>    
            <div class="g-row">
                <form method="get">
                    <input type="hidden" name="repInd" value="rep2">
                    <?php
                        echo("<label>Дата начала</label>");
                        echo("<input type='date' name='repDat1' value={$repDat1} id='date1'>");
                        echo("<input type='hidden' name='controller' value='report1_ctrl'>");
                        echo("<label>Дата окончания</label>");
                        echo("<input type='date' name='repDat2' value={$repDat2} id='date2'>");
                    ?>
                    <button class="f-bu f-bu-default" type="submit">ОБНОВИТЬ</button>
                </form>
            </div>
            <table>
                <caption>СВОДНЫЙ ОТЧЁТ ПО КОМПАНИИ</caption>
                <tr>
                    <th>ФИЛИАЛ</th>
                    <th>ВНЕСЕНО</th>
                    <th>ВЫДАНО</th>
                    
                </tr>
                <?php
                foreach($rep as $branch){
                    echo("<tr>");
                    echo("<form method='get'>");
                    echo("<input type='hidden' name='brInd' value='{$branch->BRNAME}'>");
                    echo("<input type='hidden' name='controller' value='report1_ctrl'>");
                    echo("<input type='hidden' name='repInd' value='rep2'>");
                    echo("<input type='hidden' name='repDat1' value={$repDat1} id='repDat1'>");
                    echo("<input type='hidden' name='repDat2' value={$repDat2} id='repDat2'>");
                    echo("<td width=250px'><button class='f-bu f-bu-default'>{$branch->BRNAME}</button></td>");
                    echo("</form>");
                    echo("<td>{$branch->BRSUM1}</td>");
                    echo("<td>{$branch->BRSUM2}</td>");                    
                    echo("</tr>");
                }
                ?>
            </table>
            
        </div>
        <script>
            const fdatInput=document.querySelector('#date1');            
            const inp1=document.querySelectorAll('#repDat1');            
            fdatInput.addEventListener('input',function(e){                
                inp1.forEach(function(inpDat){
                    inpDat.value=fdatInput.value;
                })
            });
            
            const ldatInput=document.querySelector('#date2');            
            const inp2=document.querySelectorAll('#repDat2');            
            ldatInput.addEventListener('input',function(e){                
                inp2.forEach(function(inpDat){
                    inpDat.value=ldatInput.value;
                })
            });
                                    
        </script>
    </body>
</html>
