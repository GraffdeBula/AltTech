/* 
 * скрипт для обработки поведения пользователя на странице "TarifCalc"
 * функции:
 * вывод списка элементов тарифа на страницу
 * подсчёт тарифа по чеклисту
 */


var MySelect=document.getElementById('MySelect');
var RiskList=document.getElementById('RiskList');

function MySelectFunction(MyValue){
    var Num=RiskList.getElementsByTagName('input').length+1;
    console.log(Num);
    var MyP1=document.createElement('p');
    var MyInp=document.createElement('input');
    var MyLable=document.createElement('lable');
    var MyInp2=document.createElement('input');
    MyP1.textContent=MyValue;
    MyInp.value=MyValue;
    MyInp.name='Check'+Num;
    MyInp.type='hidden';
    MyLable.textContent='от';
    MyLable.for='CheckSum'+Num;
    MyInp2.type='number';
    MyInp2.placeholder='от 1000';
    MyInp2.name='CheckSum'+Num;
    MyInp2.id='CheckSum'+Num;
    RiskList.insertAdjacentElement('afterbegin',MyP1);
    RiskList.insertAdjacentElement('afterbegin',MyInp);
    
    //MyP1.insertAdjacentElement('beforebegin',MyLable);
    MyP1.insertAdjacentElement('beforeend',MyInp2);
}