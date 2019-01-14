<?php
    /**
     * Ejemplo de creación de una orden de cobro, iniciando una transacción de pago
     * Utiliza el método payment/create
     */
    require("../../class/Flow/FlowApi.class.php");
    include_once("../../class/db/db.php");
    include_once("../../class/clientes/clientes.php");

    $Saldo = $_GET["saldo"];

    $db = new DB();
    $ClientesClass = new Clientes();
    $SqlInsertComprobante = "insert into comprobantes (idCliente,tipoComprobante,fechaRegistro) values ('".$_SESSION["idCliente"]."','Flow',NOW())";
    $InsertComprobante = $db->query($SqlInsertComprobante);
    if($InsertComprobante){
        $idComprobante = $db->getLastID();
    }

    $Cliente = $ClientesClass->getClienteByID($_SESSION["idCliente"]);
    if($Cliente["result"]){
        $Cliente = $Cliente["Data"];
    }

    //Para datos opcionales campo "optional" prepara un arreglo JSON
    $optional = array(
        "idCliente" => $_SESSION["idCliente"],
        "saldoActual" => $Cliente["saldo"]
    );
    $optional = json_encode($optional);
    //Prepara el arreglo de datos
    $params = array(
        "commerceOrder" => $idComprobante,
        "subject" => "Recarga de saldo NFLAG - SIP Telecom",
        "currency" => "CLP",
        "amount" => $Saldo,
        "email" => $Cliente["correoElectronico"],
        "paymentMethod" => 9,
        "urlConfirmation" => Config::get("BASEURL") . "/confirm.php",
        "urlReturn" => Config::get("BASEURL") ."/result.php",
        "optional" => $optional
    );
    //Define el metodo a usar
    $serviceName = "payment/create";
    try {
        // Instancia la clase FlowApi
        $flowApi = new FlowApi;
        // Ejecuta el servicio
        $response = $flowApi->send($serviceName, $params,"POST");
        //Prepara url para redireccionar el browser del pagador
        $redirect = $response["url"] . "?token=" . $response["token"];
        header("location:$redirect");
    } catch (Exception $e) {
        echo $e->getCode() . " - " . $e->getMessage();
    }
?>