<?php

namespace PHPMailer\PHPMailer;
 
//@see https://github.com/thephpleague/oauth2-google
use League\OAuth2\Client\Provider\Google;
$clientId = '913440284964-vbj9o265k1vl899hddoroo7j103mil9u.apps.googleusercontent.com';
$clientSecret = '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';

if (!isset($_GET['code']) && !isset($_GET['provider'])) {
    ?>
<html>
<body>
    <h3>Generating Token ...</h3>
</body>
</html>
    <?php
    exit;
}
 
require 'vendor/autoload.php';
 
session_start();
 
$providerName = '';
 
if (array_key_exists('provider', $_GET)) {
    $providerName = $_GET['provider'];
    $_SESSION['provider'] = $providerName;
} elseif (array_key_exists('provider', $_SESSION)) {
    $providerName = $_SESSION['provider'];
}
if (!in_array($providerName, ['Google'])) {
    exit('Only Google OAuth2 providers are currently supported in this script.');
}

//If this automatic URL doesn't work, set it yourself manually to the URL of this script
$redirectUri = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
//$redirectUri = 'http://localhost/PHPMailer/redirect';
 
if(array_key_exists('email', $_POST) && array_key_exists('clientId', $_POST) && array_key_exists('clientSecret', $_POST) ){
    $_SESSION['email']=$_POST['email'];
    $_SESSION['clientId']=$_POST['clientId'];
    $_SESSION['clientSecret']=$_POST['clientSecret'];
}
if($_SESSION['email']==null && $_SESSION['clientId'] ==null && $_SESSION['clientSecret']==null){
    echo '<h3 style="color:red;text-align:center"> Please provide the Email, ClientID, ClientSecret </h3>'; die();
}
$params = [
    'clientId' => $_SESSION['clientId'],
    'clientSecret' =>$_SESSION['clientSecret'],
    'redirectUri' => $redirectUri,
    'accessType' => 'offline'
];
 
$options = [];
$provider = null;
 
switch ($providerName) {
    case 'Google':
        $provider = new Google($params);
        $options = [
            'scope' => [
                'https://mail.google.com/'
            ]
        ];
        break;
}
 
if (null === $provider) {
    exit('Provider missing');
}
 
if (!isset($_GET['code'])) {
    //If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl($options);
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
    exit;
    //Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    unset($_SESSION['provider']);
    exit('Invalid state');
} else {
    unset($_SESSION['provider']);
    //Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken(
        'authorization_code',
        [
            'code' => $_GET['code']
        ]
    );
    echo "Token :<br> <div style='border-width:1px;border-color:2px;border-style:solid;padding:20px;'>" .$token."</div>";
    echo "<div style='text-align:center;'> <a href='/send.php?token=".$token."'/> Send Mail</a>";die();
    //Use this to interact with an API on the users behalf
    //Use this to get a new access token if the old one expires
    // echo 'Refresh Token: ', $token->getRefreshToken();
}