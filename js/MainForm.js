/* 
 * скрипт для обработки поведения пользователя на станице "Main Form"
 * функции:

 * 2. копирование ФИО в скрытые поля формы поиска при наведении на кнопку "Найти"
 * 3. очистка полей поиска
 */
const MyButton=document.getElementById('btn-find');
const FormFind=document.getElementById('frm-find');

MyButton.addEventListener('mouseover',function(){
    document.getElementById('fname-f').value=document.getElementById('fname').value;
    document.getElementById('1name-f').value=document.getElementById('1name').value;
    document.getElementById('2name-f').value=document.getElementById('2name').value;
    document.getElementById('pass-f').value=document.getElementById('ClPasSer').value;
    document.getElementById('pasn-f').value=document.getElementById('ClPasNum').value;
});
MyButton.addEventListener('click',function(){
    FormFind.submit();
});

const MyButton2=document.getElementById('btn-clear');
MyButton2.addEventListener('click',function(){            
    document.getElementById('fname').value='';
    document.getElementById('1name').value='';
    document.getElementById('2name').value='';
    document.getElementById('ClPasSer').value='';
    document.getElementById('ClPasNum').value='';            
});

const MyButton3=document.getElementById('btn-add');
const FormAdd=document.getElementById('frm-add');
MyButton3.addEventListener('click',function(){
    InpFName=document.getElementById('fname');
    Inp1Name=document.getElementById('1name');
    if (InpFName.value===''){
        InpFName.placeholder='НУЖНА ФАМИЛИЯ';
        
        return;
    }
    if (Inp1Name.value===''){
        Inp1Name.placeholder='НУЖНО ИМЯ';
        
        return;
    }
    
    FormAdd.submit();
});

console.log('yes4')