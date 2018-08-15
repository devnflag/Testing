<?php
    session_start();
    include_once("../class/db/db.php");
    include_once("../class/PayPal/DPayPal.php");
    include_once("../class/globals/globals.php");
    $paypal = new DPayPal(); //Create an object
    $GlobalsClass = new Globals();


    $Pesos = $_GET["saldo"];

    $Tasa = $GlobalsClass->getDolarTasa();
    $ComisionPaypal2 = 1;
    $Dolares = ($Pesos / $Tasa);
    $Total = $Dolares > 0 ? ($Dolares + $ComisionPaypal2) : 0;
    $ComisionPaypal1 = $Total > 0 ? ($Total * 0.054) + 0.3 : 0;
    $Total = round($Total + $ComisionPaypal1,2);

    //Generating request parameters for API operation SetExpressCheckout
    //All available parameters for this method are available here
    //https://developer.paypal.com/docs/classic/api/merchant/SetExpressCheckout_API_Operation_NVP/

    $requestParams = array(
        'RETURNURL' => "http://app.nflag.io/includes/cuenta/recarga_paypal.php?idCliente=".$_SESSION["idCliente"]."&saldo=".$Pesos, //Enter your webiste URL here
        'CANCELURL' => "http://app.nflag.io/cuenta/recarga.php"//Enter your website URL here
    );

    $orderParams = array(
        'LOGOIMG' => "", //You can paste here your website logo image which will be displayed to the customer on the PayPal chechout page
        "MAXAMT" => "100", //Set max transaction amount
        "NOSHIPPING" => "1", //I do not want shipping
        "ALLOWNOTE" => "0", //I do not want to allow notes
        "BRANDNAME" => "NFLAG",
        "GIFTRECEIPTENABLE" => "0",
        "GIFTMESSAGEENABLE" => "0"
    );
    $item = array(
        'PAYMENTREQUEST_0_AMT' => $Total,
        'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
        'PAYMENTREQUEST_0_ITEMAMT' => $Total,
        'L_PAYMENTREQUEST_0_NAME0' => 'Recarga de Saldo',
        'L_PAYMENTREQUEST_0_DESC0' => 'Recarga de Saldo ($ '.$Pesos.')',
        'L_PAYMENTREQUEST_0_AMT0' => $Total,
        'L_PAYMENTREQUEST_0_QTY0' => '1',
            //"PAYMENTREQUEST_0_INVNUM" => $transaction->id - This field is useful if you want to send your internal transaction ID
    );

    //Send request and wait for response
    //Now we will call SetExpressCheckout API operation. 

    $response = $paypal->SetExpressCheckout($requestParams + $orderParams + $item);

    //Response is aslo accessible by calling  $paypal->getLastServerResponse()

    //Now you will be redirected to the PayPal to enter your customer data
    //After that, you will be returned to the RETURN URL
    if (is_array($response) && $response['ACK'] == 'Success') { //Request successful
        //Now we have to redirect user to the PayPal
        $token = $response['TOKEN'];

        header('Location: https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . urlencode($token));
    } else if (is_array($response) && $response['ACK'] == 'Failure') {
        var_dump($response);
        exit;
    }
?>