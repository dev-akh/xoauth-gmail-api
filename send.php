<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;


require_once 'vendor/autoload.php';
session_start();
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 465;

$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->SMTPAuth = true;
$mail->AuthType = 'XOAUTH2';
$email = $_SESSION['email']; // the email used to register google app
$clientId = $_SESSION['clientId'];
$clientSecret =  $_SESSION['clientSecret'];

// $refreshToken = '1//0gqhm4cAxbDFFCgYIARAAGBASNwF-L9IrtANSOcWmjBxMAT9G3QkxU0D-LqyhgJwk0B_ZMytAdx9zMYgYZMQhuhGjmI2PS33-320';
if (array_key_exists('token', $_GET) && $_GET['token'] !=null) {
    $refreshToken = $_GET['token'];
}else{
    echo '<h3 style="color:red;text-align:center"> Please provide the Token </h3>'; die();
}

//Create a new OAuth2 provider instance
$provider = new Google(
    [
        'clientId' => $clientId,
        'clientSecret' => $clientSecret,
    ]
);

//Pass the OAuth provider instance to PHPMailer
$mail->setOAuth(
    new OAuth(
        [
            'provider' => $provider,
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'refreshToken' => $refreshToken,
            'userName' => $email,
        ]
    )
);

$mail->setFrom($email, 'FROM_NAME');
$mail->addAddress('akhtwe@global-connect.asia', 'Charrtoo');
$mail->isHTML(true);
$mail->Subject = 'Email Subject XOAuth2';
$mail->Body = '<b>Dear, <br><br>Email Body <br> Sending with by XOAuth2 Token </b>';

//send the message, check for errors
if (!$mail->send()) {
    echo '<h3 style="color:red;padding-top:30px;">Mailer Error:</h3> <div style="border:1px solid black;">' . $mail->ErrorInfo . '</div>';
} else {
    echo '<h3 style="color:green;text-align:center;padding-top:30px;"> Message sent! <br> <a href="/" > <b>Back</b></a></h3>';
}