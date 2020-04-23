<?php

namespace bobkosse\eBoekhouden\ValueObjects;

/**
 * Class AccountLedgerCode
 * @package bobkosse\eBoekhouden\ValueObjects
 */
class AccountLedgerCode {

    /**
     * @var
     */
    private $accountLedgerCode;

    /**
     * AccountLedgerCode constructor.
     * @param $accountLedgerCode
     * @throws \Exception
     */
    public function __construct($accountLedgerCode = null)
    {
        if(mb_strlen($accountLedgerCode) < 11 || $accountLedgerCode === null) {
            $this->accountLedgerCode = $accountLedgerCode;
            return;
        }

        throw new \Exception("Account Ledger Code may not exceed the length of 10 characters or may be null", 107);
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        if($this->accountLedgerCode === null) {
            return null;
        }
        return $this->accountLedgerCode;
    }
}
