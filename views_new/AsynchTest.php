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
        #echo("<form method='get' autocomplete='off' action='index_admin.php?controller=AsynchTestCtrl&action=Save'>");
        
        #(new MyForm('AsynchTestCtrl','Save',0,0))->AddForm2();
        
        echo("SetComment<input id='SetComment' name='SetComment' type='text' value='NewComment'>SetValue<input id='SetValue' name='SetValue' type='text' value='NewValue'><br>");
        echo("<button id ='SetButton1' class='btn btn-success'>ADD1</button>");
        echo("<button id ='SetButton2' class='btn btn-warning'>ADD2</button>");
        #echo("</form>");
                        
    ?>
    <div class='SetList'>
        
    </div>
</body>

    <script>
        var SetComment=document.getElementById('SetComment');
        var SetValue=document.getElementById('SetValue');
        var SetButton1=document.getElementById('SetButton1');
        var SetButton2=document.getElementById('SetButton2');
        var DivSetList=document.getElementById('SetList');
        
        SetButton1.addEventListener('click',function(){ 
            event.preventDefault();
            console.log(SetComment.value);
            console.log(SetValue.value);
            var req= new XMLHttpRequest();
            req.open('GET','index_admin.php?controller=AsynchTestCtrl&action=Save1&SetComment='+SetComment.value+'&SetValue='+SetValue.value,true);
            req.send();
            getSetList();
        });
        
        SetButton2.addEventListener('click',function(){ 
            event.preventDefault();
            console.log(SetComment.value);
            console.log(SetValue.value);
            var req= new XMLHttpRequest();
            req.open('GET','index_admin.php?controller=AsynchTestCtrl&action=Save1&SetComment='+SetComment.value+'&SetValue='+SetValue.value,true);
            req.send();
            getSetList();
        });
        
        function getSetList(){
            var req=new XMLHttpRequest();
            req.open('GET','index_admin.php?controller=AsynchTestCtrl&action=GetSetList',true);
            req.onload = function(){
                var SetList=JSON.parse(this.responseText);
                DivSetList.innerHTML='<p>'+this.responseText+'</p>';
//                
//                var output=SetList;
//                DivSetList.innerHTML='<p>'+output+'</p>';
            }
            req.send();
        }
        
    </script>
</html>
