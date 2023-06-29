<?php

/**
 * Description of ContCredit
 *
 * @author Andrey
 */
class ContCredit {
    protected $CredSum;
    protected $CredDate;
    protected $CredRestSum;
    protected $CredRate;
    protected $CredPeriod;
    protected $CreditorName;
    protected $PayList;
    protected $CreditPaymentsList;
        
    public function __constructor($CredSum,$CredRate,$CredPeriod,$PayList){
        $this->CredSum=$CredSum;
        $this->CredDate=$CredDate;
        $this->CredRate=$CredRate;
        $this->CredPeriod;
        $this->PayList=$PayList;
    }
    
    public function CountCreditPayments(){
        $i=0;
        $PayDate[0]=date_create($this->CredDate);        
        $DebtAfterSum[0]=$this->CredSum;
        $Rate=$this->CredRate;
        foreach($this->PayList as $Pay){
            $i++;

            $PayDate[$i]=date_create($Pay->PAYDATE);            
            $PayDays[$i]=date_diff($PayDate[$i-1],$PayDate[$i])->days;
            $DebtSum[$i]=$DebtAfterSum[$i-1];
            $PaySum[$i]=$Pay->PAYSUM;
            $PercSum[$i]=$DebtSum[$i]*($Rate/100/12/30)*$PayDays[$i];
            $MainSum[$i]=$PaySum[$i]-$PercSum[$i];
            $DebtAfterSum[$i]=$DebtSum[$i]-$MainSum[$i];
            
            $this->CreditPaymentsList[$i]=[$i,$Pay->PAYDATE,$PayDays[$i],$DebtSum[$i],$PercSum[$i],$MainSum[$i],$DebtAfterSum[$i]];
        }
        return $this->CreditPaymentsList;    
    }    
}
