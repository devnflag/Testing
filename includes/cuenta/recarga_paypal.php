<?php
    session_start();
    include_once("../../class/db/db.php");
    include_once("../../class/PayPal/DPayPal.php");

    $token=$_GET["token"];//Returned by paypal, you can save this in SESSION too
	$paypal = new Paypal();
	$requestParams = array('TOKEN' => $token);
	
	$response = $paypal->GetExpressCheckoutDetails($requestParams);
	$payerId=$response["PAYERID"];//Payer id returned by paypal
	print_r($response);
	//Create request for DoExpressCheckoutPayment
	$requestParams=array(
		"TOKEN"=>$token,
		"PAYERID"=>$payerId,
		"PAYMENTREQUEST_0_AMT"=>"0.01",//Payment amount. This value should be sum of of item values, if there are more items in order
		"PAYMENTREQUEST_0_CURRENCYCODE"=>"USD",//Payment currency
		"PAYMENTREQUEST_0_ITEMAMT"=>"0.01"//Item amount
	);
	$transactionResponse=$paypal->DoExpressCheckoutPayment($requestParams);//Execute transaction
	
	if(is_array($transactionResponse) && $transactionResponse["ACK"]=="Success"){//Payment was successfull
		//Successful Payment
	}
	else{
		//Failure
	}
?>