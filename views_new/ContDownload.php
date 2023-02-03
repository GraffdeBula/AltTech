<?php
$ClientName=$args['client']->CLFNAME." ".$args['client']->CL1NAME." ".$args['client']->CL2NAME;
$Document=$args['docname'];
?>
<!DOCTYPE html>
<html>    
    <body>

                    <a href="/AltTech/documents/<?=$Document[0]?>"><button class="btn btn-success">СКАЧАТЬ ДОГОВОР <?=$ClientName?></button></a>

                    <a href="/AltTech/<?=$Document[1]?>"><button class="btn btn-info">СКАЧАТЬ АНКЕТУ <?=$ClientName?></button></a>

                    <a href="/AltTech/<?=$Document[2]?>"><button class="btn btn-success">СКАЧАТЬ ПРИЛОЖЕНИЕ 4 <?=$ClientName?></button></a>

    </body>
</html>
