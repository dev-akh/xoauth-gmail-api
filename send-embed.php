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
$email = '<<valid sender mail>>'; // the email used to register google app
$clientId ='<<client Id>>';
$clientSecret ='<<client secret>>';
$refreshToken ='<<token>>';
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

$mail->setFrom($email, 'Mail From XOAuth2');
$mail->addAddress('akhtwe@global-connect.asia', 'AKHtwe');
$mail->isHTML(true);
$mail->Subject = 'Email Subject XOAuth2';
$mail->Body = '<b>Dear, <br><br>Email Body <br> Sending with by XOAuth2 Token </b>';

//send the message, check for errors
if (!$mail->send()) {
    echo '<h3 style="color:red;padding-top:30px;">Mailer Error:</h3> <div style="border:1px solid black;padding:20px;">' . $mail->ErrorInfo . '</div>';
} else {
    echo '<h3 style="color:green;text-align:center;padding-top:30px;"> Message sent! <br> <a href="/" > <small>Back</small></a></h3>';
}