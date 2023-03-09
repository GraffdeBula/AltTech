/* 
 * скрипт для обработки поведения пользователя на станице "анкета договора P1"
 * функции:
 * 1. поиск по списку кредиторов
 */

const BtnSearch = document.getElementById('BtnSearch');
const Btn2 = document.getElementById('Btn2');
const CredSearch = document.getElementById('CredSearch');

BtnSearch.addEventListener('click', FindOnPage);
Btn2.addEventListener('click', runEv2);

//функция 1
function runEvent(e){
    let Search=CredSearch.value.toUpperCase();
        
    console.log(Search);
}

function runEv2(e){            
    console.log('Search');
}

var lastResFind=""; // последний удачный результат
var copy_page=""; // копия страницы в исходном виде
function TrimStr(s) {
     s = s.replace( /^\s+/g, '');
  return s.replace( /\s+$/g, '');
}
function FindOnPage() {//ищет текст на странице, в параметр передается ID поля для ввода
  console.log(copy_page);  
  var obj = document.getElementById('CredSearch');
  var textToFind;
 
  if (obj) {
    textToFind = TrimStr(obj.value);//обрезаем пробелы
  } else {
    alert("Введенная фраза не найдена");
    return;
  }
  if (textToFind == "") {
    alert("Вы ничего не ввели");
    return;
  }
 
  if(document.body.innerHTML.indexOf(textToFind)=="-1")
  alert("Ничего не найдено, проверьте правильность ввода!");
 
  //if(copy_page.length>0)
  //      document.body.innerHTML=copy_page;
  //else copy_page=document.body.innerHTML;

 
  document.body.innerHTML = document.body.innerHTML.replace(eval("/name="+lastResFind+"/gi")," ");//стираем предыдущие якори для скрола
  //document.body.innerHTML = document.body.innerHTML.replace(eval("/"+textToFind+"/gi"),"<a name="+textToFind+" style='background:green'>"+textToFind+"</a>"); //Заменяем найденный текст ссылками с якорем;
  lastResFind=textToFind; // сохраняем фразу для поиска, чтобы в дальнейшем по ней стереть все ссылки
  window.location = '#'+textToFind;//перемещаем скрол к последнему найденному совпадению
  
 }

//функция 2 смена кнопки для формы c результатами ЭПЭ
const MyButton1=document.getElementById('btn1');
const MyButton2=document.getElementById('btn2');
const MyButton3=document.getElementById('btn3');
const MyInput=document.getElementById('ExpRes');
const MyForm=document.getElementById('ExpForm');


