#!/usr/bin/php -q
<?php

    require("/var/www/html/class/agi/phpagi.php");

    $agi = new AGI();
    $agi->set_variable(test,"PRUEBA");

?>