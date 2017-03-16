<?php

require '../vendor/autoload.php';

use OAuth\Common\Consumer\Credentials;
use OAuth\OAuth1\Signature\Signature;
use OAuth\Common\Http\Uri\Uri;

use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\Http\Client;


// basic information needed for requests
$restResourceUri = 'http://magento2ee.dev/rest/V1/cmsBlock/2';

$magentoBaseUrl = 'http://magento2ee.dev/';
$oauthConsumerKey = 'vt05sufcppvlxjhl37baqnawk3vx56m4';
$oauthConsumerSecret = '0vun73piqe071mgcsln5gw0cj8rpind6';
$oauthAccessToken = 'cf14inbog1npxp0qro3w20l4onfkpa42';
$oauthAccessTokenSecret = '68rbd4crw3o1u9yjyod55lhkvpf2rlws';
$oauthSignatureMethod = 'HMAC-SHA1';
$oauthTimestamp = time();
$oauthNonce = md5(openssl_random_pseudo_bytes(20));


// create oauth signature
$params = [
    'oauth_consumer_key' => $oauthConsumerKey,
    'oauth_nonce' => $oauthNonce,
    'oauth_signature_method' => $oauthSignatureMethod,
    'oauth_timestamp' => $oauthTimestamp,
    'oauth_token' => $oauthAccessToken,
    'oauth_version' => '1.0',
];

$credentials = new Credentials($oauthConsumerKey, $oauthConsumerSecret, $magentoBaseUrl);
$signature = new Signature($credentials);
$signature->setTokenSecret($oauthAccessTokenSecret);
$signature->setHashingAlgorithm($oauthSignatureMethod);

$oauthUri = new Uri($restResourceUri);
$oauthSignature = $signature->getSignature($oauthUri, $params, 'GET');
$params['oauth_signature'] = $oauthSignature;


// create oauth Authorization header
$oauthHeader = 'OAuth ';
foreach ($params as $key => $value) {
    $oauthHeader .= sprintf('%s="%s", ', $key, $value);
}
$oauthHeader = rtrim($oauthHeader, ' ,');

$httpHeaders = new Headers();
$httpHeaders->addHeaders([
    'Authorization' => $oauthHeader,
    'Content-Type' => 'application/json'
]);


// create request for cms block using oauth Authorization header
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

