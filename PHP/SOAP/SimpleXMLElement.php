<?php

//Parsing and Reading XML Data
$xmlString = <<<XML
<?xml version="1.0"?>
<note>
  <to>Tove</to>
  <from>Jani</from>
  <heading>Reminder</heading>
  <body>Don't forget me this weekend!</body>
</note>
XML;

$xml = new SimpleXMLElement($xmlString);

// Access elements as properties
echo $xml->to;      // Output: Tove
echo $xml->from;    // Output: Jani
echo $xml->body;    // Output: Don't forget me this weekend!


//Modifying XML Data
$xml = new SimpleXMLElement('<root><item>Item 1</item></root>');

// Add a new element
$xml->addChild('item', 'Item 2');

// Modify an existing element
$xml->item[0] = 'Updated Item 1';

// Output the modified XML
echo $xml->asXML();

//Converting XML to an Array

$xmlString = '<root><item>Item 1</item><item>Item 2</item></root>';
$xml = new SimpleXMLElement($xmlString);

// Convert to an array
$array = (array) $xml;

// Access as an array
print_r($array);

//Handling XML Responses from APIs

$response = file_get_contents('http://example.com/api/response.xml');
$xml = new SimpleXMLElement($response);

// Access data from the API response
echo $xml->result->status;
echo $xml->result->message;


//Creating XML Documents$xml = new SimpleXMLElement('<root/>');

// Add elements to the XML
$xml->addChild('name', 'John Doe');
$xml->addChild('email', 'john@example.com');

// Output the XML as a string
echo $xml->asXML();


//Searching XML with XPath

$xmlString = <<<XML
<books>
  <book id="1">
    <title>PHP for Beginners</title>
  </book>
  <book id="2">
    <title>Advanced PHP</title>
  </book>
</books>
XML;

$xml = new SimpleXMLElement($xmlString);

// Use XPath to find a book with id = 2
$result = $xml->xpath('//book[@id="2"]');

echo $result[0]->title; // Output: Advanced PHP


// Working with Namespaces
$xmlString = <<<XML
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <response>
      <status>Success</status>
    </response>
  </soap:Body>
</soap:Envelope>
XML;

$xml = new SimpleXMLElement($xmlString);

// Register the SOAP namespace
$xml->registerXPathNamespace('soap', 'http://schemas.xmlsoap.org/soap/envelope/');

// Use XPath to access the body
$result = $xml->xpath('//soap:Body/response/status');

echo $result[0]; // Output: Success
