#!/usr/bin/php -q
<?php

    require("/var/www/html/class/agi/phpagi.php");

    $agi = new AGI();
    $Anexo = $argv[1];
    $Exten = $argv[2];
    $agi->set_variable(test,"1");
    $agi->set_variable(TimeOut,"10");

    if($Anexo == "2001"){
        $agi->exec_goto($exten,2);
    }else{
        $agi->hangup();
    }

?>