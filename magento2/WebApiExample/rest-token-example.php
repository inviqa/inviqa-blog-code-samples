<?php

require '../vendor/autoload.php';

use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\Http\Client;
use Zend\Stdlib\Parameters;


// basic information needed for requests
$restTokenUri = 'http://magento2ee.dev/rest/V1/integration/admin/token';
$restResourceUri = 'http://magento2ee.dev/rest/V1/cmsBlock/2';
$tokenUsername = 'admin';
$tokenPassword = 'admin123';


// create request for token using username and password
$httpHeaders = new Headers();
$httpHeaders->addHeaders([
    'Content-Type' => 'application/json'
]);
$request = new Request();
$request->setHeaders($httpHeaders);
$request->setUri($restTokenUri);
$request->setMethod(Request::METHOD_POST);
$request->setContent(sprintf('{"username":"%s", "password":"%s"}', $tokenUsername, $tokenPassword));


// create client and get token response
$client = new Client();
$options = [
    'adapter'   => 'Zend\Http\Client\Adapter\Curl',
    'curloptions' => [CURLOPT_FOLLOWLOCATION => true],
    'maxredirects' => 0,
    'timeout' => 30
];
$client->setOptions($options);

$response = $client->send($request);

$token = trim($response->getBody(), '"');


// create request for cms block using bearer token Authorization header
$httpHeaders = new Headers();
$httpHeaders->addHeaders([
    'Authorization' => sprintf('Bearer %s', $token),
    'Content-Type' => 'application/json'
]);
$request = new Request();
$request->setHeaders($httpHeaders);
$request->setUri($restResourceUri);
$request->setMethod(Request::METHOD_GET);


// create client and get cms block response
$client = new Client();
$options = [
    'adapter'   => 'Zend\Http\Client\Adapter\Curl',
    'curloptions' => [CURLOPT_FOLLOWLOCATION => true],
    'maxredirects' => 0,
    'timeout' => 30
];
$client->setOptions($options);

$response = $client->send($request);

echo $response->getBody();

