<?php

namespace Core\Lib;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{
    protected $mail;

    function __construct()
    {
        $this->mail = new PHPMailer(true);
        //set if default from is
        $from = env('SMTP_FROM_EMAIL');
        $name = env('SMTP_FROM_NAME');

        if(!empty($from)){
            $this->mail->setFrom($from, $name);
        }

        $this->initialCheck();
    }

    /**checks for phpmailer credentails */
    protected function initialCheck()
    {
        try {
            //get all the credentials
            $host = env('SMTP_HOST', null);
            $user = env('SMTP_USER', null);
            $port = env('SMTP_PORT', null);
            $password = env('SMTP_PASS', null);

            if (!$host || !$user || !$port || !$password) {
                die("<p>Please configure SMTP Credentials in <code>.env</code> file</p>");
            }

            // $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $this->mail->isSMTP();                                            //Send using SMTP
            $this->mail->Host       = $host;                                  //Set the SMTP server to send through
            $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $this->mail->Username   = $user;                                  //SMTP username
            $this->mail->Password   = $password;                               //SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $this->mail->Port       = $port;
        } catch (Exception $e) {
            echo 'Mailer Error: '.$this->mail->ErrorInfo;
        }
    }

    //set from
    public function from(array $from)
    {
        try{
            $this->mail->setFrom($from['email'] ?? '', $from['name'] ?? '');
        }catch(Exception $e){
            echo 'Mailer Error: '.$this->mail->ErrorInfo;
        }
    }

    //set to
    public function to(array $to)
    {
        try {
            $toall = isset($to['to']) ? $to['to'] : false;

            if ($toall && is_array($toall)) {
                foreach ($toall as $_r) {
                    $this->mail->addAddress($_r['email'] ?? '', $_r['name'] ?? '');
                }
            }


            if (isset($to['reply_to']['email'])) {
                $this->mail->addReplyTo($to['reply_to']['email'], $to['reply_to']['name'] ?? '');
            }

            if (isset($to['cc'])) {
                $this->mail->addCC($to['cc']);
            }

            if (isset($to['bcc'])) {
                $this->mail->addBCC($to['bcc']);
            }
        } catch (Exception $e) {
            echo 'Mailer Error: '.$this->mail->ErrorInfo;
        }
    }

    //Attachments
    public function attach(array $attachments)
    {
        try {
            if (is_array($attachments) && count($attachments) > 0) {
                foreach ($attachments as $attach) {
                    $this->mail->addAttachment($attach);         //Add attachments
                }
            }
        } catch (Exception $e) {
            echo 'Mailer Error: '.$this->mail->ErrorInfo;
        }
    }

    //Content
    public function body($subject = "", $body = "", $html = false)
    {
        try {
            $this->mail->Subject = $subject;

            if ($html) {
                $this->mail->isHTML(true);              //Set email format to HTML
            } 

            $this->mail->Body    = $body;

        } catch (Exception $e) {
            echo 'Mailer Error: '.$this->mail->ErrorInfo;
        }
    }

    //send
    public function send()
    {
        try{
            if($this->mail->smtpConnect()){
                $this->mail->send();
                return 1;
            }else{
                echo "Credentails are not valid. Please check. >> ".$this->mail->ErrorInfo;
            }
        }catch(Exception $e){
            echo 'Mailer Error: '.$this->mail->ErrorInfo;
        }
    }
}
