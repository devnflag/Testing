<?php
    include_once("../../class/db/db.php");
    include_once("../../class/login/login.php");
    include_once("../../class/servicios/servicios.php");
    include_once("../../class/clientes/clientes.php");
    include_once("../../class/extensiones/extensiones.php");
    include_once("../../class/agi/phpagi.php");
    
    $LoginClass = new Login();

    $FullName = $_POST["FullName"];
    $DNI = $_POST["DNI"];
    $Mail = $_POST["Mail"];
    $Address = $_POST["Address"];
    
    $ToReturn = $LoginClass->newUser($FullName,$DNI,$Mail,$Address,'1');

    echo json_encode($ToReturn);
?>