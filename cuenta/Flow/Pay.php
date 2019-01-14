<?php
    /**
     * Ejemplo de creación de una orden de cobro, iniciando una transacción de pago
     * Utiliza el método payment/create
     */
    require("../class/Flow/FlowApi.class.php");
    //Para datos opcionales campo "optional" prepara un arreglo JSON
    $optional = array(
        "rut" => "25858538-0",
        "otroDato" => "otroDato"
    );
    $optional = json_encode($optional);
    //Prepara el arreglo de datos
    $params = array(
        "commerceOrder" => rand(1100,2000),
        "subject" => "Pago de prueba",
        "currency" => "CLP",
        "amount" => 5000,
        "email" => "jonathanurbina92@gmail.com",
        "paymentMethod" => 9,
        "urlConfirmation" => Config::get("BASEURL") . "/Flow/confirm.php",
        "urlReturn" => Config::get("BASEURL") ."/Flow/result.php",
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