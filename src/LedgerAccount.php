<?php

namespace bobkosse\eBoekhouden;

/**
 * Class LedgerAccount
 * @package bobkosse\eBoekhouden
 * @todo Use ValueObject where possible
 */
class LedgerAccount
{
    /**
     * @var
     */
    protected $code;
    /**
     * @var
     */
    protected $description;
    /**
     * @var
     */
    protected $category;

    /**
     * @param mixed $code
     * @return LedgerAccount
     * @throws \Exception
     */
    public function setCode($code)
    {
        if(mb_strlen($code) > 10) {
            throw new \Exception('Code may not exceed the length of 10 characters');
        }
        $this->code = $code;
        return $this;
    }

    /**
     * @param mixed $description
     * @return LedgerAccount
     * @throws \Exception
     */
    public function setDescription($description)
    {
        if(mb_strlen($description) > 50) {
            throw new \Exception('Description may not exceed the length of 50 characters');
        }
        $this->description = $description;
        return $this;
    }

    /**
     * @param mixed $category
     * @return LedgerAccount
     * @throws \Exception
     */
    public function setCategory($category)
    {
        $acceptedvalues = ['BAL', 'VW'];

        if(!in_array($category, $acceptedvalues)) {
            throw new \Exception('Category must be BAL (Balance) or VW (Profit and Loss Account)');
        }
        $this->category = $category;
        return $this;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getLedgerAccountArray()
    {
        if($this->code == '' || $this->code === null
            || $this->description == '' || $this->description === null
            || $this->category == '' || $this->category === null) {
            throw new \Exception('Code, Description and Category are mandatory fields');
        }

        return [
            'ID' => '0',
            'Code' => $this->code,
            'Omschrijving' => $this->description,
            'Categorie' => $this->category
        ];
    }
}
