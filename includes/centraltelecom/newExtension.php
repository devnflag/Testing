<?php
    session_start();
    include_once("../../class/db/db.php");
    include_once("../../class/login/login.php");
    include_once("../../class/extensiones/extensiones.php");
    include_once("../../class/centraltelecom/centraltelecom.php");
    include_once("../../class/clientes/clientes.php");
    include_once("../../class/agi/phpagi.php");

    $nombreExtension = $_POST["nombreExtension"];
    $idCliente = $_SESSION["idCliente"];

    $ToReturn = array();

    $CentralTelecomClass = new CentralTelecom();
    $ClientesClass = new Clientes();

    $Saldo = $ClientesClass->getSaldo($_SESSION["userID"]);
    $PrecioExtension = $CentralTelecomClass->getPrecioExtension();

    if($Saldo >= $PrecioExtension){
        $ToReturn = $CentralTelecomClass->newExtension($nombreExtension,$idCliente);
    }else{
        $ToReturn["result"] = false;
        $ToReturn["Message"] = "Su saldo no es suficiente para adquirir una extension. El precio de cada extension es de: $ ".$PrecioExtension;
    }
    echo json_encode($ToReturn);
?>