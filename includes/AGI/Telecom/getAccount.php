#!/usr/bin/php -q
<?php

    include_once("/var/www/html/class/agi/phpagi.php");
    include_once("/var/www/html/includes/AGI/db/DB.php");

    $agi = new AGI();

    $Anexo = trim($argv[1]);
    $Exten = $argv[2];
    
    $NoSaldo = false;
    
    //$SqlTiempo = "SELECT DST.minutos as Minutos, (DST.minutos * 60) as Segundos, DST.saldo as Saldo FROM Extensiones Ex INNER JOIN usuarios Us on Us.id = Ex.idUsuario INNER JOIN data_sipTelecom DST on DST.idUsuario = Us.id WHERE Ex.Extension='".$Anexo."'";
    $SqlTiempo = "SELECT DST.segundos as Segundos, DST.saldo as Saldo FROM Extensiones Ex INNER JOIN usuarios Us on Us.id = Ex.idUsuario INNER JOIN data_sipTelecom DST on DST.idUsuario = Us.id WHERE Ex.Extension='".$Anexo."'";
    $Tiempo = $Connection->query($SqlTiempo);
    if(count($Tiempo) > 0){
        foreach($Tiempo as $T){
            $Saldo = $T["Saldo"];
            $Segundos = $T["Segundos"];
            if($Segundos > 0){
                $agi->set_variable(test,$Segundos);
                if($Segundos > 0){
                    $agi->set_variable(TimeOut,$Segundos);
                    /* $agi->exec_goto($Exten,2); */
                }else{
                    $NoSaldo = true;
                }
            }else{
                $SqlPrecioMinutoUnitario = "SELECT precioUnitarioMinuto as Precio FROM config_sipTelecom";
                $PrecioMinutoUnitario = $Connection->query($SqlPrecioMinutoUnitario);
                foreach($PrecioMinutoUnitario as $PrecioUnitario){
                    $PrecioMinuto = $PrecioUnitario["Precio"];
                    if($Saldo >= $PrecioMinuto){
                        $Minutos = $Saldo / $PrecioMinuto;
                        $Segundos = $Minutos * 60;
                        $agi->set_variable(test,$Segundos);
                        if($Segundos > 0){
                            $agi->set_variable(TimeOut,$Segundos);
                            /* $agi->exec_goto($Exten,2); */
                        }else{
                            $NoSaldo = true;
                        }
                    }else{
                        $NoSaldo = true;
                    }
                }
            }
        }
    }else{
        $NoSaldo = true;
    }
    if($NoSaldo){
        $agi->hangup();//ir a no tiene saldo disponible
    }

?>