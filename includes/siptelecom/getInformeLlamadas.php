<?php
    include_once("../../class/db/db.php");
    include_once("../../class/siptelecom/siptelecom.php");

    $Periodo = $_POST["Periodo"];

    $PeriodoArray = explode("/",$Periodo);
    $Month = $PeriodoArray[0];
    $Year = $PeriodoArray[1];

    $SipTelecomClass = new SipTelecom();

    $Llamadas = $SipTelecomClass->getCallsByMonthAndYear($Month,$Year);

    echo json_encode($Llamadas);
?>