#!/usr/bin/php -q
<?php

    require("/var/www/html/class/agi/phpagi.php");

    $agi = new AGI();
    $Anexo = $argv[1];
    $agi->set_variable(test,"1");

?>