<?php
    session_start();
    include_once("class/PayPal/DPayPal.php");
    $paypal = new DPayPal(); //Create an object

    //Generating request parameters for API operation SetExpressCheckout
    //All available parameters for this method are available here
    //https://developer.paypal.com/docs/classic/api/merchant/SetExpressCheckout_API_Operation_NVP/

    $requestParams = array(
        'RETURNURL' => "http://app.nflag.io/includes/cuenta/recarga_paypal.php", //Enter your webiste URL here
        'CANCELURL' => "http://app.nflag.io/includes/cuenta/recarga_paypal.php"//Enter your website URL here
    );

    $orderParams = array(
        'LOGOIMG' => "", //You can paste here your website logo image which will be displayed to the customer on the PayPal chechout page
        "MAXAMT" => "100", //Set max transaction amount
        "NOSHIPPING" => "1", //I do not want shipping
        "ALLOWNOTE" => "0", //I do not want to allow notes
        "BRANDNAME" => "Here enter your brand name",
        "GIFTRECEIPTENABLE" => "0",
        "GIFTMESSAGEENABLE" => "0",
        "idCliente" => $_SESSION["idCliente"],
        "saldoRecargado" => "2500"
    );
    $item = array(
        'PAYMENTREQUEST_0_AMT' => "0.01",
        'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
        'PAYMENTREQUEST_0_ITEMAMT' => "0.01",
        'L_PAYMENTREQUEST_0_NAME0' => 'Item name',
        'L_PAYMENTREQUEST_0_DESC0' => 'Item description',
        'L_PAYMENTREQUEST_0_AMT0' => "0.01",
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