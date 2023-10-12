<?php
/*
 * тест показа json
 *  */

?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <?php
        
        #echo($_SERVER['DOCUMENT_ROOT']);
        echo("<form method='get' autocomplete='off' action='index_admin.php?controller=AsynchTestCtrl&action=Save'>");
        
        #(new MyForm('AsynchTestCtrl','Save',0,0))->AddForm2();
        
        echo("SetComment<input id='SetComment' name='SetComment' type='text' value='NewComment'>SetValue<input id='SetValue' name='SetValue' type='text' value='NewValue'><br>");
        echo("<button id ='SetButton' class='btn btn-success'>ADD</button>");
        echo("</form>");
    ?>
</body>

    <script>
        var SetComment=document.getElementById('SetComment');
        var SetValue=document.getElementById('SetValue');
        var SetButton=document.getElementById('SetButton');
        
        SetButton.addEventListener('click',function(){ 
            event.preventDefault();
            console.log(SetComment.value);
            console.log(SetValue.value);
            var req= new XMLHttpRequest();
            req.open('GET','index_admin.php?controller=AsynchTestCtrl&action=Save&SetComment='+SetComment.value+'&SetValue='+SetValue.value,true);
            req.send();
        });
        
    </script>
</html>
