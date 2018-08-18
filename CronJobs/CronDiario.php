<?php
    include_once("../class/db/db.php");
    include_once("../class/siptelecom/siptelecom.php");
    include_once("../class/extensiones/extensiones.php");
    include_once("../class/agi/phpagi.php");

    $SipTelecomClass = new SipTelecom();

    $Date = date("Ymd");
    $SipTelecomClass->eliminarBolsasVencimiento($Date);
?>