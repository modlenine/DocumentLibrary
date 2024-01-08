<?php
class emailfn{
    public $ci;
    function __construct()
    {
        $this->ci =& get_instance();
    }

    public function emailci()
    {
        return $this->ci;
    }
}

function emailfn()
{
    $obj = new emailfn();
    return $obj->emailci();
}


function send_email($subject , $body ,$to = "" , $cc = "")
{

    if (!class_exists('PHPMailer')) {
        // PHPMailer class is not yet defined, so declare it
        require("PHPMailer_5.2.0/class.phpmailer.php");
        require("PHPMailer_5.2.0/class.smtp.php");

    }

        // Now you can safely instantiate the PHPMailer class
        $mail = new PHPMailer();

        // PHPMailer class is already defined, handle the situation accordingly
        // You may choose to throw an exception, log an error, or take an alternative action
        $mail->IsSMTP();
        $mail->CharSet = "utf-8";  // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้
        $mail->SMTPDebug = 1;                                      // set mailer to use SMTP
        $mail->Host = "mail.saleecolour.net";  // specify main and backup server
    
        $mail->Port = 25; // พอร์ท
    
        $mail->SMTPAuth = true;     // turn on SMTP authentication
        $mail->Username = getEmailAccount()->email_user; // SMTP username
    
        $mail->Password = getEmailAccount()->email_password; // SMTP password
    
        $mail->From = getEmailAccount()->email_user;
        $mail->FromName = "Document System";
    
    
        if($to != ""){
            foreach($to as $email){
                $mail->AddAddress($email);
            }
        }
    
    
        if($cc != ""){
            foreach($cc as $email){
                $mail->AddCC($email);
            }
        }
    
    
        // $mail->AddAddress("chainarong_k@saleecolour.com");
        $mail->AddBCC("chainarong_k@saleecolour.net");
    
        $mail->WordWrap = 50;                                 // set word wrap to 50 characters
        $mail->IsHTML(true);                                  // set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = '
        <style>
            @import url("https://fonts.googleapis.com/css2?family=Tahoma:wght@200;300&display=swap");
    
            h1 , h2 , h3 , p , span , div{
                font-family: Tahoma, sans-serif;
                font-size:14px;
            }
            
            table ,td ,tr {
                font-family: Tahoma, sans-serif;
                font-size:14px;
                border-collapse: collapse;
                width: 800px;
            }
            
            .center{
                margin-left: auto;
                margin-right: auto;
            }
            
            td, th {
                border: 1px solid #ccc;
                text-align: left;
                padding: 8px;
            }
            
            tr:nth-child(even) {
                background-color: #F5F5F5;
            }
            
            .bghead{
                text-align:center;
                background-color:#F5F5F5;
            }
        </style>
        '.$body;
        // $mail->send();

        if($_SERVER['HTTP_HOST'] != "localhost"){
            if(!$mail->send()){
                send_email_2($subject , $body ,$to = "" , $cc = ""); 
            }
        }


}

function send_email_2($subject , $body ,$to = "" , $cc = "")
{

    if (!class_exists('PHPMailer')) {
        // PHPMailer class is not yet defined, so declare it
        require("PHPMailer_5.2.0/class.phpmailer.php");
        require("PHPMailer_5.2.0/class.smtp.php");

    }

        // Now you can safely instantiate the PHPMailer class
        $mail = new PHPMailer();

        // PHPMailer class is already defined, handle the situation accordingly
        // You may choose to throw an exception, log an error, or take an alternative action
        $mail->IsSMTP();
        $mail->CharSet = "utf-8";  // ในส่วนนี้ ถ้าระบบเราใช้ tis-620 หรือ windows-874 สามารถแก้ไขเปลี่ยนได้
        $mail->SMTPDebug = 1;                                      // set mailer to use SMTP
        $mail->Host = "mail.saleecolour.net";  // specify main and backup server
    
        $mail->Port = 25; // พอร์ท
    
        $mail->SMTPAuth = true;     // turn on SMTP authentication
        $mail->Username = getEmailAccount_2()->email_user; // SMTP username
    
        $mail->Password = getEmailAccount_2()->email_password; // SMTP password
    
        $mail->From = getEmailAccount_2()->email_user;
        $mail->FromName = "Document System";
    
    
        if($to != ""){
            foreach($to as $email){
                $mail->AddAddress($email);
            }
        }
    
    
        if($cc != ""){
            foreach($cc as $email){
                $mail->AddCC($email);
            }
        }
    
    
        // $mail->AddAddress("chainarong_k@saleecolour.com");
        $mail->AddBCC("chainarong_k@saleecolour.net");
    
        $mail->WordWrap = 50;                                 // set word wrap to 50 characters
        $mail->IsHTML(true);                                  // set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = '
        <style>
            @import url("https://fonts.googleapis.com/css2?family=Tahoma:wght@200;300&display=swap");
    
            h1 , h2 , h3 , p , span , div{
                font-family: Tahoma, sans-serif;
                font-size:14px;
            }
            
            table ,td ,tr {
                font-family: Tahoma, sans-serif;
                font-size:14px;
                border-collapse: collapse;
                width: 800px;
            }
            
            .center{
                margin-left: auto;
                margin-right: auto;
            }
            
            td, th {
                border: 1px solid #ccc;
                text-align: left;
                padding: 8px;
            }
            
            tr:nth-child(even) {
                background-color: #F5F5F5;
            }
            
            .bghead{
                text-align:center;
                background-color:#F5F5F5;
            }
        </style>
        '.$body;
        // $mail->send();

        if($_SERVER['HTTP_HOST'] != "localhost"){
            $mail->send();
        }


}




?>