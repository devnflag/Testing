<?php
    include_once("../../class/db/db.php");
    include_once("../../class/mail/mail.php");
    include_once("../../includes/PHPMailer/class.phpmailer.php");
    include_once("../../includes/PHPMailer/class.smtp.php");
    
    $MailClass = new Mail();
    $MailClass->sendMailNewUser("jonathanurbina92@gmail.com","Jonathan Urbina","CLAVE");

?>