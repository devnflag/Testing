<?php
    include_once("../class/db/db.php");
    include_once("../class/siptelecom/siptelecom.php");

    $SipTelecomClass = new SipTelecom();

    $Date = date("Ymd");
    $SipTelecomClass->eliminarBolsasVencimiento($Date);
?>