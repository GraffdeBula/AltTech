<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Отчёт по действующим договорам</title>       
    </head>
    <body>        
        <?php
            foreach($BranchList as $Branch){  
                echo("<p>");

                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.12.2024&DateL=31.12.2024'>"
                    . "<button class='btn btn-success'>{$Branch->BRNAME} - декабрь 2024</button></a>");    
                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.01.2025&DateL=31.01.2025'>"
                    . "<button class='btn btn-warning'>{$Branch->BRNAME} - январь 2025</button></a>"); 
                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.02.2025&DateL=28.02.2025'>"
                    . "<button class='btn btn-danger'>{$Branch->BRNAME} - февраль 2025</button></a>");
                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.03.2025&DateL=31.03.2025'>"
                    . "<button class='btn btn-info'>{$Branch->BRNAME} - март 2025</button></a>"); 
                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.04.2025&DateL=30.04.2025'>"
                    . "<button class='btn btn-success'>{$Branch->BRNAME} - апрель 2025</button></a>"); 
                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.05.2025&DateL=31.05.2025'>"
                    . "<button class='btn btn-primary'>{$Branch->BRNAME} - май 2025</button></a>"); 
                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.06.2025&DateL=30.06.2025'>"
                    . "<button class='btn btn-info'>{$Branch->BRNAME} - июнь 2025</button></a>");
                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.07.2025&DateL=31.07.2025'>"
                    . "<button class='btn btn-success'>{$Branch->BRNAME} - июль 2025</button></a>");
                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.08.2025&DateL=31.08.2025'>"
                    . "<button class='btn btn-primary'>{$Branch->BRNAME} - август 2025</button></a>");    
                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.09.2025&DateL=30.09.2025'>"
                    . "<button class='btn btn-warning'>{$Branch->BRNAME} - сентябрь 2025</button></a>"); 
                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.10.2025&DateL=31.10.2025'>"
                    . "<button class='btn btn-danger'>{$Branch->BRNAME} - октябрь 2025</button></a>"); 
                echo("<a target='_blank' href='index_admin.php?controller=CurBasePlanCtrl&action=ShowBrBase&BrName={$Branch->BRNAME}&DateF=01.11.2025&DateL=30.11.2025'>"
                    . "<button class='btn btn-info'>{$Branch->BRNAME} - ноябрь 2025</button></a>"); 
                echo("</p>");
            }
        ?>        
    </body>
</html>
