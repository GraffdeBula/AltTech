/* 
 * скрипт для обработки поведения пользователя на станице "Ljcmt rkbtynf"
 * функции:
 * 1. валидация при создании нового договора P1
 * 
 */

var Form = document.querySelector('.newContForm');
var FormP4 = document.querySelector('.newContFormP4');
var MyBtn= Form.querySelector('.newContBtn');
var MyBtnP4= FormP4.querySelector('.newContBtnP4');
var MyID= Form.querySelector('.MyID');
var MyIDP4= FormP4.querySelector('.MyIDP4');

Form.addEventListener('submit', function (event) {
  event.preventDefault();
  
  if (!MyID.value){
    MyID.value='Не введён ID';
    MyID.style.color='red';
  }else{
    var MyIDStr=MyID.value;
    MyIDStr=MyIDStr.replace(/[^0-9]/g, '');
    if (MyIDStr.length<8){
        MyID.value='Некорректный ID';
        MyID.style.color='red';
    }else{
        MyID.value=MyIDStr;    
        Form.submit();
    }
  }
    
});

FormP4.addEventListener('submit', function (event) {
  event.preventDefault();
  
  if (!MyIDP4.value){
    MyIDP4.value='Не введён ID';
    MyIDP4.style.color='red';
  }else{
    var MyIDStr=MyIDP4.value;
    MyIDStr=MyIDStr.replace(/[^0-9]/g, '');
    if (MyIDStr.length<8){
        MyIDP4.value='Некорректный ID';
        MyIDP4.style.color='red';
    }else{
        MyIDP4.value=MyIDStr;    
        FormP4.submit();
    }
  }
    
});
