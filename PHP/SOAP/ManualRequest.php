<?php
// Define the SOAP endpoint and action
$endpoint = "http://www.example.com/soap";
$action = "http://www.example.com/soap/MethodName";

// Create the SOAP request body
$xmlRequest = '<?xml version="1.0" encoding="UTF-8"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns="http://www.example.com/namespace">
  <soap:Body>
    <ns:MethodName>
      <ns:param1>value1</ns:param1>
      <ns:param2>value2</ns:param2>
    </ns:MethodName>
  </soap:Body>
</soap:Envelope>';

// Set the headers for the request
$headers = [
    "Content-Type: text/xml; charset=utf-8",
    "Content-Length: " . strlen($xmlRequest),
    "SOAPAction: $action",
];

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $endpoint);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlRequest);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Send the request and get the response
$response = curl_exec($ch);

// Check for errors
if ($response === false) {
    echo "cURL Error: " . curl_error($ch);
} else {
    echo "Response: ";
    echo htmlspecialchars($response);
}

// Close cURL
curl_close($ch);
?>
