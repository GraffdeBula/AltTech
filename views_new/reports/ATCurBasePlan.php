<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Отчёт по действующим договорам</title>       
    </head>
    <body>        
        <?php
            foreach($BranchList as $Branch){
//                echo("<p><a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.05.2023&DateL=31.05.2023'>"
//                    . "<button class='btn btn-success'>{$Branch->BRNAME} - май 2023</button></a> - ");
//                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.06.2023&DateL=30.06.2023'>"
//                    . "<button class='btn btn-success'>{$Branch->BRNAME} - июнь 2023</button></a> - ");
//                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.07.2023&DateL=31.07.2023'>"
//                    . "<button class='btn btn-success'>{$Branch->BRNAME} - июль 2023</button></a> - ");
                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.08.2023&DateL=31.08.2023'>"
                    . "<button class='btn btn-success'>{$Branch->BRNAME} - август 2023</button></a>");    
                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.09.2023&DateL=30.09.2023'>"
                    . "<button class='btn btn-warning'>{$Branch->BRNAME} - сентябрь 2023</button></a>"); 
                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.10.2023&DateL=31.10.2023'>"
                    . "<button class='btn btn-danger'>{$Branch->BRNAME} - октябрь 2023</button></a>"); 
                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.11.2023&DateL=30.11.2023'>"
                    . "<button class='btn btn-info'>{$Branch->BRNAME} - ноябрь 2023</button></a>"); 
                echo("</p>");
            }
        ?>        
    </body>
</html>