<?php

namespace agentur1601com;

use Exception;
use SoapHeader;
use SoapClient;
use SoapParam;

class BonCardSoap
{
    /**
     * @var int 1|2 $_soapVersion
     */
    protected $_soapVersion = SOAP_1_2;

    /**
     * url to get commands, vars and functions - so you have not to set them manuel
     * @example "https://www.boncard-payment-services.ch/ps_switch2/WSWebShopService.asmx?WSDL"
     *
     * @var string $_wsdl_url
     */
    protected $_wsdl_url;

    /**
     * @var string $_encoding
     */
    protected $_encoding = "UTF-8";

    /**
     * If 1 you can get the request and response xml and headers
     * @example 0 | 1
     * @var int $_trace
     */
    protected $_trace = 1;

    /**
     * Timeout after x seconds
     * @var int $_timeout
     */
    protected $_timeout = 20;

    /**
     * @var bool $_exception
     */
    protected $_exception = false;

    /**
     * For auth
     * @var string $_userId
     */
    protected $_userId;

    /**
     * For auth
     * @var string $_password
     */
    protected $_password;

    /**
     * @var SoapHeader $_soapHeader
     */
    protected $_soapHeader;

    /**
     * @var SoapClient $_soapClient
     */
    protected $_soapClient;

    /**
     * Contains data for request
     * @var array $_soapData
     */
    protected $_soapData;

    /**
     * Contains the last call
     * @var \stdClass $_lastCall
     */
    protected $_lastCallResponse;

    /**
     * BonCardSoap constructor.
     * @param null $productive
     */
    public function __construct($productive = null)
    {
        $this->_wsdl_url = "https://www.boncard-payment-services.ch/ps_switch2/WSWebShopService.asmx?WSDL";

        if($productive === true)
        {
            $this->_wsdl_url = "https://www.boncard-payment-services.ch/ps_switch/WSWebShopService.asmx?WSDL";
        }
    }

    /**
     * @param int $soapVersion
     * @return BonCardSoap
     */
    public function setSoapVersion(int $soapVersion = SOAP_1_2) : self
    {
        $this->_soapVersion = $soapVersion;

        return $this;
    }

    /**
     * @param string $wsdlUrl
     * @return BonCardSoap
     */
    public function setWsdlUrl(string $wsdlUrl) : self
    {
        $this->_wsdl_url = $wsdlUrl;

        return $this;
    }

    /**
     * @param string $encoding
     * @return BonCardSoap
     */
    public function setEncoding(string $encoding = "UTF-8") : self
    {
        $this->_encoding = $encoding;

        return $this;
    }

    /**
     * @param int $trace
     * @return BonCardSoap
     */
    public function setTrace(int $trace = 1) : self
    {
        $this->_trace = $trace;

        return $this;
    }

    /**
     * @param int $timeout
     * @return BonCardSoap
     */
    public function setTimeout(int $timeout = 20) : self
    {
        $this->_timeout = $timeout;

        return $this;
    }

    /**
     * @param bool $exception
     * @return BonCardSoap
     */
    public function setException(bool $exception) : self
    {
        $this->_exception = $exception;

        return $this;
    }

    /**
     * @param string $userId
     * @return BonCardSoap
     */
    public function setUserId(string $userId) : self
    {
        $this->_userId = $userId;

        return $this;
    }

    /**
     * @param string $password
     * @return BonCardSoap
     */
    public function setPassword(string $password) : self
    {
        $this->_password = $password;

        return $this;
    }

    /**
     * @return BonCardSoap
     * @throws Exception
     */
    public function createSoapHeader() : self
    {
        if(!$this->_userId || !$this->_password)
        {
            throw new Exception("UserId / Password has to be set");
        }

        if(!$this->_soapClient)
        {
            throw new Exception("SOAP Client has to be created");
        }

        $this->_soapHeader = new SoapHeader(
            "https://www.boncard-payment-services.ch/ps_switch/",
            "MyHeader",
            [
                "UserId" => $this->_userId,
                "Password" => $this->_password
            ]
        );

        $this->_soapClient->__setSoapHeaders($this->_soapHeader);

        return $this;
    }

    /**
     * @return SoapHeader
     */
    public function getSoapHeader() : SoapHeader
    {
        return $this->_soapHeader;
    }

    /**
     * @return BonCardSoap
     */
    public function clearSoapHeader() : self
    {
        $this->_soapClient->__setSoapHeaders();

        return $this;
    }

    /**
     * @return BonCardSoap
     * @throws Exception
     */
    public function createSoapClient() : self
    {
        if(!$this->_soapVersion === null)
        {
            throw new Exception("SOAP Version has to be set");
        }

        if(!$this->_wsdl_url === null)
        {
            throw new Exception("WSDL URL has to be set");
        }

        if(!$this->_encoding === null)
        {
            throw new Exception("Encoding has to be set");
        }

        if(!$this->_trace === null)
        {
            throw new Exception("Trace has to be set");
        }

        if(!$this->_timeout === null)
        {
            throw new Exception("Timeout has to be set");
        }

        if(!$this->_exception === null)
        {
            throw new Exception("Exception has to be set");
        }

        $this->_soapClient = new SoapClient(
            $this->_wsdl_url,
            [
                'soap_version'          => $this->_soapVersion,
                'cache_wsdl'            => WSDL_CACHE_NONE,
                'encoding'              => $this->_encoding,
                'trace'                 => $this->_trace,
                'connection_timeout'    => $this->_timeout,
                'exceptions'            => $this->_exception,
            ]
        );

        return $this;
    }

    /**
     * @return SoapClient
     */
    public function getSoapClient() : SoapClient
    {
        return $this->_soapClient;
    }

    /**
     * @param array $soapDataArr
     * @return BonCardSoap
     */
    public function setSoapData(array $soapDataArr) : self
    {
        $this->_soapData = [];

        foreach ($soapDataArr as $key => $value)
        {
            $this->_soapData[] = new SoapParam($value, $key);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getSoapData() : array
    {
        return $this->_soapData;
    }

    /**
     * @param string $function
     * @return mixed
     * @throws Exception
     */
    public function sendRequest(string $function)
    {
        if(!$this->_soapClient)
        {
            throw new Exception("Soap Client has to be created");
        }

        if(!$this->_soapHeader)
        {
            throw new Exception("Soap Header has to be created");
        }

        $this->_lastCallResponse = $this->_soapClient->__soapCall(
            $function,
            $this->_soapData
        );

        return $this->_lastCallResponse;
    }

    /**
     * Return pdf as stream or file path
     * @param string|null $pdfPath
     * @return bool|string
     */
    public function getPDF(string $pdfPath = null)
    {
        if(!$this->_lastCallResponse->{"pdfData"})
        {
            return false;
        }

        if($pdfPath === null)
        {
            return $this->_lastCallResponse->{"pdfData"};
        }

        file_put_contents($pdfPath, $this->_lastCallResponse->{"pdfData"});

        return $pdfPath;
    }

    /**
     * @param string $xml
     * @return mixed
     */
    public function simpleParseXML(string $xml)
    {
        return str_replace([">"],[">\n"],$xml);
    }
}