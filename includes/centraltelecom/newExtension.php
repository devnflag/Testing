<?php
    session_start();
    include_once("../../class/db/db.php");
    include_once("../../class/login/login.php");
    include_once("../../class/extensiones/extensiones.php");
    include_once("../../class/centralTelecom/centralTelecom.php");

    $nombreExtension = $_POST["nombreExtension"];
    $idCliente = $_SESSION["idCliente"];

    $CentralTelecomClass = new CentralTelecom();

    $ToReturn = $CentralTelecomClass->newExtension($nombreExtension,$idCliente);
    echo json_encode($ToReturn);
?>