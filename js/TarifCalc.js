/* 
 * скрипт для обработки поведения пользователя на странице "TarifCalc"
 * функции:
 * вывод списка элементов тарифа на страницу
 * подсчёт тарифа по чеклисту
 */
var NewDataGlob=0;

var ListObj={
    Mylist: array(),
}

var List1Data=getData('GetTarifList1');
showData(List1Data,'TarifList1');

var List2Data=getData('GetTarifList2');
showData(List2Data,'TarifList2');

var List3Data=getData('GetTarifList3');
showData(List3Data,'TarifList3');

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
function getData(DataAction){    
    var ShowRequest=new XMLHttpRequest();
    ShowRequest.open('GET','index_admin.php?controller=TarifCalcCtrl&action='+DataAction,true);
    ShowRequest.onload = function(){
        ListObj.Mylist=JSON.parse(this.responseText);        
        console.log(NewDataGlob);
    }
    
    ShowRequest.send();
    console.log(ListObj);
    return ;
}
//функция для вывода во вью полученных данных
function showData(ShowData,ShowDiv){    
    var ShowDiv=document.getElementById(ShowDiv);
    ShowDiv.innerHTML=ShowData;
    
}

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