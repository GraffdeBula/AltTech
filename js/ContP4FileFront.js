/* 
 * скрипт для обработки поведения пользователя на странице "ContP4FileFront"
 * функции:
 * 1. отображение графика платежей

 * 
 */

var PayCalend=document.getElementById('P4PayCalend');

var url=new URL(window.location.href);
var ContCode=url.searchParams.get('ContCode');
var AddPayCalendBtn=document.getElementById('AddPayCalend');

formList1();

AddPayCalendBtn.addEventListener('click',function(){ 
    event.preventDefault();
    
    var PayCalendNum=document.getElementById('PayCalendNum');
    var PayCalendDate=document.getElementById('PayCalendDate');
    var PayCalendSum=document.getElementById('PayCalendSum');
    
    var req= new XMLHttpRequest();
    req.open('GET','index_admin.php?controller=ATContP4FileFrontCtrl&action=AddPayCalend&ContCode='+ContCode+'&PayNum='+PayCalendNum.value+'&PayDate='+PayCalendDate.value+'&PaySum='+PayCalendSum.value,true);
    req.send();
    formList1();    
    
    PayCalendNum.value='';
    PayCalendDate.value='';
    PayCalendSum.value='';
    
});

function formList1(){
    var PayCalendReq=new XMLHttpRequest();
    PayCalendReq.open('GET','index_admin.php?controller=ATContP4FileFrontCtrl&action=GetPayCalend&ContCode='+ContCode,true);
    PayCalendReq.onload = function(){
        var PayList=JSON.parse(this.responseText);
        
        var output='';
        for (var i in PayList ){

            output+="<tr class='table-active'>"+
                "<td>"+PayList[i].PAYNUM+"</td>"+
                "<td>"+PayList[i].PAYDATE+"</td>"+
                "<td>"+PayList[i].PAYSUM+"</td>"+                
                "<td><a><button class='btn btn-danger' onclick=delPayCalend("+PayList[i].ID+")>X</button></a></td>"
                "</tr>";
        }
        console.log(output);
        PayCalend.innerHTML=output;
    }
    PayCalendReq.send();    
}

function delPayCalend(DelId){
    var PaymentDelReq=new XMLHttpRequest();
    PaymentDelReq.open('GET','index_admin.php?controller=ATContP4FileFrontCtrl&action=DellPayCalend&ContCode='+ContCode+'&PayId='+DelId,true);
    PaymentDelReq.send();
    alert('Платёж удалён');
    setTimeout(formList1(),1000);
}

    