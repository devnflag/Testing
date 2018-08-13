#!/usr/bin/php -q
<?php

    include_once("/var/www/html/class/agi/phpagi.php");
    include_once("/var/www/html/includes/AGI/db/DB.php");

    $agi = new AGI();

    $agi->say_number(100);
?>