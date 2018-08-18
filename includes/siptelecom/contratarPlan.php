<?php
    session_start();
    include_once("../../class/db/db.php");
    include_once("../../class/siptelecom/siptelecom.php");
    include_once("../../class/clientes/clientes.php");
    include_once("../../class/extensiones/extensiones.php");
    include_once("../../class/agi/phpagi.php");


    $idPlan = $_POST["idPlan"];

    $SipTelecomClass = new SipTelecom();

    $ToReturn = array();
    $HavePlan = $SipTelecomClass->HavePlan($_SESSION["userID"],$idPlan);
    if($HavePlan["result"]){
        $ToReturn["result"] = false;
        if($HavePlan["inbound"]){
            $ToReturn["Message"] = "Ya posee un plan de llamadas entrantes contratado, debe esperar que su plan culmine para poder obtar por otro.";
        }else{
            $ToReturn["Message"] = "Ya posee un plan de llamadas salientes contratado, debe esperar que su plan culmine o consuma todos los minutos asociados para poder obtar por otro.";
        }
    }else{
        $ToReturn = $SipTelecomClass->contratarPlan($_SESSION["userID"],$idPlan);    
    }
    
    echo json_encode($ToReturn);
?>