<?php

namespace bobkosse\eBoekhouden\ValueObjects;

/**
 * Class RelationSearch
 * @package bobkosse\eBoekhouden\ValueObjects
 */
class RelationSearch {

    /**
     * @var
     */
    private $relationSearch;

    /**
     * RelationSearch constructor.
     * @param $accountLedgerCode
     * @throws \Exception
     */
    public function __construct($relationSearch = null)
    {
        if(mb_strlen($relationSearch) < 255 && mb_strlen($relationSearch) > 0) {
            $this->relationSearch = $relationSearch;
            return;
        }

        throw new \Exception("Relation search query may not exceed the length of 255 characters", 111);
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        if($this->relationSearch === null) {
            return null;
        }
        return $this->relationSearch;
    }
}
