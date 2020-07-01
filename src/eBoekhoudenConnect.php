<?php

namespace bobkosse\eBoekhouden;

use bobkosse\eBoekhouden\ValueObjects\AccountLedgerCategory;
use bobkosse\eBoekhouden\ValueObjects\AccountLedgerCode;
use bobkosse\eBoekhouden\ValueObjects\AccountLedgerId;
use bobkosse\eBoekhouden\ValueObjects\Date;
use bobkosse\eBoekhouden\ValueObjects\InvoiceNumber;
use bobkosse\eBoekhouden\ValueObjects\MutationId;
use bobkosse\eBoekhouden\ValueObjects\RelationCode;
use bobkosse\eBoekhouden\ValueObjects\RelationId;
use bobkosse\eBoekhouden\ValueObjects\RelationSearch;

/**
 * Class eBoekhoudenConnect
 * @package bobkosse\eBoekhouden
 */
class eBoekhoudenConnect
{
    /**
     * @var
     */
    private $sessionId;

    /**
     * @var
     */
    private $securityCode2;

    /**
     * @var \SoapClient
     */
    private $soapClient;

    /**
     * eBoekhoudenConnect constructor.
     * @param $username
     * @param $securityCode1
     * @param $securityCode2
     * @param bool $debug
     * @throws \SoapFault
     */
    public function __construct($username, $securityCode1, $securityCode2, $debug = false)
    {
        $this->soapClient = new \SoapClient("https://soap.e-boekhouden.nl/soap.asmx?WSDL",
            $debug ? ['trace' => true] : []);

        $params = [
            "Username" => $username,
            "SecurityCode1" => $securityCode1,
            "SecurityCode2" => $securityCode2
        ];
        $response = $this->soapClient->__soapCall("OpenSession", array($params));
        $this->checkforerror($response, "OpenSessionResult");
        $this->sessionId = $response->OpenSessionResult->SessionID;
        $this->securityCode2 = $securityCode2;
    }

    /**
     * @param $rawresponse
     * @param $sub
     *
     * @throws \SoapFault
     */
    private function checkforerror($rawresponse, $sub)
    {
        if(isset($rawresponse->$sub->ErrorMsg->LastErrorCode)) {
            $LastErrorCode = $rawresponse->$sub->ErrorMsg->LastErrorCode;
            $LastErrorDescription = $rawresponse->$sub->ErrorMsg->LastErrorDescription;
            if($LastErrorCode <> '') {
                throw new \SoapFault($LastErrorCode, $LastErrorDescription, null,
                    $this->soapClient->__getLastRequest());
            }
        }
    }

    /**
     * @return string
     */
    public function getDebugInfo(){
        return 'Last SOAP request: '.$this->soapClient->__getLastRequest();
    }

    /**
     * @throws \SoapFault
     */
    public function __destruct()
    {
        $params = array(
            "SessionID" => $this->sessionId
        );
        return $this->soapClient->__soapCall("CloseSession", array($params));
    }

    /**
     *
     */
    public function addInvoice()
    {

    }

    /**
     *
     * @param LedgerAccount $ledgerAccount
     * @return
     * @throws \SoapFault
     */
    public function addLedgerAccount(LedgerAccount $ledgerAccount)
    {
        $params = [
            "SecurityCode2" => $this->securityCode2,
            "SessionID" => $this->sessionId,
            "oGb" => $ledgerAccount->getLedgerAccountArray()
        ];

        $response = $this->soapClient->__soapCall("AddGrootboekrekening", [$params]);

        $this->checkforerror($response, "AddGrootboekrekeningResponse");
        return $response->AddGrootboekrekeningResult;
    }

    /**
     * @param Mutation $mutation
     * @return
     * @throws \SoapFault
     */
    public function addMutation(Mutation $mutation)
    {
        $params = [
            "SecurityCode2" => $this->securityCode2,
            "SessionID" => $this->sessionId,
            "oMut" => $mutation->getMutationArray()
        ];

        $response = $this->soapClient->__soapCall("AddMutatie", [$params]);

        $this->checkforerror($response, "AddMutatieResult");
        return $response->AddMutatieResult;
    }

    /**
     * @param Relation $relation
     * @return mixed
     * @throws \SoapFault
     */
    public function addRelation(Relation $relation)
    {
        $params = [
            "SecurityCode2" => $this->securityCode2,
            "SessionID" => $this->sessionId,
            "oRel" => $relation->getEboekhoudenArray()
        ];

        $response = $this->soapClient->__soapCall("AddRelatie", [$params]);

        $this->checkforerror($response, "AddRelatieResult");
        return $response->AddRelatieResult;
    }

    /**
     * @param $dateFrom
     * @param $toDate
     * @param null $invoiceNumber
     * @param null $relationCode
     * @return mixed
     * @throws \Exception
     */
    public function getInvoices($dateFrom, $toDate, $invoiceNumber = null, $relationCode = null)
    {
        $dateFrom = new Date($dateFrom);
        $toDate = new Date($toDate);
        $invoiceNumber = new InvoiceNumber($invoiceNumber);
        $relationCode = new RelationCode($relationCode);

        $params = [
            "SecurityCode2" => $this->securityCode2,
            "SessionID" => $this->sessionId,
            "cFilter" => [
                "Factuurnummer" => $invoiceNumber->__toString(),
                "Relatiecode" => $relationCode->__toString(),
                "DatumVan" => $dateFrom->__toString(),
                "DatumTm" => $toDate->__toString()
            ]
        ];

        $response = $this->soapClient->__soapCall("GetFacturen", [$params]);

        $this->checkforerror($response, "GetFacturenResult");
        return $response->GetFacturenResult;
    }

    /**
     * @param null $id
     * @param null $accountLedgerCode
     * @param null $category
     * @return mixed
     * @throws \SoapFault
     */
    public function getLedgerAccounts($id = null, $accountLedgerCode = null, $category = null)
    {
        $id = new AccountLedgerId($id);
        $accountLedgerCode = new AccountLedgerCode($accountLedgerCode);
        $category = new AccountLedgerCategory($category);

        $params = [
            "SecurityCode2" => $this->securityCode2,
            "SessionID" => $this->sessionId,
            "cFilter" => [
                "ID" => (string)$id->toInt(),
                "Code" => $accountLedgerCode->__toString(),
                "Categorie" => $category->__toString()
            ]
        ];

        $response = $this->soapClient->__soapCall("GetGrootboekrekeningen", [$params]);

        $this->checkforerror($response, "GetGrootboekrekeningenResult");
        return $response->GetGrootboekrekeningenResult;
    }

    /**
     * @param $dateFrom
     * @param $toDate
     * @return mixed
     * @throws \SoapFault
     */
    public function getMutationsByPeriod($dateFrom, $toDate)
    {
        $dateFrom = new Date($dateFrom);
        $toDate = new Date($toDate);

        $params = [
            "SecurityCode2" => $this->securityCode2,
            "SessionID" => $this->sessionId,
            "cFilter" => [
                "MutatieNr" => 0,
                "MutatieNrVan" => "",
                "MutatieNrTm" => "",
                "Factuurnummer" => "",
                "DatumVan" => $dateFrom->__toString(),
                "DatumTm" => $toDate->__toString()
            ]
        ];

        return $this->performGetMutationsRequest($params);
    }

    /**
     * @param $params
     * @return mixed
     * @throws \SoapFault
     */
    private function performGetMutationsRequest($params)
    {
        $response = $this->soapClient->__soapCall("GetMutaties", [$params]);

        $this->checkforerror($response, "GetMutatiesResult");
        return $response->GetMutatiesResult;
    }

    /**
     * @param $mutationId
     * @return mixed
     */
    public function getMutationsByMutationId($mutationId)
    {
        $mutationId = new MutationId($mutationId);

        $params = [
            "SecurityCode2" => $this->securityCode2,
            "SessionID" => $this->sessionId,
            "cFilter" => [
                "MutatieNr" => $mutationId->toInt(),
                "MutatieNrVan" => "",
                "MutatieNrTm" => "",
                "Factuurnummer" => "",
                "DatumVan" => "1980-01-01",
                "DatumTm" => "2049-12-31"
            ]
        ];
        return $this->performGetMutationsRequest($params);
    }

    /**
     * @param $startMutationId
     * @param $endMutationId
     * @return mixed
     */
    public function getMutationsByMutationsInRange($startMutationId, $endMutationId)
    {
        $startMutationId = new MutationId($startMutationId);
        $endMutationId = new MutationId($endMutationId);

        $params = [
            "SecurityCode2" => $this->securityCode2,
            "SessionID" => $this->sessionId,
            "cFilter" => [
                "MutatieNr" => 0,
                "MutatieNrVan" => $startMutationId->toInt(),
                "MutatieNrTm" => $endMutationId->toInt(),
                "Factuurnummer" => "",
                "DatumVan" => "1980-01-01",
                "DatumTm" => "2049-12-31"
            ]
        ];
        return $this->performGetMutationsRequest($params);
    }

    /**
     * @param $invoiceNr
     * @return mixed
     */
    public function getMutationsByInvoiceNumber($invoiceNr)
    {
        $invoiceNr = new InvoiceNumber($invoiceNr);

        $params = [
            "SecurityCode2" => $this->securityCode2,
            "SessionID" => $this->sessionId,
            "cFilter" => [
                "MutatieNr" => 0,
                "MutatieNrVan" => "",
                "MutatieNrTm" => "",
                "Factuurnummer" => $invoiceNr->__toString(),
                "DatumVan" => "1980-01-01",
                "DatumTm" => "2049-12-31"
            ]
        ];
        return $this->performGetMutationsRequest($params);
    }

    /**
     * @return mixed
     * @throws \SoapFault
     */
    public function getVacantPostsDebtors()
    {
        $params = [
            "SecurityCode2" => $this->securityCode2,
            "SessionID" => $this->sessionId,
            "OpSoort" => "Debiteuren"
        ];

        $response = $this->soapClient->__soapCall("GetOpenPosten", [$params]);

        $this->checkforerror($response, "GetOpenPostenResult");
        return $response->GetOpenPostenResult;
    }

    /**
     * @return mixed
     * @throws \SoapFault
     */
    public function getVacantPostsCreditors()
    {
        $params = [
            "SecurityCode2" => $this->securityCode2,
            "SessionID" => $this->sessionId,
            "OpSoort" => "Crediteuren"
        ];

        $response = $this->soapClient->__soapCall("GetOpenPosten", [$params]);

        $this->checkforerror($response, "GetOpenPostenResult");
        return $response->GetOpenPostenResult;
    }

    /**
     *
     */
    public function getAllRelations()
    {
        $params = [
            "SecurityCode2" => $this->securityCode2,
            "SessionID" => $this->sessionId,
            "cFilter" => [
                "Trefwoord" => "",
                "Code" => "",
                "ID" => ""
            ]
        ];

        return $this->getRelations($params);
    }

    /**
     * @param $params
     * @return mixed
     * @throws \SoapFault
     */
    private function getRelations($params)
    {
        $response = $this->soapClient->__soapCall("GetRelaties", [$params]);

        $this->checkforerror($response, "GetRelatiesResult");
        return $response->GetRelatiesResult;
    }

    /**
     * @param $relationId
     * @return mixed
     */
    public function getRelationById($relationId)
    {
        $relationId = new RelationId($relationId);

        $params = [
            "SecurityCode2" => $this->securityCode2,
            "SessionID" => $this->sessionId,
            "cFilter" => [
                "Trefwoord" => "",
                "Code" => "",
                "ID" => $relationId->toInt()
            ]
        ];

        return $this->getRelations($params);
    }

    /**
     * @param $relationCode
     * @return mixed
     */
    public function getRelationByCode($relationCode)
    {
        $relationCode = new RelationCode($relationCode);

        $params = [
            "SecurityCode2" => $this->securityCode2,
            "SessionID" => $this->sessionId,
            "cFilter" => [
                "Trefwoord" => "",
                "Code" => $relationCode->__toString(),
                "ID" => ""
            ]
        ];

        return $this->getRelations($params);
    }

    /**
     * @param $searchString
     * @return mixed
     */
    public function getRelationBySearch($searchString)
    {
        $searchString = new RelationSearch($searchString);

        $params = [
            "SecurityCode2" => $this->securityCode2,
            "SessionID" => $this->sessionId,
            "cFilter" => [
                "Trefwoord" => $searchString->__toString(),
                "Code" => "",
                "ID" => ""
            ]
        ];

        return $this->getRelations($params);
    }

    /**
     *
     */
    public function updateLedgerAccount()
    {

    }

    /**
     *
     */
    public function updateRelation()
    {

    }
}
