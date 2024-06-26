/* 
 * скрипт для обработки поведения пользователя на странице "TarifCalc"
 * функции:
 * вывод списка элементов тарифа на страницу
 * подсчёт тарифа по чеклисту
 */

var TarSum=0; 

var List1=document.getElementById('TarifList1');
var List2=document.getElementById('TarifList2');
var List3=document.getElementById('TarifList3');

formList1();
formList2();
formList3();

function getSum(CheckedSum,CheckId,SumType){
    var TarSum=document.getElementById('TarifSum');
    var CB=document.getElementById(CheckId);
    
    if (CB.checked==true){
        TarSum.value=Number(TarSum.value)+CheckedSum*SumType;
    } else {
        TarSum.value=Number(TarSum.value)-CheckedSum*SumType;
    }    
}

function formList1(){
    var TarListReq=new XMLHttpRequest();
    TarListReq.open('GET','index_admin.php?controller=TarifCalcCtrl&action=GetTarifList1',true);
    TarListReq.onload = function(){
        var TarList=JSON.parse(this.responseText);
        
        var output='';
        for (var i in TarList ){

            output+="<div class='form-check'>"+
                "<input class='form-check-input' type='checkbox' value='"+i+"' id='"+TarList[i].ID+"' onchange='getSum("+TarList[i].TRELSUM+","+TarList[i].ID+",1)'>"+
                "<label class='form-check-label' for='"+TarList[i].ID+"'>"+TarList[i].TRELNAME +"===="+ TarList[i].TRELSUM +"рублей</label>"+
                "</div>";
        }
        console.log(output);
        List1.innerHTML=output;
    }
    TarListReq.send();    
}

function formList2(){
    var TarListReq=new XMLHttpRequest();
    TarListReq.open('GET','index_admin.php?controller=TarifCalcCtrl&action=GetTarifList2',true);
    TarListReq.onload = function(){
        var TarList=JSON.parse(this.responseText);
        
        var output='';
        for (var i in TarList ){

            output+="<div class='form-check'>"+
                "<input class='form-check-input' type='checkbox' value='"+i+"' id='"+TarList[i].ID+"' onchange='getSum("+TarList[i].TRELSUM+","+TarList[i].ID+",-1)'>"+
                "<label class='form-check-label' for='"+TarList[i].ID+"'>"+TarList[i].TRELNAME +"===="+ TarList[i].TRELSUM +"рублей</label>"+
                "</div>";
        }
        console.log(output);
        List2.innerHTML=output;
    }
    TarListReq.send();    
}

function formList3(){
    var TarListReq=new XMLHttpRequest();
    TarListReq.open('GET','index_admin.php?controller=TarifCalcCtrl&action=GetTarifList3',true);
    TarListReq.onload = function(){
        var TarList=JSON.parse(this.responseText);
        
        var output='';
        for (var i in TarList ){

            output+="<div class='form-check'>"+
                "<input class='form-check-input' type='checkbox' value='"+i+"' id='"+TarList[i].ID+"' onchange='getSum("+TarList[i].TRELSUM+","+TarList[i].ID+",-1)'>"+
                "<label class='form-check-label' for='"+TarList[i].ID+"'>"+TarList[i].TRELNAME +"===="+ TarList[i].TRELSUM +"рублей</label>"+
                "</div>";
        }
        console.log(output);
        List3.innerHTML=output;
    }
    TarListReq.send();    
}

function getTarifList(){
    var TarListReq=new XMLHttpRequest();
    TarListReq.open('GET','index_admin.php?controller=TarifCalcCtrl&action=GetTarifList',true);
    TarListReq.onload = function(){
        var TarList1=JSON.parse(this.responseText);
        
        var output='';
        for (var i in TarList ){

            output+="<div class='form-check'>"+
                "<input class='form-check-input' type='checkbox' value='"+i+"' id='"+TarList[i].ID+"' onchange='getSum("+TarList[i].TRELSUM+","+TarList[i].ID+")'>"+
                "<label class='form-check-label' for='"+TarList[i].ID+"'>"+TarList[i].TRELNAME +"===="+ TarList[i].TRELSUM +"рублей</label>"+
                "</div>";
        }
        console.log(output);
        DivTarList.innerHTML=output;
    }
    TarListReq.send();    
}