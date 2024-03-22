<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Отчёт по действующим договорам</title>       
    </head>
    <body>        
        <?php
            foreach($BranchList as $Branch){             
//                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.06.2023&DateL=30.06.2023'>"
//                    . "<button class='btn btn-success'>{$Branch->BRNAME} - июнь 2023</button></a> - ");
//                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.07.2023&DateL=31.07.2023'>"
//                    . "<button class='btn btn-success'>{$Branch->BRNAME} - июль 2023</button></a> - ");
//                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.08.2023&DateL=31.08.2023'>"
//                    . "<button class='btn btn-success'>{$Branch->BRNAME} - август 2023</button></a>");    
//                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.09.2023&DateL=30.09.2023'>"
//                    . "<button class='btn btn-warning'>{$Branch->BRNAME} - сентябрь 2023</button></a>"); 
//                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.10.2023&DateL=31.10.2023'>"
//                    . "<button class='btn btn-danger'>{$Branch->BRNAME} - октябрь 2023</button></a>"); 
//                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.11.2023&DateL=30.11.2023'>"
//                    . "<button class='btn btn-info'>{$Branch->BRNAME} - ноябрь 2023</button></a>"); 
//                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.12.2023&DateL=31.12.2023'>"
//                    . "<button class='btn btn-success'>{$Branch->BRNAME} - декабрь 2023</button></a>");    
//                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.01.2024&DateL=31.01.2024'>"
//                    . "<button class='btn btn-warning'>{$Branch->BRNAME} - январь 2024</button></a>"); 
                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.02.2024&DateL=29.02.2024'>"
                    . "<button class='btn btn-danger'>{$Branch->BRNAME} - февраль 2024</button></a>");
                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.03.2024&DateL=31.03.2024'>"
                    . "<button class='btn btn-info'>{$Branch->BRNAME} - март 2024</button></a>"); 
                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.04.2024&DateL=30.04.2024'>"
                    . "<button class='btn btn-success'>{$Branch->BRNAME} - апрель 2024</button></a>"); 
                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.05.2024&DateL=31.05.2024'>"
                    . "<button class='btn btn-primary'>{$Branch->BRNAME} - май 2024</button></a>"); 
                echo("</p>");
            }
        ?>        
    </body>
</html>
