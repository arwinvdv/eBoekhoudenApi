<?php

namespace bobkosse\eBoekhouden\ValueObjects;

/**
 * Class AccountLedgerCategory
 * @package bobkosse\eBoekhouden\ValueObjects
 */
class AccountLedgerCategory {

    /**
     * @var
     */
    private $accountLedgerCategory;

    /**
     * AccountLedgerCategory constructor.
     * @param $accountLedgerCategory
     * @throws \Exception
     */
    public function __construct($accountLedgerCategory = null)
    {
        if(mb_strlen($accountLedgerCategory) < 11 || $accountLedgerCategory === null) {
            $this->accountLedgerCategory = $accountLedgerCategory;
            return;
        }

        throw new \Exception("Account Ledger Category may not exceed the length of 10 characters or may be null", 108);
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        if($this->accountLedgerCategory === null) {
            return null;
        }
        return $this->accountLedgerCategory;
    }
}
