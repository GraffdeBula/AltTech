<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Отчёт по действующим договорам</title>       
    </head>
    <body>        
        <a href='index_admin.php?controller=ATPaysCtrl&action=TestRep'><button class='btn btn-primary'>ЗАГРУЗИТЬ</button></a> 
        <a href='index_admin.php?controller=ATPaysCtrl&action=ShowDate'><button class='btn btn-primary'>ShowDate</button></a> 
        <table class="table table-hover">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($Report as $Row)
                    echo("<tr>"
                    . "<td>$Row->CLCODE</td>"
                    . "<td>$Row->CONTCODE</td>"
                    . "<td>$Row->CLFNAME</td>"
                    . "<td>$Row->CL1NAME</td>"
                    . "<td>$Row->CL2NAME</td>"
                    . "<td>$Row->CONTDAT</td>"
                    . "<td>$Row->CONTOFFICE</td>"
                    . "<td>$Row->CONTPROG</td>"
                    . "<td>$Row->CONTTARIF</td>"
                    . "<td>$Row->CONTSUM1</td>"
                    . "</tr>");
                ?>                
            </tbody>
        </table>
    </body>
</html>
