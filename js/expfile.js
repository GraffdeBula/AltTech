/* 
 * скрипт для обработки поведения пользователя на станице "досье ЭПЭ"
 * функции:
 * 1. при выборе (select) риска по ВБФЛ значение переносится в textarea для корретировки
 * 2. сохранение рисков (классика БФЛ) по нажатию галочки
 */

/*Выбор риска ВБФЛ в Select*/
var MySelect=document.getElementById('Risk2Select');
var MyTextArea=document.getElementById('AddRisk2');
var MyVal2=document.getElementById('Risk2Value2');

MySelect.addEventListener('change',function(){    
    MyTextArea.value=MySelect.value;
    MyVal2.value=MySelect.selectedIndex;
    console.log(MySelect.selectedIndex);
});
/* END *Выбор риска ВБФЛ в Select*/

/*сохранение рисков (классика БФЛ) по нажатию галочки*/
function CheckRisk(id){
    var MyCB=document.getElementById('CBR'+id);    
    var MyCode=document.getElementById('ContCode'+id).value;
    var MyName=document.getElementById('RiskName'+id).value;
    var MyCost=document.getElementById('RiskCost'+id).value;
    
    if (MyCB.checked==true){ 
        MyCB.disabled=true;
        var req= new XMLHttpRequest();
        req.open('GET','index_admin.php?controller=ATContP1FileExpertCtrl&action=AddRisk&ContCode='+MyCode+'&RiskVal='+MyName+'&RiskCost='+MyCost,true);
        req.send();        
        console.log('Add1Done');        
    }else{        
        var req= new XMLHttpRequest();
        req.open('GET','index_admin.php?controller=ATContP1FileExpertCtrl&action=DelRisk&ContCode='+MyCode+'&RiskVal='+MyName,true);
        req.send(); 
        console.log('DelDone');        
    }
       
}

/*УТВ *сохранение рисков (классика БФЛ) по нажатию галочки*/
console.log('yes_expfile');