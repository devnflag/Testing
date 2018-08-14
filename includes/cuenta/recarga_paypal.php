<?php
    // The custom hidden field (user id) sent along with the button is retrieved here. 
    print_r($_GET);
    if($_GET['cm']) $user=$_GET['cm']; 
    // The unique transaction id. 
    if($_GET['tx']) $tx= $_GET['tx'];
    $identity = 'Your Identity'; 
    // Init curl
    $ch = curl_init(); 
    // Set request options 
    //curl_setopt_array($ch, array ( CURLOPT_URL => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
    curl_setopt_array($ch, array ( CURLOPT_URL => 'https://www.paypal.com/cgi-bin/webscr',
    CURLOPT_POST => TRUE,
    CURLOPT_POSTFIELDS => http_build_query(array
        (
        'cmd' => '_notify-synch',
        'tx' => $tx,
        'at' => $identity,
        )),
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HEADER => FALSE,
    // CURLOPT_SSL_VERIFYPEER => TRUE,
    // CURLOPT_CAINFO => 'cacert.pem',
    ));
    // Execute request and get response and status code
    echo $response = curl_exec($ch);
    $status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // Close connection
    curl_close($ch);
    if($status == 200 AND strpos($response, 'SUCCESS') === 0)
    {
        // Save the Record into the database
    }
?>