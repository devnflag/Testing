<?php
    include_once("../../class/db/db.php");
    include_once("../../class/login/login.php");
    include_once("../../class/servicios/servicios.php");
    include_once("../../class/clientes/clientes.php");
    include_once("../../class/extensiones/extensiones.php");
    include_once("../../class/agi/phpagi.php");
    include_once("../../class/siptelecom/siptelecom.php");
    include_once("../../class/mail/mail.php");
    include_once("../../includes/PHPMailer/class.phpmailer.php");
    include_once("../../includes/PHPMailer/class.smtp.php");
    
    $LoginClass = new Login();

    $FullName = $_POST["FullName"];
    $DNI = $_POST["DNI"];
    $Mail = $_POST["Mail"];
    $Address = $_POST["Address"];
    $Password = substr(md5(microtime()), 1, 8);
    
    $MailExist = $LoginClass->MailExist($Mail);
    if(!$MailExist["result"]){
        $ToReturn = $LoginClass->newUser($FullName,$DNI,$Mail,$Address,'1',$Password);
        if($ToReturn["result"]){
            $MailClass = new Mail();
            $MailClass->sendMailNewUser($Mail,$FullName,$Password);
        }
    }else{
        $MailExist["result"] = false;
        $MailExist["FailMail"] = true;
        $ToReturn = $MailExist;
    }

    echo json_encode($ToReturn);
?>