## boncard - SOAP API (PHP)

how to use:

```
require_once __DIR__."/BonCardSoap.php";

$BonCardObj = new \agentur1601com\BonCardSoap();

$BonCardObj
    ->setSoapVersion(SOAP_1_2)
    ->setWsdlUrl("https://www.boncard-payment-services.ch/ps_switch2/WSWebShopService.asmx?WSDL")
    ->setEncoding("UTF-8")
    ->setTrace(1)
    ->setTimeout(10)
    ->setException(false)
    ->setUserId("XXXXXXXXX")
    ->setPassword("*********");
    
$BonCardObj->createSoapClient();

$BonCardObj->createSoapHeader();

$functionName = "CreatePrintAtHomeVoucher";

$dataArrayCreatePrintAtHomeVoucher = [
    $functionName => [
        'preview'           => false,
        'shopId'            => "SHOP_ID",
        'templateAlias'     => "SHOP_ID_TEMPLATE_ALIAS_1",
        'senderName'        => "SENDER_NAME",
        'receiverName'      => "KUNDEN_NAME",
        'title'             => "TITLE",
        'message'           => "MESSAGE",
        'image1'            => null,
        'image2'            => null,
        'image3'            => null,
        'image4'            => null,
        'orderNumber'       => "01010101",
        'orderNumberItem'   => "1",
        'amount'            => 1.00,
        'currency'          => "CHF",
        'language'          => 1,
    ]
];

$BonCardObj->setSoapData($dataArrayCreatePrintAtHomeVoucher);

try
{
    $BonCardObj->sendRequest($functionName);

    $downloadFileName = "myDownload_".random_int(100,999).".pdf";
    header ("Content-Type: application/pdf");
    header ("Content-Disposition: attachment; filename=\"$downloadFileName\"");
    echo $BonCardObj->getPDF();
}
catch (Exception $e)
{
    die($e);
}
```