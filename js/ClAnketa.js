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
        DocSerInput.type='hidden';
    } else if (DocTypeInput.value=='СНИЛС'){            
        DocSerInput.type='hidden';
    } else {
        DocSerInput.type='text';
    }

});

