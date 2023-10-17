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
        
                
        echo("SetComment<input id='SetComment' name='SetComment' type='text' value='NewComment'>SetValue<input id='SetValue' name='SetValue' type='text' value='NewValue'><br>");
        echo("<button id ='SetButton1' class='btn btn-success'>ADD1</button>");
        echo("<button id ='SetButton2' class='btn btn-warning'>ADD2</button>");
        
    ?>
    <div id='SetList'>
        
    </div>
</body>
    <script>
        var DivSetList=document.getElementById('SetList');
        getSetList();
        
        var SetComment=document.getElementById('SetComment');
        var SetValue=document.getElementById('SetValue');
        var SetButton1=document.getElementById('SetButton1');
        var SetButton2=document.getElementById('SetButton2');
             
                
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
                output='';
                for (var i in SetList ){
                    
                output+='<ul>'+
                        '<li>ID: '+SetList[i].ID+'<button id="DelBtn'+SetList[i].ID+'" class="btn btn-danger" onclick=DelSetting('+SetList[i]+')>X</button>  </li>'+
                        '<li>ID: '+SetList[i].SETCOMMENT+'</li>'+
                        '<li>ID: '+SetList[i].SETVALUE+'</li>'+
                        '</ul>';
                }
                DivSetList.innerHTML=output;
            }
            req.send();
        }
        
        function DelSetting(DelId){ 
            event.preventDefault();
            console.log(SetComment.value);
            console.log(SetValue.value);
            var req= new XMLHttpRequest();
            req.open('GET','index_admin.php?controller=AsynchTestCtrl&action=Del&Id='+DelId,true);
            req.send();
            getSetList();
        }
        
    </script>
</html>
