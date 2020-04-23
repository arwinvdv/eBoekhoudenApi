<?php

namespace bobkosse\eBoekhouden;

/**
 * Class Mutation
 * @package bobkosse\eBoekhouden
 * @todo Use ValueObject where possible
 */
class Mutation
{
    /**
     * @var
     */
    protected $kind;
    /**
     * @var
     */
    protected $date;
    /**
     * @var
     */
    protected $account;
    /**
     * @var
     */
    protected $relationCode;
    /**
     * @var
     */
    protected $invoiceNumber;
    /**
     * @var
     */
    protected $bookNumber;
    /**
     * @var
     */
    protected $description;
    /**
     * @var
     */
    protected $termOfPayment;
    /**
     * @var
     */
    protected $inOrExVat;
    /**
     * @var array
     */
    protected $mutationLines = [];

    /**
     * @param mixed $kind
     * @return Mutation
     * @throws \Exception
     */
    public function setKind($kind)
    {
        $mutationKinds = [
            'FactuurOntvangen',
            'FactuurVerstuurd',
            'FactuurbetalingOntvangen',
            'FactuurbetalingVerstuurd',
            'GeldOntvangen',
            'GeldUitgegeven',
            'Memoriaal'
        ];
        if(!in_array($kind, $mutationKinds)) {
            throw new \Exception('Mutationkinds may only have one of the following values: ' . implode(', ', $mutationKinds));
        }
        $this->kind = $kind;
        return $this;
    }

    /**
     * @param mixed $date
     * @return Mutation
     * @throws \Exception
     */
    public function setDate($date)
    {
        if($date < '1980-01-01' || $date > '2049-12-31') {
            throw new \Exception('Date must be between 1980 and 2050');
        }
        $this->date = $date;
        return $this;
    }

    /**
     * @param mixed $account
     * @return Mutation
     * @throws \Exception
     */
    public function setAccount($account)
    {
        if(mb_strlen($account) > 10) {
            throw new \Exception('Account may not exceed the length of 10 characters');
        }
        $this->account = $account;
        return $this;
    }

    /**
     * @param mixed $relationCode
     * @return Mutation
     * @throws \Exception
     */
    public function setRelationCode($relationCode)
    {
        if(mb_strlen($relationCode) > 15) {
            throw new \Exception('RelationCode may not exceed the length of 15 characters');
        }
        $this->relationCode = $relationCode;
        return $this;
    }

    /**
     * @param mixed $invoiceNumber
     * @return Mutation
     * @throws \Exception
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        if(mb_strlen($invoiceNumber) > 50) {
            throw new \Exception('InvoiceNumber may not exceed the length of 50 characters');
        }
        $this->invoiceNumber = $invoiceNumber;
        return $this;
    }

    /**
     * @param mixed $bookNumber
     * @return Mutation
     * @throws \Exception
     */
    public function setBookNumber($bookNumber)
    {
        if(mb_strlen($bookNumber) > 50) {
            throw new \Exception('BookNumber may not exceed the length of 50 characters');
        }
        $this->bookNumber = $bookNumber;
        return $this;
    }

    /**
     * @param mixed $description
     * @return Mutation
     * @throws \Exception
     */
    public function setDescription($description)
    {
        if(mb_strlen($description) > 200) {
            throw new \Exception('Description may not exceed the length of 200 characters');
        }
        $this->description = $description;
        return $this;
    }

    /**
     * @param mixed $termOfPayment
     * @return Mutation
     * @throws \Exception
     */
    public function setTermOfPayment($termOfPayment)
    {
        if(mb_strlen($termOfPayment) > 4) {
            throw new \Exception('TermOfPayment may not exceed the length of 4 characters');
        }
        $this->termOfPayment = $termOfPayment;
        return $this;
    }

    /**
     * @param mixed $inOrExVat
     * @return Mutation
     * @throws \Exception
     */
    public function setInOrExVat($inOrExVat)
    {
        $inOrEx = [
            'IN',
            'EX'
        ];
        if(!in_array($inOrExVat, $inOrEx)) {
            throw new \Exception('InOrExVat may only have one of the following values: ' . implode(', ', $inOrEx));
        }
        $this->inOrExVat = $inOrExVat;
        return $this;
    }

    /**
     * @param mixed $mutationLines
     * @return Mutation
     */
    public function setMutationLines($mutationLines)
    {
        $this->mutationLines = $mutationLines;
        return $this;
    }

    /**
     * @param float $amount The amount without vat
     * @param int $vatPercentage
     * @param string $vatCode
     * @param string $counterAccount
     * @param int $costCenterId
     * @throws \Exception
     */
    public function addMutationLine(float $amount, int $vatPercentage, string $vatCode, string $counterAccount, int $costCenterId)
    {
        if(mb_strlen($counterAccount) > 10) {
            throw new \Exception('CounterACCOUNT may not exceed the length of 10 characters');
        }

        if($amount === '' || $amount === null || $vatPercentage === '' || $vatPercentage === null || $costCenterId === '' || $costCenterId === null) {
            throw new \Exception('Amount, vatPercentage and costCenterId are mandatory fields');
        }

        array_push($this->mutationLines, [
            'BedragInvoer' =>  number_format($amount, 2, '.', ''),
            'BedragExclBTW' => number_format($this->calculateAmountExVat($amount, $vatPercentage), 2, '.', ''),
            'BedragBTW' => number_format($this->calculateAmountVat($amount, $vatPercentage), 2, '.', ''),
            'BedragInclBTW' => number_format($this->calculateAmountInVat($amount, $vatPercentage), 2, '.', ''),
            'BTWCode' => $this->setVATCode($vatCode),
            'BTWPercentage' => $vatPercentage,
            'TegenrekeningCode' => $counterAccount,
            'KostenplaatsID' => $costCenterId
        ]);
    }

    /**
     * @param $amount
     * @param $vatPercentage
     * @return float
     */
    private function calculateAmountExVat($amount, $vatPercentage)
    {
        if($this->inOrExVat == 'EX') {
            return round($amount, 2);
        }
        $vatPerc = ($vatPercentage / 100 ) + 1;
        return round($amount / $vatPerc, 2);
    }

    /**
     * @param $amount
     * @param $vatPercentage
     * @return mixed
     */
    private function calculateAmountInVat($amount, $vatPercentage)
    {
        if($this->inOrExVat == 'IN') {
            return round($amount, 2);
        }
        $vatPerc = ($vatPercentage / 100 ) + 1;
        return round($amount * $vatPerc, 2);
    }


    /**
     * @param $amount
     * @param $vatPercentage
     * @return float
     */
    private function calculateAmountVat($amount, $vatPercentage)
    {
        $vatPerc = ($vatPercentage / 100 );
        switch($this->inOrExVat)
        {
            case 'IN':
                return round($amount - ($amount / ($vatPerc + 1)),2);
                break;
            case 'EX':
                return round($amount * $vatPerc, 2);
                break;
        }
    }

    /**
     * @param $vatCode
     * @return mixed
     * @throws \Exception
     */
    private function setVATCode($vatCode)
    {
        $vatCodes = [
            'HOOG_VERK',
            'HOOG_VERK_21',
            'LAAG_VERK',
            'LAAG_VERK_9',
            'VERL_VERK',
            'BU_EU_VERK',
            'BI_EU_VERK',
            'LAAG_INK',
            'HOOG_INK',
            'HOOG_INK_21',
            'BU_EU_INK',
            'BI_EU_INK',
            'GEEN',
            '',
        ];

        if(!in_array($vatCode, $vatCodes)) {
            throw new \Exception('BTWCode may only have one of the following values: ' . implode(', ', $vatCodes));
        }
        return $vatCode;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getMutationArray()
    {
        if($this->kind == '' || $this->kind === null || $this->date == '' || $this->date === null) {
            throw new \Exception('Kind and date are mandatory fields');
        }

        return [
            'MutatieNr' => '',
            'Soort' => $this->kind,
            'Datum' => $this->date,
            'Rekening' => $this->account,
            'RelatieCode' => $this->relationCode,
            'Factuurnummer' => $this->invoiceNumber,
            'Boekstuk' => $this->bookNumber,
            'Omschrijving' => $this->description,
            'Betalingstermijn' => $this->termOfPayment,
            'InExBTW' => $this->inOrExVat,
            'MutatieRegels' => $this->mutationLines
        ];
    }

}
