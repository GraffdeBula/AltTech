/* 
 * скрипт для обработки поведения пользователя на странице "TarifCalc"
 * функции:
 * вывод списка элементов тарифа на страницу
 * подсчёт тарифа по чеклисту
 */
var NewDataGlob=0;


var List1Data=getData('GetTarifList1','TarifList1');

var List2Data=getData('GetTarifList2','TarifList2');

var List3Data=getData('GetTarifList3','TarifList3');

var TarSum=0;      

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
function getData(DataAction,ShowDiv){    
    var ShowRequest=new XMLHttpRequest();
    ShowRequest.open('GET','index_admin.php?controller=TarifCalcCtrl&action='+DataAction,true);
    ShowRequest.onload = function(){
        var ListArr=JSON.parse(this.responseText);        
        formShowData(ListArr,ShowDiv);
    }
    
    ShowRequest.send();        
}
//функция для вывода во вью полученных данных
function formShowData(ShowData,ShowDiv){
    var ShowDiv=document.getElementById(ShowDiv);
    ShowDiv.innerHTML=ShowData;
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