/* 
 * скрипт для обработки поведения пользователя на странице "TarifCalc"
 * функции:
 * вывод списка элементов тарифа на страницу
 * подсчёт тарифа по чеклисту
 */

var TarSum=0; 

var List0=document.getElementById('TarifList0');
var List1=document.getElementById('TarifList1');
var List2=document.getElementById('TarifList2');
var List3=document.getElementById('TarifList3');

formList0();
//formList1();
formList2();
formList3();


function CountAnnPay(){
    var AnnNum=document.getElementById('AnnNum').value;
    var TarSum=document.getElementById('TarifSum').value;
    var AnnPay=document.getElementById('AnnPay');
    AnnPay.value=Math.round((TarSum-9000)/AnnNum);
}

function getSum(ListNum,CheckedSum,CheckId,SumType){
    var TarSum=document.getElementById('TarifSum');
    var CB=document.getElementById(CheckId);
    
    var SumCount=1;
    
    if ((ListNum==1)&&(CheckId!=='01')){           
        SumCount=document.getElementById('count'+CheckId).value; 
        console.log(SumCount);
    }
    
    if ((ListNum==1)&&(CheckId=='01')){           
        SumCount=Math.trunc(document.getElementById('count'+CheckId).value/10); 
        console.log(SumCount);
    }
    
    if (CB.checked==true){
        TarSum.value=Number(TarSum.value)+CheckedSum*SumType*SumCount;
    } else {
        TarSum.value=Number(TarSum.value)-CheckedSum*SumType*SumCount;
    }                
}

function formList0(){
    var TarListReq=new XMLHttpRequest();
    TarListReq.open('GET','index_admin.php?controller=TarifCalcCtrl&action=GetTarifList0',true);
    TarListReq.onload = function(){
        var TarList=JSON.parse(this.responseText);
        
        var output='';
        for (var i in TarList ){

            output+="<div class='form-check'>"+
                "<input class='form-check-input' type='checkbox' value='"+i+"' id='"+TarList[i].ID+"' onchange='getSum(0,"+TarList[i].TRELSUM+","+TarList[i].ID+",1)'>"+
                "<label class='form-check-label' for='"+TarList[i].ID+"'>"+TarList[i].TRELNAME +"    "+ TarList[i].TRELSUM +"рублей</label>"+                
                "</div>";
        }
        console.log(output);
        List0.innerHTML=output;
    }
    TarListReq.send();    
}

function formList1(){
    var TarListReq=new XMLHttpRequest();
    TarListReq.open('GET','index_admin.php?controller=TarifCalcCtrl&action=GetTarifList1',true);
    TarListReq.onload = function(){
        var TarList=JSON.parse(this.responseText);
        
        var output='';
        for (var i in TarList ){

            output+="<div class='form-check'>"+
                "<input class='form-check-input' type='checkbox' value='"+i+"' id='"+TarList[i].ID+"' onchange='getSum(1,"+TarList[i].TRELSUM+","+TarList[i].ID+",1)'>"+
                "<label class='form-check-label' for='"+TarList[i].ID+"'>"+TarList[i].TRELNAME +"    "+ TarList[i].TRELSUM +"рублей</label>"+
                "<input type='number' value=1 id='count"+TarList[i].ID+"'>" +
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
                "<input class='form-check-input' type='checkbox' value='"+i+"' id='"+TarList[i].ID+"' onchange='getSum(2,"+TarList[i].TRELSUM+","+TarList[i].ID+",-1)'>"+
                "<label class='form-check-label' for='"+TarList[i].ID+"'>"+TarList[i].TRELNAME +"    "+ TarList[i].TRELSUM +"рублей</label>"+
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
                "<input class='form-check-input' type='checkbox' value='"+i+"' id='"+TarList[i].ID+"' onchange='getSum(3,"+TarList[i].TRELSUM+","+TarList[i].ID+",-1)'>"+
                "<label class='form-check-label' for='"+TarList[i].ID+"'>"+TarList[i].TRELNAME +"    "+ TarList[i].TRELSUM +"рублей</label>"+
                "</div>";
        }
        console.log(output);
        List3.innerHTML=output;
    }
    TarListReq.send();    
}
