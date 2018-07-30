<?php
    session_start();
    include_once("../../class/db/db.php");
    include_once("../../class/siptelecom/siptelecom.php");
    include_once("../../class/clientes/clientes.php");

    $idPlan = $_POST["idPlan"];

    $SipTelecomClass = new SipTelecom();

    $ToReturn = array();
    $HavePlan = $SipTelecomClass->HavePlan($_SESSION["userID"]);
    if($HavePlan){
        $ToReturn["result"] = false;
        $ToReturn["Message"] = "Ya posee un plan contratado, debe esperar que su plan culmine para poder obtar por otro.";
    }else{
        $ToReturn = $SipTelecomClass->contratarPlan($_SESSION["userID"],$idPlan);    
    }
    
    echo json_encode($ToReturn);
?>