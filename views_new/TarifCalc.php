<?php
/*
 * калькулятор ед тарифа
 *  */

?>
<!DOCTYPE html>
<html>

<body>
    <h1>Калькулятор</h1>
        <div id="TarifList">    
            
            
        </div>                  
    
</body>
    <script>
        var MyCB=document.querySelector('.form-check-input');        
        
        MyCB.addEventListener('change',function(){             
            console.log('DelId');
            
        })
               
        
    </script>
</html>

<?php
                foreach($TarifList as $Element){
                    echo("<div class='form-check'>");
                    echo("<input class='form-check-input' type='checkbox' value='$Element->TRELSUM' id='$Element->ID' >");
                    echo("<label class='form-check-label' for='$Element->ID'>$Element->TRELNAME  --  $Element->TRELSUM  рублей</label>");
                    echo("</div>");
                }
            ?>                