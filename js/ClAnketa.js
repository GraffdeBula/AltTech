/* 
 * скрипт для обработки поведения пользователя на станице "Анкета клиента"
 * функции:
 * 1. скрытие поля для серии документв при вводе ИНН, СНИЛС
 * 
 */

var DocTypeInput = document.querySelector('#DocTypeSel');
var DocSerInput = document.querySelector('#ClDocSerInp');

DocTypeInput.addEventListener('change',function(){
    if(DocTypeInput.value=='ИНН'){
        DocSerInput.disabled=true;
    } else if (DocTypeInput.value=='СНИЛС'){            
        DocSerInput.disabled=true;
    } else {
        DocSerInput.disabled=false;
    }

});

