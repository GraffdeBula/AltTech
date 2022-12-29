<?php


/**
 * контроллер для сбора в БД информации о клиенте
 *
 * @author andrey
 */
class PrintIskCtrl extends Controller{
    protected $Client; //клиент
    protected $Contract;
    protected $Court;
    protected $Nalog;
    protected $Creditors;
    protected $Documents;
    protected $IskPack;
    protected $IskNames;

    protected $Data; //данные для формирования иска
    protected $BookMarks;       
    protected $ClCode;
    protected $ContCode;
    
    public function actionIndex(){            
        $this->ClCode=$_GET['ClCode'];
        $this->ContCode=$_GET['ContCode'];
        $this->IskPack=[
            
            1=>'2818C72E-FC0E-39FF-A57F-AA69E9A1B3CB',            
            2=>'16FB5551-717B-363F-9037-BE764201D7AB',
            3=>'6ADEFCFB6-3587-40BF-AC70-0033F3EE87B5'
        ];
        $this->IskNames=[
            
            1=>'Приложение 1 кредиторы',
            2=>'Приложение 2 имущество',
            3=>'Исковое заявление',
        ];
        
        $this->GetData();        
        
        foreach($this->IskPack as $i => $IskDoc){
            $Isk=new DZCtrl(); //создание нового объекта curl для формирования иска            
            $Isk->DocID=$IskDoc;
            $Isk->DocName=$this->Client->CLNAMEIP.' '.$this->IskNames[$i];
            $Isk->Data=$this->CreateData($i);            
            
            #$Isk->action='TestAc';
            $Isk->run();            
        }
                
        header("Location: https://afpc24.doczilla.pro"); //
    }
          
    protected function CreateData($i){//
        $this->Data=[];

        foreach ($this->BookMarks[$i] as $BookMark) {                        

            if ($BookMark->BMARRKEY>=0){
                
                if (isset($this->{$BookMark->BMMODEL}[$BookMark->BMARRKEY]->{$BookMark->BMFIELD})){
                    
                    $this->Data[$BookMark->BMNAME]=$this->{$BookMark->BMMODEL}[$BookMark->BMARRKEY]->{$BookMark->BMFIELD};
                } else {
                    
                }
                #echo ($this->{$BookMark->BMMODEL}{intval($BookMark->BMARRKEY)}->{$BookMark->BMFIELD});
                #echo("<br>".$this->{$BookMark->BMMODEL}[0]->{$BookMark->BMFIELD});                            
            }
             
            else {
                $this->Data[$BookMark->BMNAME]=$this->{$BookMark->BMMODEL}->{$BookMark->BMFIELD};               
//                echo("<br>".$this->{$BookMark->BMMODEL}->{$BookMark->BMFIELD});
//                echo("<br>Контроль: ".$this->Data["ID".$BookMark->BMNAME]);
            }
         
        }    

        return $this->Data;
    }

    protected function GetData(){
        $IskData=new IskMod();
        $this->Client=$IskData->getClient($this->ClCode);
        $this->Contract=$IskData->getContract($this->ContCode);
        $this->Creditors=$IskData->getCreditors($this->ContCode);
        $this->Documents=$IskData->getDocuments($this->ContCode);
        $this->Court=$IskData->getCourt($this->ContCode);
        $this->Nalog=$IskData->getNalog($this->ContCode);
        #$this->AU=$IskData->getAU($this->ContCode);
        $this->BookMarks[1]=$IskData->getBookMarks1();
        $this->BookMarks[2]=$IskData->getBookMarks2();
        $this->BookMarks[3]=$IskData->getBookMarks3();    
//        echo('test1 14-07-2021 <br>');
//        var_dump($this->BookMarks[1]);
//        echo("<br>");
//        var_dump($this->BookMarks[3]);
//        exit();
    }
}
