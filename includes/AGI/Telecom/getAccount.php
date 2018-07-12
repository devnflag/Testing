#!/usr/bin/php -q
<?php

    require("/var/www/html/class/agi/phpagi.php");
    require("/var/www/html/class/db/DB.php");

    $agi = new AGI();
    $db = new DB();

    $Anexo = $argv[1];
    $Exten = $argv[2];
    
    $agi->set_variable(test,"1");
    $agi->set_variable(TimeOut,"10");

    $SqlTiempo = "SELECT
                        DST.minutos as Minutos,
                        (DST.minutos * 60) as Segundos
                    FROM
                    Extensiones Ex
                        INNER JOIN usuarios Us on Us.id = Ex.idUsuario
                        INNER JOIN data_sipTelecom DST on DST.idUsuario = Us.id
                    WHERE
                        Ex.Extension='".$Anexo."'";
    $Tiempo = $db->select($SqlTiempo);

    if(count($Tiempo) > 0){
        $Minutos = $Tiempo["Minutos"];
        $Segundos = $Tiempo["Segundos"];
        if($Segundos > 0){
            $agi->set_variable(TimeOut,$Segundos);
            $agi->exec_goto($exten,2);
        }else{
            $agi->hangup();//ir a no tiene saldo disponible
        }
    }else{
        $agi->hangup();
    }

?>