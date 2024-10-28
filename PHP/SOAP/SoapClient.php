<?php 

// Initialize the SoapClient using a WSDL URL
$wsdl = "http://www.example.com/soap?wsdl";
$client = new SoapClient($wsdl);

// Prepare the parameters for the SOAP request
$params = [
    'param1' => 'value1',
    'param2' => 'value2',
];

try {
    // Make the SOAP call and get the response
    $response = $client->__soapCall('MethodName', [$params]);

    // Display the response
    echo "Response: ";
    print_r($response);
} catch (SoapFault $fault) {
    // Handle any errors
    echo "Error: " . $fault->getMessage();
}