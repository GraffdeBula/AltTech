<?php
$ClientName=$args['client']->CLFNAME." ".$args['client']->CL1NAME." ".$args['client']->CL2NAME;
$Document=$args['docname'];
#var_dump($args['docname']);
?>
<!DOCTYPE html>
<html>    
    <body>
        
        <a href="/AltTech/<?=$Document?>"><button class="btn btn-success">СКАЧАТЬ ДОГОВОР <?=$ClientName?></button></a>
        
    </body>
</html>
