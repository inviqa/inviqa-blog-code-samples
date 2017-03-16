<?php

// basic information needed for requests
$soapTokenUri = 'http://magento2ee.dev/soap/default?wsdl&services=integrationAdminTokenServiceV1';
$soapResourceUri = 'http://magento2ee.dev/soap/default?wsdl&services=cmsBlockRepositoryV1';
$username = 'admin';
$password = 'admin123';

$options = [
    'soap_version' => SOAP_1_2,
    'trace' => 1,
    'connection_timeout' => 120,
];


// create client and get token response using username and password
$cli = new SoapClient($soapTokenUri, $options);

$response = $cli->integrationAdminTokenServiceV1CreateAdminAccessToken([
    'username' => $username,
    'password' => $password
]);

$token = $response->result;


// create bearer token Authorization header
$options['stream_context'] = stream_context_create([
    'http' => [
        'header' => sprintf('Authorization: Bearer %s', $token)
    ]
]);


// create client and get cms block response
$cli = new SoapClient($soapResourceUri, $options);

$response = $cli->cmsBlockRepositoryV1GetById([
    'blockId' => '2'
]);

$block = $response->result;

echo $block;

