<?php
    session_start();
    include_once("../../class/db/db.php");
    include_once("../../class/login/login.php");
    include_once("../../class/extensiones/extensiones.php");
    include_once("../../class/centraltelecom/centraltelecom.php");
    include_once("../../class/clientes/clientes.php");

    $nombreExtension = $_POST["nombreExtension"];
    $Extension = $_POST["Extension"];
    $idCliente = $_SESSION["idCliente"];

    $ToReturn = array();

    $CentralTelecomClass = new CentralTelecom();

    $ToReturn = $CentralTelecomClass->updateExtension($nombreExtension,$Extension,$idCliente);
    echo json_encode($ToReturn);
?>