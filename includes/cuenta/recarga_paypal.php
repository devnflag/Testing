<?php
    session_start();
    include_once("../../class/db/db.php");
    include_once("../../class/PayPal/DPayPal.php");

    $token=$_GET["token"];//Returned by paypal, you can save this in SESSION too
	$paypal = new DPayPal();
	$requestParams = array('TOKEN' => $token);
	
	$response = $paypal->GetExpressCheckoutDetails($requestParams);
	$payerId=$response["PAYERID"];//Payer id returned by paypal
    echo "<pre>";
    print_r($response);
    echo "</pre>";
	//Create request for DoExpressCheckoutPayment
	$requestParams=array(
		"TOKEN"=>$token,
		"PAYERID"=>$payerId,
		"PAYMENTREQUEST_0_AMT"=>$response["AMT"],//Payment amount. This value should be sum of of item values, if there are more items in order
		"PAYMENTREQUEST_0_CURRENCYCODE"=>$response["CURRENCYCODE"],//Payment currency
		"PAYMENTREQUEST_0_ITEMAMT"=>$response["ITEMAMT"]//Item amount
	);
	$transactionResponse=$paypal->DoExpressCheckoutPayment($requestParams);//Execute transaction
	
	if(is_array($transactionResponse) && $transactionResponse["ACK"]=="Success"){//Payment was successfull
        //Successful Payment
        echo "PAGO REALIZADO CORRECTAMENTE";
	}
	else{
		//Failure
	}
?>