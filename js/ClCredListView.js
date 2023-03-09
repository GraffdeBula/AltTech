/* калькулятор для расчёта всяких сумм при подаче иска
 * вызывается из вьюшки "список кредитов"
 */

//задаём новые функции для инпутов, где есть суммы (открыть калькулятор)
var inpList=document.querySelectorAll('.crdebtsum');

inpList.forEach(function(inp){
    
    inp.addEventListener('dblclick',myShow);
});

//declare functions

function myClick(e){
    console.log(e.target.id);
};

function myFiltClear(){    
    document.getElementById('my_filt').value='';
};

function myCancel(){
    document.getElementById('my_calc').style.display='none';
    document.getElementById('my_background').style.display='none';
};

function myShow(e){
    document.getElementById('my_calc').style.display='block';
    document.getElementById('my_background').style.display='block';
    document.getElementById('inpIndCh').style.display='none';
    document.getElementById('inpIndCh').innerHTML=e.target.id;
    //нужно оставить три инпута и им в значение поставить 0, а остальные удалить
    var ind=0;
    var inpArr=document.querySelectorAll('.calcInp');
    inpArr.forEach(function(inp){
        ind=ind+1;
        if(ind<=3){
            inp.value=0;
        }else {
            inp.remove();
        };
    });
};

function myAdd(){ //добавляет ещё одно поле input для расчёта
    const li=document.createElement('li');
    li.className='collection-item';   
    
    const inp=document.createElement('input');
    inp.type='text';
    inp.value='0';
    inp.className='calcInp';
    
    li.appendChild(inp);
    document.querySelector('ul.collection').appendChild(li);
    
};

myCount=function myCount(){ //считает сумму по всем инпутам калькулятора, выводит результат в окошко, из которого калькулятор вызвали, закрывает калькулятор
    calc=document.getElementsByClassName('calcInp');    
    sum=0;
    for(var inp of calc){
        sum=sum+parseInt(inp.value);
    }
    myId=document.getElementById('inpIndCh').innerHTML;
    suminp=document.getElementById(myId);
    suminp.value=sum;
    document.getElementById('my_calc').style.display='none';
    document.getElementById('my_background').style.display='none';
};

