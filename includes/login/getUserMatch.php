<?php
    include_once("../../class/db/db.php");
    include_once("../../class/login/login.php");
    include_once("../../class/clientes/clientes.php");
    
    $LoginClass = new Login();

    $User = $_POST["User"];
    $Password = $_POST["Password"];
    
    $ToReturn = $LoginClass->getUserMatch($User,$Password);

    echo json_encode($ToReturn);
?>