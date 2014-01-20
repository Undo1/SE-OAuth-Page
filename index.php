<?php
require('config.php');
require('PHP-OAuth2-master/Client.php');
require('PHP-OAuth2-master/GrantType/IGrantType.php');
require('PHP-OAuth2-master/GrantType/AuthorizationCode.php');

$CLIENT_ID = ClientId();
$CLIENT_SECRET = ClientSecret();

$REDIRECT_URI = RedirectUri();
$AUTHORIZATION_ENDPOINT = 'https://stackexchange.com/oauth';
$TOKEN_ENDPOINT = 'https://stackexchange.com/oauth/access_token';

$client = new OAuth2\Client($CLIENT_ID, $CLIENT_SECRET);
if (!isset($_GET['code']))
{
    $auth_url = $client->getAuthenticationUrl($AUTHORIZATION_ENDPOINT, $REDIRECT_URI);
    header('Location: ' . $auth_url);
    die('Redirect');
}
else
{
    $params = array('code' => $_GET['code'], 'redirect_uri' => $REDIRECT_URI);
    $response = $client->getAccessToken($TOKEN_ENDPOINT, 'authorization_code', $params);
    parse_str($response['result'], $info);
    $client->setAccessToken($info['access_token']);
    
    echo 'access token: ' . $info['access_token'];
    echo PHP_EOL;
    echo 'key: ' . ClientKey();
}

