<?php

$curl = curl_init();
$n = htmlentities('<Envelope>
<Header>
	 <procedureType>2</procedureType>
	 <Reference>
		  <version>3.00</version>
		  <messageId>f0517803-8d98-4762-8a19-070108f8f1e5</messageId>
	 </Reference>
	 <SendApplication>
		  <name>CAS</name>
		  <version>1.0</version>
		  <companyName>CEH</companyName>
		  <companyIdentity>0313206513</companyIdentity>
		  <createMessageIssue>2021-10-14 16:36:57</createMessageIssue>
	 </SendApplication>
	 <From>
		  <name>CTY CO PHAN CANG NAM HAI</name>
		  <identity>0200748730</identity>
	 </From>
	 <To>
		  <name>CHI CUC HQ CK CANG HAI PHONG KVIII</name>
		  <identity>03TG</identity>
	 </To>
	 <Subject>
		  <type>901</type>
		  <function>8</function>
		  <reference>f0517803-8d98-4762-8a19-070108f8f1e5</reference>
		  <sendApplication>ECUS_K3</sendApplication>
		  <receiveApplication>ECS</receiveApplication>
	 </Subject>
</Header>
<Body>
	 <Content>PERlY2xhcmF0aW9uPgogICAgPGlzc3Vlcj45MDE8L2lzc3Vlcj4KICAgIDxyZWZlcmVuY2U+ZjA1MTc4MDMtOGQ5OC00NzYyLThhMTktMDcwMTA4ZjhmMWU1PC9yZWZlcmVuY2U+CiAgICA8aXNzdWU+MjAyMS0xMC0xNCAxNjozNjo1NzwvaXNzdWU+CiAgICA8ZnVuY3Rpb24+ODwvZnVuY3Rpb24+CiAgICA8c3RhdHVzPjE8L3N0YXR1cz4KICAgIAogICAgPGRlY2xhcmF0aW9uT2ZmaWNlPjAzVEc8L2RlY2xhcmF0aW9uT2ZmaWNlPgogICAgPEFnZW50PgogICAgICAgIDxuYW1lPkNUWSBDTyBQSEFOIENBTkcgTkFNIEhBSTwvbmFtZT4KICAgICAgICA8aWRlbnRpdHk+MDIwMDc0ODczMDwvaWRlbnRpdHk+CiAgICAgICAgPHN0YXR1cz4xPC9zdGF0dXM+CiAgICA8L0FnZW50PgogICAgCiAgICA8SW5mb21hdGlvblNlYXJjaD4KICA8Z29vZEl0ZW1UeXBlPjEwMDwvZ29vZEl0ZW1UeXBlPgogIDxyZWNlaXB0Tm8+PC9yZWNlaXB0Tm8+CiAgPGN1c3RvbXNSZWZlcmVuY2U+MTA5MTA5MTA1NzUwPC9jdXN0b21zUmVmZXJlbmNlPgogIDxiaWxsT2ZMYWRpbmc+PC9iaWxsT2ZMYWRpbmc+CiAgPGNvbnRhaW5lck5vPkFBQTAxOTEwMTkyMDI5PC9jb250YWluZXJObz4KPC9JbmZvbWF0aW9uU2VhcmNoPgo8L0RlY2xhcmF0aW9uPg==</Content>
	 <Signature>
		  <data>gMKCHwM4S3PvW2mXdqDDwaqRaAXraR2h+WRYYHTHajX+kI5OPLv8WcFx0xJ73MP3FKmrkbJt2ls0b10H83GoJWTQUj0CWY2rWxLy28+QgvjliPcS+asCqnOK0+pnOhK0a/1e8AyDO+pwY771CQkksx5V9BIonE46qWkAxyAHEUo=</data>
		  <fileCert>MIIFyzCCA7OgAwIBAgIQVAEBAU6CQrc6QtpJ1K/gRzANBgkqhkiG9w0BAQUFADBpMQswCQYDVQQGEwJWTjETMBEGA1UEChMKVk5QVCBHcm91cDEeMBwGA1UECxMVVk5QVC1DQSBUcnVzdCBOZXR3b3JrMSUwIwYDVQQDExxWTlBUIENlcnRpZmljYXRpb24gQXV0aG9yaXR5MB4XDTIwMTIxMTAzMzIwMFoXDTI0MDYyNjA4MDIwMFowgaMxCzAJBgNVBAYTAlZOMRcwFQYDVQQIDA5I4buSIENIw40gTUlOSDERMA8GA1UEBwwIUXXhuq1uIDExSDBGBgNVBAMMP0PDlE5HIFRZIEPhu5QgUEjhuqZOIFbhuqxOIFThuqJJIFbDgCBUSMavxqBORyBN4bqgSSBRVeG7kEMgVOG6vjEeMBwGCgmSJomT8ixkAQEMDk1TVDowMzAyMzQ1NDU5MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC5SUD7021DUWKOTbMzUKGn3VBScs++LajsDwXBOJzxSnJxvvBNjGIpg6+ZOj+as8qPJkWxgOt59kQSmpBIPaVAX4glI2+qv0iw55NRPu6qZ9XlP/xyrvbPH6QHZC0pf9E4rcZao2Uuj2JVvoNLuW1osQCUthG1UQr+WJnDxDydKQIDAQABo4IBtjCCAbIwcAYIKwYBBQUHAQEEZDBiMDIGCCsGAQUFBzAChiZodHRwOi8vcHViLnZucHQtY2Eudm4vY2VydHMvdm5wdGNhLmNlcjAsBggrBgEFBQcwAYYgaHR0cDovL29jc3Audm5wdC1jYS52bi9yZXNwb25kZXIwHQYDVR0OBBYEFBeNnR0nhzU618kVs6jrp6uSnLWEMAwGA1UdEwEB/wQCMAAwHwYDVR0jBBgwFoAUBmnA1dUCihWNRn3pfOJoClWsaq8waAYDVR0gBGEwXzBdBg4rBgEEAYHtAwEBAwEBATBLMCIGCCsGAQUFBwICMBYeFABPAEkARAAtAFMAVAAtADEALgAwMCUGCCsGAQUFBwIBFhlodHRwOi8vcHViLnZucHQtY2Eudm4vcnBhMDEGA1UdHwQqMCgwJqAkoCKGIGh0dHA6Ly9jcmwudm5wdC1jYS52bi92bnB0Y2EuY3JsMA4GA1UdDwEB/wQEAwIE8DAgBgNVHSUEGTAXBgorBgEEAYI3CgMMBgkqhkiG9y8BAQUwIQYDVR0RBBowGIEWbmhpZW50aGEyMDA5QGdtYWlsLmNvbTANBgkqhkiG9w0BAQUFAAOCAgEAaLK1lm1KzlyY2Q5jewBc4QFfHzNJm9iPZFh2YJNyOoS2RD6jw7tvCoJpEXBAobsJ2QPt6yK/qNEAQXfUD9JoWI9MbWIiqsfdMlO8NFhDZR+xmtdebmCCLv+lVpUNapAfqHBMcWJ5RS7W2mtcBzBe1GXB0Xna8W2O4GqEmoXQmeQVGyrE1Pyu7F0+2WxF2p4ZICX9yyMeml6+YraywMkWiHjufNSvpl8deM5EYdC3We4SCJLpyOzjgmoUDaGDBqhobCzkxqjAuPmvWGcer/jXfjLzBd+9Hw9b0HVQowWnzfOAdgsnenjouqqg+9FS6+rHXeqUU3fL6hMcEi/WLTphags5ZHOWAJGW8zTzrLTMBPGGxav4lvwgrtXjvLoSOTI0T/+nsuXU+kaROIMAF692qn/0LpPlm9oQDc2dqxlSMnxgeX349jblUpCWzoG9wY5JgFQa9lXmsTWR9wF2zVRM/f4FLoJD3Hi7+/REgu0vIrN/3Kdv5G8u5mH+Q1sYt8IKiZkQTHkGPuzf7BkA/rA5ccxShu6jM5uy7VGgoRx8XgHSAYOXzkKmR6g2R1XJxyKks+/qLKrfNpMTONZ/RF35bxs3qYl0P3hkMPSQ17Sz9DEMxbrL8J91J0J89akWzX9jdZoT/CxTbdGemf5WtdpiuPlt9rsRWxN0qHTdj7Aw/EY=</fileCert>
	 </Signature>
</Body>
</Envelope>');

curl_setopt_array($curl, array(
	CURLOPT_CONNECTTIMEOUT => 100, // timeout on connect
	CURLOPT_TIMEOUT => 100, // timeout on response
  CURLOPT_URL => 'https://phtkvcangbien.tphcm.gov.vn:8091/KDTService.asmx',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_POST => true,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
    <soap:Body>
        <Send xmlns="http://tempuri.org/">
            <MsgXML>
				$n
            </MsgXML>
        </Send>
    </soap:Body>
</soap:Envelope>',
  CURLOPT_HTTPHEADER => array(
	"Content-Type: text/xml; charset=utf-8",
	'SOAPAction: "http://tempuri.org/Send"',
	"Host: phtkvcangbien.tphcm.gov.vn"
  ),
));

$response = curl_exec($curl);
curl_close($curl);
var_export($response);

?>
