<?php
    /**
     * Pagina del comercio para redireccion del pagador
     * A esta página Flow redirecciona al pagador pasando vía POST
     * el token de la transacción. En esta página el comercio puede
     * mostrar su propio comprobante de pago
     */
    require("../../class/Flow/FlowApi.class.php");
    include_once("../../class/db/db.php");
    $db = new DB();

    try {
        //Recibe el token enviado por Flow
        if(!isset($_POST["token"])) {
            throw new Exception("No se recibio el token", 1);
        }
        $token = filter_input(INPUT_POST, 'token');
        $params = array(
            "token" => $token
        );
        //Indica el servicio a utilizar
        $serviceName = "payment/getStatus";
        $flowApi = new FlowApi();
        $response = $flowApi->send($serviceName, $params, "GET");
        
        $Status = $response["status"];
        $FlowOrder = $response["flowOrder"];
        $idComprobante = $response["commerceOrder"];
        $Saldo = $response["amount"];
        $Optional = $response["optional"];
        $idCliente = $Optional["idCliente"];

        $SqlUpdateComprobante = "update comprobantes set idExterno='".$FlowOrder."' where id='".$idComprobante."'";
        $UpdateComprobante = $db->query($SqlUpdateComprobante);

        switch($Status){
            case 1: //Pending
            break;
            case 2: //Success
                $SqlUpdateComprobante = "update comprobantes set status='1' where id='".$idComprobante."'";
                $UpdateComprobante = $db->query($SqlUpdateComprobante);
                if($UpdateComprobante){
                    $SqlInsertRecarga = "insert into recargas (idComprobante,fechaRecarga,montoRecarga) values ('".$idComprobante."',NOW(),'".$Saldo."')";
                    $InsertRecarga = $db->query($SqlInsertRecarga);
                }

                $SqlUpdateSaldo = "update clientes set saldo=(saldo+".$Saldo.") where id='".$idCliente."'" ;
                $UpdateSaldo = $db->query($SqlUpdateSaldo);

            break;
            case 3: //Declined
                $SqlUpdateComprobante = "update comprobantes set status='3' where id='".$idComprobante."'";
                $InsertComprobante = $db->query($SqlInsertComprobante);
            break;
        }
        header('Location: http://app.nflag.io');
    } catch (Exception $e) {
        echo "Error: " . $e->getCode() . " - " . $e->getMessage();
    }
?>