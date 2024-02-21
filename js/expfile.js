/* 
 * скрипт для обработки поведения пользователя на станице "досье ЭПЭ"
 * функции:
 * 1. при выборе (select) риска по ВБФЛ значение переносится в textarea для корретировки
 */
var MySelect=document.getElementById('Risk2Select');
var MyTextArea=document.getElementById('AddRisk2');

MySelect.addEventListener('change',function(){    
    MyTextArea.value=MySelect.value;
});

console.log('yes_expfile')