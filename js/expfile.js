/* 
 * скрипт для обработки поведения пользователя на станице "досье ЭПЭ"
 * функции:
 * 1. при выборе (select) риска по ВБФЛ значение переносится в textarea для корретировки
 */
var MySelect=document.getElementById('Risk2Select');
var MyTextArea=document.getElementById('AddRisk2');
var MyVal2=document.getElementById('Risk2Value2');

MySelect.addEventListener('change',function(){    
    MyTextArea.value=MySelect.value;
    MyVal2.value=MySelect.selectedIndex;
    console.log(MySelect.selectedIndex);
});

console.log('yes_expfile')