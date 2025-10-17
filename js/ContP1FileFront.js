/* 
 * скрипт для обработки поведения пользователя на странице "ContP1FileFront"
 * функции:
 * 1. отображение списка платежей без обновления страницы
 * 2. внесение платежа без обновления страницы
 * 3. удаление платежа без обновления страницы
 * 
 */
var SessionEmRole=document.getElementById('SessionEmRole').value;
var TarSum=0; 

var BtnTarif=document.getElementById('btn-tarif');
var FormTarif=document.getElementById('frm-tarif');

var DiscRuk=document.getElementById('DiskRuk');
var DiscDir=document.getElementById('DiskDir');

var FrContTarif=document.getElementById('FRCONTTARIF');
var AnnNum=document.getElementById('AnnNum');

var DiscRB1=document.getElementById('DiscRB1');
var DiscRB2=document.getElementById('DiscRB2');
var DiscRB3=document.getElementById('DiscRB3');
var DiscRB4=document.getElementById('DiscRB4');

//для сохранения итоговой суммы доплаты за сложность
var FrDopSumVisible=document.getElementById('FRDOPSUM_V');
var FrDopSumDir=document.getElementById('FRDOPSUMDIR');
var FrDopSumMan=document.getElementById('FRDOPSUMMAN');

DiscRB1.addEventListener('input',function(){
    var DiscountComment=document.getElementById('DiscountComment');
    DiscountComment.value='Клиент имеет инвалидность';
});
DiscRB2.addEventListener('input',function(){
    var DiscountComment=document.getElementById('DiscountComment');
    DiscountComment.value='Клиент пенсионер';
});
DiscRB3.addEventListener('input',function(){
    var DiscountComment=document.getElementById('DiscountComment');
    DiscountComment.value='Совместное банкротство (супруги)';
});
DiscRB4.addEventListener('input',function(){
    var DiscountComment=document.getElementById('DiscountComment');
    DiscountComment.value='Рекомендация';
});


FrContTarif.addEventListener('input',function(){
    
    TarifOne=['2024 БФЛ оплата сразу','2024 БФЛ Пенсионерам сразу','2024 БФЛ внесудебное сразу','2024 БФЛ+ипотека оплата сразу'];
    if (TarifOne.includes(FrContTarif.value)){               
        AnnNum.value='';
        var FRCONTPERIOD=document.getElementById('FRCONTPERIOD');
        FRCONTPERIOD.disabled=false;
        FRCONTPERIOD.value=1;
        AnnNum.disabled=true;
    }else{
        var FRCONTPERIOD=document.getElementById('FRCONTPERIOD');
        FRCONTPERIOD.disabled=true;
        AnnNum.disabled=false;
    }
});

BtnTarif.addEventListener('click',function(){
    FormTarif.submit();
});

DiscRuk.addEventListener('input',function(){
    var DiscRukRadio=document.getElementById('DiskRukValue');
    DiscRukRadio.checked=true;
    DiscRukRadio.value=DiskRuk.value;    
});

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
/*получение кнопкой согласование фокуса*/
function FrDopSumManFocus(){
    console.log(FrDopSumVisible.value);
    FrDopSumMan.value=FrDopSumVisible.value;
}
function FrDopSumDirFocus(){
    console.log(FrDopSumVisible.value);
    FrDopSumDir.value=FrDopSumVisible.value;
}
/*платежи*/

var url=new URL(window.location.href);
var ContCode=url.searchParams.get('ContCode');
var DivPaymentList=document.getElementById('PaymentList');
var AddPayBtn=document.getElementById('AddPayBtn');

getPayList();

var PaymentMethodReq=fetch('index_admin.php?controller=ContP1FileGetDataCtrl&action=GetPaymentMethodList',['GET']);


console.log('1');

console.log(PaymentMethodReq.json());


console.log('2');
PaymentMethodReq.send();

function getPayList(){
    var PaymentListReq=new XMLHttpRequest();
    PaymentListReq.open('GET','index_admin.php?controller=ContP1FileGetDataCtrl&action=GetPaymentList&ContCode='+ContCode,true);
    
    var now = new Date();
    var TodayMonth=now.getMonth()+1;
    var TodayDay=now.getDate();    
    
    PaymentListReq.onload = function(){
        var PaymentList=JSON.parse(this.responseText); 
        console.log(PaymentList);
        output='';
        for (var i in PaymentList ){
            var MyDate=PaymentList[i].PAYDATE;
            
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
            MyPayDateArr=PaymentList[i].PAYDATE.split("-");
            var MyPayDate=new Date(MyPayDateArr[0],MyPayDateArr[1]-1,MyPayDateArr[2]);
            var PayMonth=MyPayDate.getMonth()+1;
            var PayDay=MyPayDate.getDate();
            var UpdButton="";
            var DelButton="";
            console.log([TodayMonth,PayMonth,TodayDay,PayDay]);
            var months1=[1,3,5,7,8,10];
            var months2=[4,6,9];
            var days=[28,29];
            if (
                    ((SessionEmRole=='director')&&
                    (((PayMonth==TodayMonth)&&(PayDay>=TodayDay-1))
                    ||((PayMonth==TodayMonth-1)&&(months1.includes(TodayMonth))&&(TodayDay==1)&&(PayDay==31))
                    ||((PayMonth==TodayMonth-1)&&(months2.includes(TodayMonth))&&(TodayDay==1)&&(PayDay==30))
                    ||((PayMonth==TodayMonth-1)&&(TodayMonth==3)&&(TodayDay==1)&&(days.includes(PayDay))))
                )
                ||(SessionEmRole=='top')
                ||(SessionEmRole=='admin')
                )
            {
                DelButton="<a><button onclick=delPayment("+PaymentList[i].ID+") class='btn btn-danger'>Удалить "+PaymentList[i].ID+"</button></a>";
            };
            
            SessionEmRole
            output+="<tr class='table-active'>"+
                "<td>"+PayCodeStr+"</td>"+
                "<td>"+PaymentList[i].PAYDATE+"</td>"+
                "<td><input name='PAYSUM' size=9 value='"+PaymentList[i].PAYSUM+"'></td>"+
                "<td>"+PaymentList[i].PAYPR+"</td>"+
                "<td>"+PaymentList[i].PAYMETHOD+"</td>"+
                "<td><a target='_blanc' href='index_admin.php?controller=ATContP1FileFrontCtrl&action=DownloadPayBill&ClCode="+PaymentList[i].CLCODE+"&ContCode="+PaymentList[i].CONTCODE+"&PayID="+PaymentList[i].ID+"'><button class='btn btn-success'>Скачать ПКО</button></a></td>"+
                "<td>"+DelButton+"</td>"+
                
                "</tr>";

        }
        DivPaymentList.innerHTML=output;
    };
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

function CheckRisk(id){
    var MyCBValue=document.getElementById('CBR'+id).checked;    
    var MyCode=document.getElementById('ContCode'+id).value;
    var MyName=document.getElementById('RiskName'+id).value;
    var MyCost=document.getElementById('RiskCost'+id).value;
    
    if (MyCBValue==true){               
        var req= new XMLHttpRequest();
        req.open('GET','index_admin.php?controller=ATContP1FileFrontCtrl&action=AddRisk&ContCode='+MyCode+'&RiskVal='+MyName+'&RiskCost='+MyCost,true);
        req.send();        
        console.log('Add1Done');        
    }else{        
        var req= new XMLHttpRequest();
        req.open('GET','index_admin.php?controller=ATContP1FileFrontCtrl&action=DelRisk&ContCode='+MyCode+'&RiskVal='+MyName,true);
        req.send(); 
        console.log('DelDone');        
    }
    
    function InputSum(id){
        console.log(id);
    }
    
}    
