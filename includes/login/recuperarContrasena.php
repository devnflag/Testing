<?php
    include_once("../../class/db/db.php");
    include_once("../../class/login/login.php");
    include_once("../../class/mail/mail.php");
    include_once("../../includes/PHPMailer/class.phpmailer.php");
    include_once("../../includes/PHPMailer/class.smtp.php");
    
    $Mail = $_POST["Mail"];

    $LoginClass = new Login();

    $ToReturn = array();
    $ToReturn["result"] = false;

    $UserReturn = $LoginClass->getUserByMail($Mail);
    if($UserReturn["result"]){
        $ToReturn["result"] = true;
        $UserData = $UserReturn["Data"];
        $Password = $UserData["claveUsuario"];

        $MailClass = new Mail();
        $MailClass->sendMailRecuperarClave($Mail,$Password);
    }else{
        $ToReturn["Message"] = "Usuario no Registrado";
    }
    echo json_encode($ToReturn);
?>