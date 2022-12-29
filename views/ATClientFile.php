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
                    <p>ДОСЬЕ КЛИЕНТА</p>
                </h3>   
            </div>
        </div>
        
        <div class="g-row">
            <div class="g-1">
            </div>
            <div class="g-2">
                <label>Код Клиента</label>
                <?php                
                    echo("<p>{$Client->CLCODE}</p><br>");
                ?>
                <label>ФИО Клиента</label>
                
                    <?php                
                        echo("<p>{$Client->CLFNAME} {$Client->CL1NAME} {$Client->CL2NAME}</p><br>");
                        echo("<a target='_blank' href='index_admin.php?controller=ATClientAnketaCtrl&ClCode={$Client->CLCODE}'><button id='btn1' class='f-bu f-bu-success'>АНКЕТА КЛИЕНТА</button></a><br>");                                                   
                        echo("<form method='get'>");
                        echo("<input type='hidden' name='controller' value='ATClientFileCtrl'><br>");
                        echo("<input type='hidden' name='action' value='ContP1Create'><br>");
                        echo("<input type='hidden' name='ClCode' value='{$Client->CLCODE}'><br>");
                        echo("<label>ID сделки (amoCRM)</label><input type='text'><br>");
                        echo("<button id='btn2' type='submit' class='f-bu f-bu-default'>Добавить договор БФЛ</button><br>");
                        echo("<button id='btn3' class='f-bu'>Добавить договор на другую услугу</button><br>");
                    ?>
                </form>
            </div>
            <div class="g-7">
                <div class='g-row'>
                    <div class="g-7 cont_list">
                        <h2>ДОГОВОРЫ БФЛ</h2>
                        <div class='g-row'><div class='g-1'>ID договора</div><div class='g-1'>дата анкеты</div><div class='g-1'>дата договора</div><div class='g-5'>статус</div></div>
                        <?php  

                        foreach($ContList as $Cont){
                            echo("<div class='g-row'>");
                            echo("<div class='g-1'>".$Cont->CONTCODE."</div><div class='g-1'>".$Cont->AKDAT."</div><div class='g-1'>".$Cont->FRCONTDATE."</div><div class='g-2'>".$Cont->STATUS."</div>");
                            echo("<div class='g-4'>");
                            echo("<a target='_blank' href='index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$Client->CLCODE}&ContCode={$Cont->CONTCODE}'><button class='f-bu f-bu-default'>ДОСЬЕ ДЛЯ МЕНЕДЖЕРА</button></a>");
                            echo("<a target='_blank' href='index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$Client->CLCODE}&ContCode={$Cont->CONTCODE}'><button class='f-bu f-bu-warning'>ДОСЬЕ ДЛЯ ЭКСПЕРТИЗЫ</button></a>");
                            echo("<a target='_blank' href='index_admin.php?controller=ATContP1FileJuristCtrl&ClCode={$Client->CLCODE}&ContCode={$Cont->CONTCODE}'><button class='f-bu f-bu-default'>ДОСЬЕ ДЛЯ ЮРИСТА</button></a>");
                            echo("</div></div>");
                        }
                        ?>
                    </div>
                </div>
                <div class='g-row'>
                    <div class="g-7 cont_list">
                        <h2>ДОГОВОРЫ РАЗОВЫХ УСЛУГ</h2>
                            
                        <?php  

                            foreach($ContList as $Cont){
                            //echo("<p><a target='_blank' href='index_admin.php?controller=ATClientFileCtrl&ClCode={$Cont->CLCODE}'>");
                            //echo("<button class='f-bu f-bu-success'>ДОСЬЕ КЛИЕНТА</button></a>");

                            
                        }
                        ?>
                    </div>
                </div>
                
            </div>
            
        </div>                                                                       
    </div>
    <script src="./js/app3.js"></script>
</body>
</html>
