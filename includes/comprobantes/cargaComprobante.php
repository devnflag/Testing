<?php
    session_start();
    include_once("../../class/db/db.php");
    include_once("../../class/comprobantes/comprobantes.php");
    include_once("../../class/mail/mail.php");
    include_once("../../includes/PHPMailer/class.phpmailer.php");
    include_once("../../includes/PHPMailer/class.smtp.php");

    $idServicio = $_POST["idServicio"];
    $tipoComprobante = $_POST["tipoComprobante"];

    $ToReturn = array();
    $ToReturn["result"] = false;

    $ComprobantesClass = new Comprobantes();

    $File = $_FILES['file']['name'];
    $Ruta = "../../facturas/C".$_SESSION["idCliente"]."/";

    if (!file_exists($Ruta)){
        mkdir($Ruta, 0777, true);
    }   

    $Comprobante = $ComprobantesClass->nuevoComprobante($_SESSION["idCliente"],$Ruta,$tipoComprobante);
    if($Comprobante["result"]){
        $idComprobante = $Comprobante["idComprobante"];

        $Extension = pathinfo($File, PATHINFO_EXTENSION);

        $ficheroFinal = $Ruta .$idComprobante.".".$Extension;

        if(move_uploaded_file($_FILES['file']['tmp_name'], $ficheroFinal)){
            shell_exec("chmod 777 ".$ficheroFinal);
            $ToReturn["result"] = true;
            $MailClass = new Mail();
            echo $_SESSION["idCliente"];
            $MailClass->sendMailNewComprobante($ficheroFinal,$tipoComprobante,$_SESSION["idCliente"],$idComprobante);
        }else{
            $ToReturn["Message"] = "Hubo un error al subir el archivo.";
            $ComprobantesClass->deleteComprobante($idComprobante);
        }
    }else{
        $ToReturn["Message"] = "Hubo un error al registrar el comprobante de pago.";
    }
    echo json_encode($ToReturn);
?>