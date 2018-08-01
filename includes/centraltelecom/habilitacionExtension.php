<?php
    session_start();
    include_once("../../class/db/db.php");
    include_once("../../class/login/login.php");
    include_once("../../class/extensiones/extensiones.php");
    include_once("../../class/agi/phpagi.php");

    $Extension = $_POST["Extension"];
    $idCliente = $_SESSION["idCliente"];

    $ToReturn = array();
    $ToReturn["result"] = false;

    $LoginClass = new Login();
    $ExtensionesClass = new Extensiones();

    $Estatus = $LoginClass->getUserStatus($Extension,$idCliente);
    if($Estatus["result"]){
        $Estatus = $Estatus["Estatus"];
        $nuevoEstatus = "";
        switch($Estatus){
            case "1":
                $nuevoEstatus = "0";
            break;
            case "0":
                $nuevoEstatus = "1";
            break;
        }
        $ToReturn = $LoginClass->changeUserStatus($Extension,$idCliente,$nuevoEstatus);
    }

    echo json_encode($ToReturn);
?>