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
        
        function getSetList(){
            var req2=new XMLHttpRequest();
            req2.open('GET','index_admin.php?controller=AsynchTestCtrl&action=GetSetList',true);
            req2.onload = function(){
                var SetList=JSON.parse(this.responseText);
                output='';
                for (var i in SetList ){
                    
                    output+="<ul>"+
                        "<li>ID: "+SetList[i].ID+"<button onclick=DelSetting("+SetList[i].ID+") class='btn btn-danger btnDel')>X</button>  </li>"+
                        "<li>ID: "+SetList[i].SETCOMMENT+"</li>"+
                        "<li>ID: "+SetList[i].SETVALUE+"</li>"+
                        "</ul>";
                                                           
                }
                DivSetList.innerHTML=output;
            }
            req2.send();
        }

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
            console.log('Add1Done');
        });
//        
//        SetButton2.addEventListener('click',function(){ 
//            event.preventDefault();
//            console.log(SetComment.value);
//            console.log(SetValue.value);
//            var req= new XMLHttpRequest();
//            req.open('GET','index_admin.php?controller=AsynchTestCtrl&action=Save2&SetComment='+SetComment.value+'&SetValue='+SetValue.value,true);
//            req.send();
//            getSetList();
//            console.log('Add2Done');
//        });
        
//        function DelSetting(DelId){             
//            console.log(DelId);
//            console.log(SetValue.value);
//            var req1= new XMLHttpRequest();
//            req1.open('GET','index_admin.php?controller=AsynchTestCtrl&action=Del&Id='+DelId,true);
//            req1.send();
//            setTimeout(getSetList(),1000);
//            
//            console.log('DelDone');
//        }
//        
//        function getSetList(){
//            var req2=new XMLHttpRequest();
//            req2.open('GET','index_admin.php?controller=AsynchTestCtrl&action=GetSetList',true);
//            req2.onload = function(){
//                var SetList=JSON.parse(this.responseText);
//                output='';
//                for (var i in SetList ){
//                    
//                    output+="<ul>"+
//                        "<li>ID: "+SetList[i].ID+"<button onclick=DelSetting("+SetList[i].ID+") class='btn btn-danger btnDel')>X</button>  </li>"+
//                        "<li>ID: "+SetList[i].SETCOMMENT+"</li>"+
//                        "<li>ID: "+SetList[i].SETVALUE+"</li>"+
//                        "</ul>";
//                                                           
//                }
//                DivSetList.innerHTML=output;
//            }
//            req2.send();
//        }
        
        
        
    </script>
</html>
