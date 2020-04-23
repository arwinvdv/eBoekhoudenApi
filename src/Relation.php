<?php

namespace bobkosse\eBoekhouden;

/**
 * Class Relation
 * @package bobkosse\eBoekhouden
 * @todo Use ValueObject where possible
 */
class Relation
{
    /**
     * @var
     */
    protected $id = 0;
    /**
     * @var
     */
    protected $creationDate;
    /**
     * @var
     */
    protected $relationCode;
    /**
     * @var
     */
    protected $companyName;
    /**
     * @var
     */
    protected $contact;
    /**
     * @var
     */
    protected $sex;
    /**
     * @var
     */
    protected $address;
    /**
     * @var
     */
    protected $postalcode;
    /**
     * @var
     */
    protected $city;
    /**
     * @var
     */
    protected $country;
    /**
     * @var
     */
    protected $address2;
    /**
     * @var
     */
    protected $postalcode2;
    /**
     * @var
     */
    protected $city2;
    /**
     * @var
     */
    protected $country2;
    /**
     * @var
     */
    protected $phone;
    /**
     * @var
     */
    protected $mobile;
    /**
     * @var
     */
    protected $fax;
    /**
     * @var
     */
    protected $email;
    /**
     * @var
     */
    protected $website;
    /**
     * @var
     */
    protected $note;
    /**
     * @var
     */
    protected $bankacocunt;
    /**
     * @var
     */
    protected $giroaccount;
    /**
     * @var
     */
    protected $vatregistrationnumber;
    /**
     * @var
     */
    protected $preamble;
    /**
     * @var
     */
    protected $iban;
    /**
     * @var
     */
    protected $bic;
    /**
     * @var string
     */
    protected $companyPerson = 'C';
    /**
     * @var
     */
    protected $freeField_1;
    /**
     * @var
     */
    protected $freeField_2;
    /**
     * @var
     */
    protected $freeField_3;
    /**
     * @var
     */
    protected $freeField_4;
    /**
     * @var
     */
    protected $freeField_5;
    /**
     * @var
     */
    protected $freeField_6;
    /**
     * @var
     */
    protected $freeField_7;
    /**
     * @var
     */
    protected $freeField_8;
    /**
     * @var
     */
    protected $freeField_9;
    /**
     * @var
     */
    protected $freeField_10;
    /**
     * @var int
     */
    protected $memberAdministration = 0;
    /**
     * @var
     */
    protected $ledgerAccount_id = 0;
    /**
     * @var
     */
    protected $noEmail = 0;
    /**
     * @var
     */
    protected $newsletterGroupCount = 0;

    /**
     * @param mixed $id
     * @return Relation
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param mixed $creationDate
     * @return Relation
     */
    public function setCreationDate($creationDate)
    {
        if($creationDate === null || $creationDate === '') {
            $this->creationDate = date("Y-m-d");
        }
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * @param mixed $relationCode
     * @return Relation
     */
    public function setRelationCode($relationCode)
    {
        $this->relationCode = $relationCode;
        return $this;
    }

    /**
     * @param mixed $companyName
     * @return Relation
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
        return $this;
    }

    /**
     * @param mixed $contact
     * @return Relation
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
        return $this;
    }

    /**
     * @param mixed $sex
     * @return Relation
     */
    public function setSex($sex)
    {
        $acceptedvalues = ['M', 'm', 'V', 'v', ''];
        if(!in_array($sex, $acceptedvalues)) {
            throw new \Exception('Sex must be empty string, null, M or V');
        }

        $this->sex = $sex;
        return $this;
    }

    /**
     * @param mixed $address
     * @return Relation
     * @throws \Exception
     */
    public function setAddress($address)
    {
        if(mb_strlen($address) > 150) {
            throw new \Exception('Address may not exceed the length of 150 characters');
        }
        $this->address = $address;
        return $this;
    }

    /**
     * @param mixed $postalcode
     * @return Relation
     * @throws \Exception
     */
    public function setPostalcode($postalcode)
    {
        if(mb_strlen($postalcode) > 50) {
            throw new \Exception('Postalcode may not exceed the length of 50 characters');
        }
        $this->postalcode = $postalcode;
        return $this;
    }

    /**
     * @param mixed $city
     * @return Relation
     * @throws \Exception
     */
    public function setCity($city)
    {
        if(mb_strlen($city) > 50) {
            throw new \Exception('City may not exceed the length of 50 characters');
        }
        $this->city = $city;
        return $this;
    }

    /**
     * @param mixed $country
     * @return Relation
     * @throws \Exception
     */
    public function setCountry($country)
    {
        if(mb_strlen($country) > 50) {
            throw new \Exception('Country may not exceed the length of 50 characters');
        }
        $this->country = $country;
        return $this;
    }

    /**
     * @param mixed $address2
     * @return Relation
     * @throws \Exception
     */
    public function setAddress2($address2)
    {
        if(mb_strlen($address2) > 150) {
            throw new \Exception('Address2 may not exceed the length of 150 characters');
        }
        $this->address2 = $address2;
        return $this;
    }

    /**
     * @param mixed $postalcode2
     * @return Relation
     * @throws \Exception
     */
    public function setPostalcode2($postalcode2)
    {
        if(mb_strlen($postalcode2) > 50) {
            throw new \Exception('Postalcode2 may not exceed the length of 50 characters');
        }
        $this->postalcode2 = $postalcode2;
        return $this;
    }

    /**
     * @param mixed $city2
     * @return Relation
     * @throws \Exception
     */
    public function setCity2($city2)
    {
        if(mb_strlen($city2) > 50) {
            throw new \Exception('City2 may not exceed the length of 50 characters');
        }
        $this->city2 = $city2;
        return $this;
    }

    /**
     * @param mixed $country2
     * @return Relation
     * @throws \Exception
     */
    public function setCountry2($country2)
    {
        if(mb_strlen($country2) > 50) {
            throw new \Exception('Country2 may not exceed the length of 50 characters');
        }
        $this->country2 = $country2;
        return $this;
    }

    /**
     * @param mixed $phone
     * @return Relation
     * @throws \Exception
     */
    public function setPhone($phone)
    {
        if(mb_strlen($phone) > 50) {
            throw new \Exception('Phone may not exceed the length of 50 characters');
        }
        $this->phone = $phone;
        return $this;
    }

    /**
     * @param mixed $mobile
     * @return Relation
     * @throws \Exception
     */
    public function setMobile($mobile)
    {
        if(mb_strlen($mobile) > 50) {
            throw new \Exception('Mobile may not exceed the length of 50 characters');
        }
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * @param mixed $fax
     * @return Relation
     * @throws \Exception
     */
    public function setFax($fax)
    {
        if(mb_strlen($fax) > 50) {
            throw new \Exception('Fax may not exceed the length of 50 characters');
        }
        $this->fax = $fax;
        return $this;
    }

    /**
     * @param mixed $email
     * @return Relation
     * @throws \Exception
     */
    public function setEmail($email)
    {
        if(mb_strlen($email) > 150) {
            throw new \Exception('Email may not exceed the length of 150 characters');
        }
        $this->email = $email;
        return $this;
    }

    /**
     * @param mixed $website
     * @return Relation
     */
    public function setWebsite($website)
    {
        $this->website = $website;
        return $this;
    }

    /**
     * @param mixed $note
     * @return Relation
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @param mixed $bankacocunt
     * @return Relation
     */
    public function setBankacocunt($bankacocunt)
    {
        $this->bankacocunt = $bankacocunt;
        return $this;
    }

    /**
     * @param mixed $giroaccount
     * @return Relation
     */
    public function setGiroaccount($giroaccount)
    {
        $this->giroaccount = $giroaccount;
        return $this;
    }

    /**
     * @param mixed $vatregistrationnumber
     * @return Relation
     * @throws \Exception
     */
    public function setVatregistrationnumber($vatregistrationnumber)
    {
        if(mb_strlen($vatregistrationnumber) > 50) {
            throw new \Exception('vatregistrationnumber may not exceed the length of 50 characters');
        }
        $this->vatregistrationnumber = $vatregistrationnumber;
        return $this;
    }

    /**
     * @param mixed $preamble
     * @return Relation
     * @throws \Exception
     */
    public function setPreamble($preamble)
    {
        if(mb_strlen($preamble) > 50) {
            throw new \Exception('Preamble may not exceed the length of 50 characters');
        }
        $this->preamble = $preamble;
        return $this;
    }

    /**
     * @param mixed $iban
     * @return Relation
     * @throws \Exception
     */
    public function setIban($iban)
    {
        if(mb_strlen($iban) > 50) {
            throw new \Exception('IBAN may not exceed the length of 50 characters');
        }
        $this->iban = $iban;
        return $this;
    }

    /**
     * @param mixed $bic
     * @return Relation
     * @throws \Exception
     */
    public function setBic($bic)
    {
        if(mb_strlen($bic) > 50) {
            throw new \Exception('BIC may not exceed the length of 50 characters');
        }
        $this->bic = $bic;
        return $this;
    }

    /**
     * @param mixed $companyPerson
     * @return Relation
     * @throws \Exception
     */
    public function setCompanyPerson($companyPerson)
    {
        $acceptedValues = ['P', 'C'];

        if(in_array($companyPerson, $acceptedValues)) {
            $this->companyPerson = $companyPerson;
            return $this;
        }

        throw new \Exception('CompanyPerson may only have the values P (for Person) or C (for Company)');
    }

    /**
     * @param mixed $freeField_1
     * @return Relation
     * @throws \Exception
     */
    public function setFreeField1($freeField_1)
    {
        if(mb_strlen($freeField_1) > 100) {
            throw new \Exception('FreeField1 may not exceed the length of 100 characters');
        }
        $this->freeField_1 = $freeField_1;
        return $this;
    }

    /**
     * @param mixed $freeField_2
     * @return Relation
     * @throws \Exception
     */
    public function setFreeField2($freeField_2)
    {
        if(mb_strlen($freeField_2) > 100) {
            throw new \Exception('FreeField2 may not exceed the length of 100 characters');
        }
        $this->freeField_2 = $freeField_2;
        return $this;
    }

    /**
     * @param mixed $freeField_3
     * @return Relation
     * @throws \Exception
     */
    public function setFreeField3($freeField_3)
    {
        if(mb_strlen($freeField_3) > 100) {
            throw new \Exception('FreeField3 may not exceed the length of 100 characters');
        }
        $this->freeField_3 = $freeField_3;
        return $this;
    }

    /**
     * @param mixed $freeField_4
     * @return Relation
     * @throws \Exception
     */
    public function setFreeField4($freeField_4)
    {
        if(mb_strlen($freeField_4) > 100) {
            throw new \Exception('FreeField4 may not exceed the length of 100 characters');
        }
        $this->freeField_4 = $freeField_4;
        return $this;
    }

    /**
     * @param mixed $freeField_5
     * @return Relation
     * @throws \Exception
     */
    public function setFreeField5($freeField_5)
    {
        if(mb_strlen($freeField_5) > 100) {
            throw new \Exception('FreeField5 may not exceed the length of 100 characters');
        }
        $this->freeField_5 = $freeField_5;
        return $this;
    }

    /**
     * @param mixed $freeField_6
     * @return Relation
     * @throws \Exception
     */
    public function setFreeField6($freeField_6)
    {
        if(mb_strlen($freeField_6) > 100) {
            throw new \Exception('FreeField6 may not exceed the length of 100 characters');
        }
        $this->freeField_6 = $freeField_6;
        return $this;
    }

    /**
     * @param mixed $freeField_7
     * @return Relation
     * @throws \Exception
     */
    public function setFreeField7($freeField_7)
    {
        if(mb_strlen($freeField_7) > 100) {
            throw new \Exception('FreeField7 may not exceed the length of 100 characters');
        }
        $this->freeField_7 = $freeField_7;
        return $this;
    }

    /**
     * @param mixed $freeField_8
     * @return Relation
     * @throws \Exception
     */
    public function setFreeField8($freeField_8)
    {
        if(mb_strlen($freeField_8) > 100) {
            throw new \Exception('FreeField8 may not exceed the length of 100 characters');
        }
        $this->freeField_8 = $freeField_8;
        return $this;
    }

    /**
     * @param mixed $freeField_9
     * @return Relation
     * @throws \Exception
     */
    public function setFreeField9($freeField_9)
    {
        if(mb_strlen($freeField_9) > 100) {
            throw new \Exception('FreeField9 may not exceed the length of 100 characters');
        }
        $this->freeField_9 = $freeField_9;
        return $this;
    }

    /**
     * @param mixed $freeField_10
     * @return Relation
     * @throws \Exception
     */
    public function setFreeField10($freeField_10)
    {
        if(mb_strlen($freeField_10) > 100) {
            throw new \Exception('FreeField10 may not exceed the length of 100 characters');
        }
        $this->freeField_10 = $freeField_10;
        return $this;
    }

    /**
     * @param int $memberAdministration
     * @return Relation
     */
    public function setMemberAdministration($memberAdministration)
    {
        $this->memberAdministration = $memberAdministration;
        return $this;
    }

    /**
     * @param mixed $ledgerAccount_id
     * @return Relation
     * @throws \Exception
     */
    public function setLedgerAccountId($ledgerAccount_id)
    {
        if(mb_strlen($ledgerAccount_id) > 100) {
            throw new \Exception('LedgerAccountId may not exceed the length of 100 characters');
        }
        $this->ledgerAccount_id = $ledgerAccount_id;
        return $this;
    }

    /**
     * @param mixed $noEmail
     * @return Relation
     * @throws \Exception
     */
    public function setNoEmail($noEmail)
    {
        if(mb_strlen($noEmail) > 100) {
            throw new \Exception('NoEmail may not exceed the length of 100 characters');
        }
        $this->noEmail = $noEmail;
        return $this;
    }

    /**
     * @param mixed $newsletterGroupCount
     * @return Relation
     * @throws \Exception
     */
    public function setNewsletterGroupCount($newsletterGroupCount)
    {
        if(mb_strlen($newsletterGroupCount) > 100) {
            throw new \Exception('NewsLetterGroupCount may not exceed the length of 100 characters');
        }
        $this->newsletterGroupCount = $newsletterGroupCount;
        return $this;
    }

    /**
     *
     */
    private function checkCompanyName()
    {
        if($this->companyName === null || $this->companyName === '') {
            if($this->companyPerson === 'person') {
                $this->companyName = $this->contact;
            } else {
                $this->companyName = "UNKNOWN";
            }
        }

        if(mb_strlen($this->companyName) > 100) {
            throw new \Exception('companyName may not exceed the length of 100 characters');
        }
    }

    /**
     *
     */
    private function checkRelationCode()
    {
        if($this->relationCode === null || $this->relationCode === '') {
            $this->relationCode = substr($this->companyName, 0, 8) . date('mY');
        }

        if(mb_strlen($this->relationCode) > 15) {
            throw new \Exception('relationCode may not exceed the length of 15 characters');
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getEboekhoudenArray()
    {
        $this->checkCompanyName();
        $this->checkRelationCode();

        if($this->relationCode == '' || $this->companyName == '') {
            throw new \Exception('RelationCode and CompanyName are mandatory fields.');
        }

        return [
            "ID" => $this->id,
            "AddDatum" => $this->creationDate,
            "Code" => $this->relationCode,
            "Bedrijf" => $this->companyName,
            "Contactpersoon" => $this->contact,
            "Geslacht" => $this->sex,
            "Adres" => $this->address,
            "Postcode" => $this->postalcode,
            "Plaats" => $this->city,
            "Land" => $this->country,
            "Adres2" => $this->address2,
            "Postcode2" => $this->postalcode2,
            "Plaats2" => $this->city2,
            "Land2" => $this->country2,
            "Telefoon" => $this->phone,
            "GSM" => $this->mobile,
            "FAX" => $this->fax,
            "Email" => $this->email,
            "Site" => $this->website,
            "Notitie" => $this->note,
            "Bankrekening" => $this->bankacocunt,
            "Girorekening" => $this->giroaccount,
            "BTWNummer" => $this->vatregistrationnumber,
            "Aanhef" => $this->preamble,
            "IBAN" => $this->iban,
            "BIC" => $this->bic,
            "BP" => $this->companyPerson,
            "Def1" => $this->freeField_1,
            "Def2" => $this->freeField_2,
            "Def3" => $this->freeField_3,
            "Def4" => $this->freeField_4,
            "Def5" => $this->freeField_5,
            "Def6" => $this->freeField_6,
            "Def7" => $this->freeField_7,
            "Def8" => $this->freeField_8,
            "Def9" => $this->freeField_9,
            "Def10" => $this->freeField_10,
            "LA" => $this->memberAdministration,
            "Gb_ID" => $this->ledgerAccount_id,
            "GeenEmail" => $this->noEmail,
            "NieuwsbriefgroepenCount" => $this->newsletterGroupCount,
        ];
    }
}
