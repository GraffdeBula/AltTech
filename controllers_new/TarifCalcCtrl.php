<?php
/**
 * контроллер для работы с вьюшкой Амо
 *
 * @author Andrey
 */
class TarifCalcCtrl extends ControllerMain{
      
    
    public function actionIndex(){
        $this->ViewName='Тарифный калькулятор';
        
        $this->render('TarifCalc',['TarifSum'=>0,'PaySum'=>0,'TarifExSum'=>0,'PayExSum'=>0]);
    }
    public function actionGetTarifList0(){
        $TarifList=(new TarifMod())->getTarifElListByType('Тариф');
        echo json_encode($TarifList);
    }
    public function actionGetTarifList1(){
        $TarifList=(new TarifMod())->getTarifElListByType('Доплата');
        echo json_encode($TarifList);
    }       
    public function actionGetTarifList2(){
        $TarifList=(new TarifMod())->getTarifElListByType('Вычет');
        echo json_encode($TarifList);
    }
    public function actionGetTarifList3(){
        $TarifList=(new TarifMod())->getTarifElListByType('Скидка');
        echo json_encode($TarifList);
    }
    
    public function actionCountTarif(){
        $Base=130000;
        $AnnNum=1;
        $Plus1=0;
        $Plus2=0;
        $Plus3=0;
        $Minus1=0;
        $Minus2=0;
        $Disc=0;
        $Dop=0;
        if ((isset($_GET['Tarif']))&&($_GET['Tarif']=='Оплата сразу')){
            $Base=130000;
        }
        if ((isset($_GET['Tarif']))&&($_GET['Tarif']=='Рассрочка')){
            $Base=144000;
        }
        if (isset($_GET['AnnNum'])){
            $AnnNum=$_GET['AnnNum'];
        }
        if ((isset($_GET['CB01']))&&isset($_GET['count01'])){
            if (($_GET['count01']>=11)&&($_GET['count01']<=20)){
                $Plus1=9000;
            } elseif (($_GET['count01']>=21)&&($_GET['count01']<=40)) {
                $Plus1=18000;
            } elseif (($_GET['count01']>=41)&&($_GET['count01']<=60)) {
                $Plus1=27000; 
            } elseif ($_GET['count01']>=61) {
                $Plus1=36000;
            } elseif ($_GET['count01']=='') {
                $Plus1=0;   
            }
        }
        if ((isset($_GET['CB02']))&&isset($_GET['count02'])&&($_GET['count02']!='')){
            $Plus2=9000*$_GET['count02'];
        } elseif ((isset($_GET['CB02']))&&isset($_GET['count02'])&&($_GET['count02']=='')){
            $Plus2=0;
        }
        if (isset($_GET['CB03'])){
            $Plus3=100000;
        }
        if (isset($_GET['CB03'])){
            $Minus1=36000;
        }
        if (isset($_GET['CB03'])){
            $Minus2=18000;
        }
        
        if ((isset($_GET['RB01']))&&($_GET['RB01']=='rb01-1')){
            $Disc=12000;
        } elseif ((isset($_GET['RB01']))&&($_GET['RB01']=='rb01-2')){
            $Disc=9000;
        } elseif ((isset($_GET['RB01']))&&($_GET['RB01']=='rb01-3')){
            $Disc=5000;
        } elseif ((isset($_GET['RB01']))&&($_GET['RB01']=='rb01-4')){
            $Disc=12000;
        }
        
        foreach($_GET as $MyKey=>$MyGet){
            if (in_array($MyKey,['CheckSum1','CheckSum2','CheckSum3','CheckSum4','CheckSum5','CheckSum6','CheckSum7','CheckSum8',
                'CheckSum9','CheckSum10','CheckSum11','CheckSum12','CheckSum13','CheckSum14','CheckSum15','CheckSum16'])){
                    if ($MyGet=''){
                        $Dop=$Dop+0;                    
                    } else {
                        $Dop=$Dop+$MyGet;                    
                    }
                    
                }
        }
                
        $TarifSum=$Base+$Plus1+$Plus2+$Plus3-$Minus1-$Minus2-$Disc;
        $TarifExSum=$TarifSum+$Dop;
        $PaySum=($TarifSum-$_GET['ZeroPay'])/$AnnNum;
        $PayExSum=($TarifExSum-$_GET['ZeroPay'])/$AnnNum;
        $this->render('TarifCalc',['TarifSum'=>$TarifSum,'PaySum'=>$PaySum,'TarifExSum'=>$TarifExSum,'PayExSum'=>$PayExSum]);
    }
    
    
}
