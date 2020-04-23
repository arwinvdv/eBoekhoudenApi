<?php

namespace bobkosse\eBoekhouden\ValueObjects;

/**
 * Class RelationCode
 * @package bobkosse\eBoekhouden\ValueObjects
 */
class RelationCode {

    /**
     * @var
     */
    private $relationCode;

    /**
     * RelationCode constructor.
     * @param $relationCode
     * @throws \Exception
     */
    public function __construct($relationCode)
    {
        if(mb_strlen($relationCode) < 16 || $relationCode === null) {
            $this->relationCode = $relationCode;
            return;
        }
        throw new \Exception("Relation code may have a string length of maximal 15 characters", 105);
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        if($this->relationCode == '') {
            return null;
        }
        return $this->relationCode;
    }
}
