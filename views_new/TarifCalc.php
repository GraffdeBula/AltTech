<?php
/*
 * калькулятор ед тарифа
 *  */

?>
<!DOCTYPE html>
<html>

<body>
    <h1>Калькулятор</h1>
        <div>    
            <div class="form-check">
        <input class="form-check-input" type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
        <label class="form-check-label" for="optionsRadios2">
          Option two can be something else and selecting it will deselect option one
        </label>
      </div>
            <?php
                foreach($TarifList as $Element){
                    echo("div class='form-check'");
                    echo("<input class='form-check-input' type='checkbox' name='optionsRadios' id='$Element->ID' value='$Element->TRELNAME'>");
                    echo("<label class='form-check-label' for='$Element->ID'>$Element->TRELNAME</label>");
                    echo($Element->TRELSUM."<br>");
                }

            ?>                        
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
            alert('Add1 finish');
        });
        
        SetButton2.addEventListener('click',function(){ 
            event.preventDefault();
            console.log(SetComment.value);
            console.log(SetValue.value);
            var req= new XMLHttpRequest();
            req.open('GET','index_admin.php?controller=AsynchTestCtrl&action=Save2&SetComment='+SetComment.value+'&SetValue='+SetValue.value,true);
            req.send();
            getSetList();
            console.log('Add2Done');
            alert('Add2 finish');
        });
        
        function DelSetting(DelId){             
            console.log(DelId);
            console.log(SetValue.value);
            var req1= new XMLHttpRequest();
            req1.open('GET','index_admin.php?controller=AsynchTestCtrl&action=Del&Id='+DelId,true);
            req1.send();
            setTimeout(getSetList(),1000);
            
            console.log('DelDone');
            alert('Delete finish');
        }
               
        
    </script>
</html>
