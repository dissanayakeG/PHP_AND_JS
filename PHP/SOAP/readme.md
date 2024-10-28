- With WSDL: SoapClient uses the WSDL file to automatically generate the XML request and send it to the web service.
- Without WSDL: You manually construct the XML body and use cURL to send the SOAP request to the endpoint.

- WSDL (Web Service Definition Language): If the web service provides a WSDL file, it's generally easier to use since SoapClient can automatically generate the required XML structure.

- Namespaces: In the manual XML request, the xmlns:ns attribute is used to define the namespace of the SOAP body.
SOAPAction: This header specifies the intended SOAP method to be invoked at the endpoint.

### Read the XML body

### 1. **XML Declaration**
```xml
<?xml version="1.0" encoding="UTF-8"?>
```
- This is the standard XML declaration.
- It specifies that the XML version being used is `1.0`, and the document is encoded in `UTF-8` character encoding.

### 2. **SOAP Envelope**
```xml
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns="http://www.example.com/namespace">
```
- The `<soap:Envelope>` element is the root element of a SOAP message.
- It indicates that this is a SOAP message and contains all other elements within it.
  
#### Namespaces:
- **`xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"`**: This defines the `soap` namespace, which is a standard namespace for SOAP version 1.1. It is required to ensure that elements like `<Envelope>` and `<Body>` are interpreted as part of the SOAP protocol.
- **`xmlns:ns="http://www.example.com/namespace"`**: This defines the `ns` namespace, which is custom for the specific web service you are communicating with. In this case, it refers to the namespace of the service located at "http://www.example.com/namespace". The `ns` prefix will be used for the specific method and parameters that are unique to the web service you're calling.

### 3. **SOAP Body**
```xml
<soap:Body>
```
- The `<soap:Body>` element contains the actual data or request that you want to send to the web service.
- This is the part of the message that the web service processes and responds to.

### 4. **Method Call and Parameters**
```xml
<ns:MethodName>
  <ns:param1>value1</ns:param1>
  <ns:param2>value2</ns:param2>
</ns:MethodName>
```
- **`<ns:MethodName>`**: This is the SOAP method you are calling on the web service. The `MethodName` element is prefixed by `ns`, which refers to the namespace defined earlier (`xmlns:ns="http://www.example.com/namespace"`). The name of this element would match the specific operation (or method) the web service provides.
  
- **Parameters**: Inside the `<ns:MethodName>` element, you pass the parameters that the method requires:
  - **`<ns:param1>`**: This is the first parameter, labeled `param1`, with the value `value1`.
  - **`<ns:param2>`**: This is the second parameter, labeled `param2`, with the value `value2`.

These parameters are typically required by the web service to process your request. They can be of various types, such as strings, numbers, or complex data types, depending on what the web service expects.

### 5. **Closing Elements**
```xml
</ns:MethodName>
</soap:Body>
</soap:Envelope>
```
- These are the closing tags for the method, body, and envelope, marking the end of the SOAP message.

---

### Summary of Key Components:
1. **Envelope**: Wraps the entire SOAP message.
2. **Body**: Contains the method call and data (parameters) you are sending.
3. **Method**: The specific web service operation you are invoking (e.g., `MethodName`).
4. **Parameters**: The actual data you are passing to the web service.

### How It Works:
When this SOAP message is sent to the web service endpoint:
- The web service reads the method (`MethodName`) and the associated parameters (`param1` and `param2`).
- The service then processes this data and typically returns a SOAP response containing the result of the method call.

### Example in Context:
Imagine you are interacting with a web service that performs a currency conversion, and the method `ConvertCurrency` takes two parameters:
- `amount` (the amount of money to convert),
- `currencyCode` (the target currency code).

The SOAP request would look like this:

```xml
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns="http://example.com/currency">
  <soap:Body>
    <ns:ConvertCurrency>
      <ns:amount>100</ns:amount>
      <ns:currencyCode>USD</ns:currencyCode>
    </ns:ConvertCurrency>
  </soap:Body>
</soap:Envelope>
```

You would use SimpleXMLElement in PHP when you need to parse, read, manipulate, or create XML data in an easy and straightforward way. The SimpleXMLElement class allows you to interact with an XML document's structure using simple property access and array-like behavior, making it ideal for handling small to medium-sized XML data.



### Soap services

#### 1.
https://www.w3schools.com/xml/tempconvert.asmx?WSDL
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <FahrenheitToCelsius xmlns="https://www.w3schools.com/xml/">
      <Fahrenheit>98.6</Fahrenheit>
    </FahrenheitToCelsius>
  </soap:Body>
</soap:Envelope>
Endpoint: https://www.w3schools.com/xml/tempconvert.asmx

#### 2.
http://www.dneonline.com/calculator.asmx?WSDL
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <Add xmlns="http://tempuri.org/">
      <intA>10</intA>
      <intB>5</intB>
    </Add>
  </soap:Body>
</soap:Envelope>
Endpoint: http://www.dneonline.com/calculator.asmx