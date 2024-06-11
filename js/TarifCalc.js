/* 
 * скрипт для обработки поведения пользователя на странице "TarifCalc"
 * функции:
 * вывод списка элементов тарифа на страницу
 * подсчёт тарифа по чеклисту
 */

var DivTarList1=document.getElementById('TarifList1');       
var DivTarList2=document.getElementById('TarifList2');
var DivTarList3=document.getElementById('TarifList3');
var TarSum=0;      
getTarifList();

function getTarifList(){
    var TarListReq=new XMLHttpRequest();
    TarListReq.open('GET','index_admin.php?controller=TarifCalcCtrl&action=GetTarifList',true);
    TarListReq.onload = function(){
        var TarList1=JSON.parse(this.responseText);
        
        output='';
        for (var i in TarList ){

            output+="<div class='form-check'>"+
                "<input class='form-check-input' type='checkbox' value='"+i+"' id='"+TarList[i].ID+"' onchange='getSum("+TarList[i].TRELSUM+","+TarList[i].ID+")'>"+
                "<label class='form-check-label' for='"+TarList[i].ID+"'>"+TarList[i].TRELNAME +"===="+ TarList[i].TRELSUM +"рублей</label>"+
                "</div>";
        }
        
        DivTarList.innerHTML=output;
    }
    TarListReq.send();    
}

function getSum(CheckedSum,CheckId){
    var TarSum=document.getElementById('TarifSum');
    var CB=document.getElementById(CheckId);
    
    if (CB.checked==true){
        TarSum.value=Number(TarSum.value)+CheckedSum;
    } else {
        TarSum.value=Number(TarSum.value)-CheckedSum;
    }
    
}
//функция для получения данных из БД через AJAX
function showData(DataOutput){
    
    var ShowRequest=new XMLHttpRequest();
    ShowRequest.open('GET','index_admin.php?controller=TarifCalcCtrl&action='+Action,true);
    ShowRequest.onload = function(){
        var ShowList=JSON.parse(this.responseText);
        
        
    }
    ShowRequest.send();
}
