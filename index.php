<?php
require('config.php');
require('PHP-OAuth2-master/Client.php');
require('PHP-OAuth2-master/GrantType/IGrantType.php');
require('PHP-OAuth2-master/GrantType/AuthorizationCode.php');

const CLIENT_ID     = ClientId();
const CLIENT_SECRET = ClientSecret();

const REDIRECT_URI           = RedirectUri();
const AUTHORIZATION_ENDPOINT = 'https://stackexchange.com/oauth';
const TOKEN_ENDPOINT         = 'https://stackexchange.com/oauth/access_token';

$client = new OAuth2\Client(CLIENT_ID, CLIENT_SECRET);
if (!isset($_GET['code']))
{
    $auth_url = $client->getAuthenticationUrl(AUTHORIZATION_ENDPOINT, REDIRECT_URI);
    header('Location: ' . $auth_url);
    die('Redirect');
}
else
{
    $params = array('code' => $_GET['code'], 'redirect_uri' => REDIRECT_URI);
    $response = $client->getAccessToken(TOKEN_ENDPOINT, 'authorization_code', $params);
    parse_str($response['result'], $info);
    $client->setAccessToken($info['access_token']);
    $response = $client->fetch('https://api.stackexchange.com/2.2/me/inbox');
    var_dump($response, $response['result']);
}

