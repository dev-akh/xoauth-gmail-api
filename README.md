# Google Sending Mail
## This is for sending email by using xoauth2-api

## Inputs
- From Email (use the same with Google API console account)
- Client ID 
- Client Secret

## Steps
- Go to the https://console.cloud.google.com/apis/ .
- Create new `OAuth Client ID` under the *credentials* , then will auto generate Client ID and Client Secret.
- Fill the inputs
- Generate , will be see the `Token` and click `Send` button

### Configs
#### In the send.php file.
- $mail->setFrom($email, 'FROM_NAME'); 
- - `$email` is parameter input value
- $mail->addAddress('<<receiver_email>>', 'Reserver_Name');
- $mail->Subject = 'Email Subject XOAuth2';
- $mail->Body = `<b>Dear, <br><br>Email Body <br> Sending with by XOAuth2 Token </b>`;
