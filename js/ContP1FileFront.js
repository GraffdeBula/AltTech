/* 
 * скрипт для обработки поведения пользователя на странице "ContP1FileFront"
 * функции:
 * 1. отображение списка платежей без обновления страницы
 * 2. внесение платежа без обновления страницы
 * 3. удаление платежа без обновления страницы
 * 
 */


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
            
            output+="<tr class='table-active'>"+
                "<td>"+PaymentList[i].PAYCODE+"</td>"+
                "<td>"+PaymentList[i].PAYDATE+"</td>"+
                "<td>"+PaymentList[i].PAYSUM+"</td>"+
                "<td>"+PaymentList[i].PAYPR+"</td>"+
                "<td>"+PaymentList[i].PAYMETHOD+"</td>"+
                "<td><a href='payments/"+PaymentList[i].ID+".xlsx'><button class='btn btn-success'>Скачать ПКО</button></a></td>"+
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