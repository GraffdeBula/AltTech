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

getPayList();

function getPayList(){
    var PaymentListReq=new XMLHttpRequest();
    PaymentListReq.open('GET','index_admin.php?controller=ContP1FileGetDataCtrl&action=GetPaymentList&ContCode='+ContCode,true);
    PaymentListReq.onload = function(){
        var PaymentList=JSON.parse(this.responseText);
        console.log(PaymentList);
        output='';
        for (var i in PaymentList ){

            output+="<tr class='table-active'>"+
                "<td>"+PaymentList[i].PAYCODE+"</td>"+
                "<td>"+PaymentList[i].PAYDATE+"</td>"+
                "<td>"+PaymentList[i].PAYSUM+"</td>"+
                "<td>"+PaymentList[i].PAYPR+"</td>"+
                "<td><a href='payments/"+PaymentList[i]+".xlsx'><button class='btn btn-success'>Скачать ПКО</button></a></td>"+
                "</tr>";

        }
        DivPaymentList.innerHTML=output;
    }
    PaymentListReq.send();

}
