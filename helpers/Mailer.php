<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private $mail = null;

    function __construct()
    {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        //Server settings
        $mail->SMTPDebug  = false; // SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = SMTP_HOST; // 'smtp.example.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = SMTP_USER; // 'user@example.com';                     //SMTP username
        $mail->Password   = SMTP_PASSWORD; // 'secret';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = SMTP_PORT; // 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        $this->mail = $mail;
    }

    function send($to, $subject, $message)
    {
        $mysql = new QueryBuilder("mysql");
        $mysql->create("email_queues", [
            'email' => $to,
            'subject' => $subject,
            'message' => $message
        ])->exec();
    }

    function doSend($to, $subject, $message)
    {
        try {                                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            //Recipients
            $this->mail->setFrom(SMTP_FROM, SMTP_NAME);
            $this->mail->addAddress($to);     //Add a recipient
            
        
            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = $subject;
            $this->mail->Body    = $message;
        
            $this->mail->send();
            return 'Sent';
        } catch (Exception $e) {
            return $mail->ErrorInfo;
        }
    }

}