/* 
 * скрипт для обработки поведения пользователя на странице "ContP1FileFront"
 * функции:
 * 1. отображение списка платежей без обновления страницы
 * 2. внесение платежа без обновления страницы
 * 3. удаление платежа без обновления страницы
 * 
 */

var TarSum=0; 

var List0=document.getElementById('TarifList0');
var List1=document.getElementById('TarifList1');
var List2=document.getElementById('TarifList2');
var List3=document.getElementById('TarifList3');

//formList0();
formList1();
formList2();
formList3();

function GetPeriod(){
    var Period=document.getElementById('TarifPeriod');
    var AnnNum=document.getElementById('AnnNum');
    Period.value=AnnNum.value;
    console.log(AnnNum.value);
}

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
    
    if (ListNum==1){           
        SumCount=document.getElementById('count'+CheckId).value; 
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
/*получение суммы договора и пакета тарифа*/

/*платежи*/

var url=new URL(window.location.href);
var ContCode=url.searchParams.get('ContCode');
var DivPaymentList=document.getElementById('PaymentList');
var AddPayBtn=document.getElementById('AddPayBtn');

getPayList();

function getPayList(){
    var PaymentListReq=new XMLHttpRequest();
    PaymentListReq.open('GET','index_admin.php?controller=ContP1FileGetDataCtrl&action=GetPaymentList&ContCode='+ContCode,true);
    PaymentListReq.onload = function(){
        var PaymentList=JSON.parse(this.responseText);
        console.log(PaymentList);
        output='';
        for (var i in PaymentList ){
            var MyDate=PaymentList[i].PAYDATE;
            
//            MyDate.toLocaleDateString('ru-RU', {
//                year: 'numeric',
//                month: '2-digit',
//                day: '2-digit'
//            });
//            console.log(MyDate);
            var PayCodeStr='';
            if ((PaymentList[i].PAYCODE<10)&&(PaymentList[i].CONTTYPE==1)){
                PayCodeStr='0000'+PaymentList[i].PAYCODE;
            } else if ((PaymentList[i].PAYCODE<100)&&(PaymentList[i].CONTTYPE==1)){
                PayCodeStr='000'+PaymentList[i].PAYCODE;
            } else if ((PaymentList[i].PAYCODE<1000)&&(PaymentList[i].CONTTYPE==1)){
                PayCodeStr='00'+PaymentList[i].PAYCODE;
            } else if ((PaymentList[i].PAYCODE<10000)&&(PaymentList[i].CONTTYPE==1)){
                PayCodeStr='0'+PaymentList[i].PAYCODE;
            } else if ((PaymentList[i].PAYCODE>=10000)&&(PaymentList[i].CONTTYPE==1)){
                PayCodeStr=''+PaymentList[i].PAYCODE;
            } else if ((PaymentList[i].CONTTYPE==2)) {
                PayCodeStr=''+PaymentList[i].PAYCODE;
            }
            
            output+="<tr class='table-active'>"+
                "<td>"+PayCodeStr+"</td>"+
                "<td>"+PaymentList[i].PAYDATE+"</td>"+
                "<td>"+PaymentList[i].PAYSUM+"</td>"+
                "<td>"+PaymentList[i].PAYPR+"</td>"+
                "<td>"+PaymentList[i].PAYMETHOD+"</td>"+
                "<td><a target='_blanc' href='index_admin.php?controller=ATContP1FileFrontCtrl&action=DownloadPayBill&ClCode="+PaymentList[i].CLCODE+"&ContCode="+PaymentList[i].CONTCODE+"&PayID="+PaymentList[i].ID+"'><button class='btn btn-success'>Скачать ПКО</button></a></td>"+
                "<td><a><button onclick=delPayment("+PaymentList[i].ID+") class='btn btn-danger'>Удалить "+PaymentList[i].ID+"</button></a></td>"+
                
                "</tr>";

        }
        DivPaymentList.innerHTML=output;
    }
    PaymentListReq.send();

}

function addPayment(){
    
}

function delPayment(DelId){
    
    var PaymentDelReq=new XMLHttpRequest();
    PaymentDelReq.open('GET','index_admin.php?controller=ATContP1FileFrontCtrl&action=DelPayment&ContCode='+ContCode+'&PayId='+DelId,true);
    PaymentDelReq.send();
    alert('Платёж удалён');
    setTimeout(getPayList(),1000);
    
}