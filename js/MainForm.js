/* 
 * скрипт для обработки поведения пользователя на станице "Main Form"
 * функции:
 * 1. валидация комментария при удалении агента
 * 2. копирование ФИО в скрытые поля формы поиска при наведении на кнопку "Найти"
 */
/*
var Form = document.querySelector('.delAgForm');
var MyBtn= Form.querySelector('.delAgBtn');
var MyID= Form.querySelector('.delComment');

Form.addEventListener('submit', function (event) {
  event.preventDefault();
  
  if (!MyID.value){
    MyID.value='Не введён комментарий';
    MyID.style.color='red';
    console.log('не туда');
  }else{
    var MyIDStr=MyID.value;
    MyIDStr=MyIDStr.replace(/[^0-9]/g, '');
    if (MyIDStr.length<20){
        MyID.value='Некорректный комментарий';
        MyID.style.color='red';
        console.log('туда');
    }else{
        MyID.value=MyIDStr;    
        console.log('сюда');
        //Form.submit();
    }
  }
    
});

/*ФУНКЦИЯ 2*/
const MyButton=document.getElementById('btn-find');
MyButton.addEventListener('mouseover',function(){
    document.getElementById('fname-f').value=document.getElementById('fname').value;
    document.getElementById('1name-f').value=document.getElementById('1name').value;
    document.getElementById('2name-f').value=document.getElementById('2name').value;
});

console.log('yes');