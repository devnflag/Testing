#!/usr/bin/php -q
<?php

    include_once("/var/www/html/class/agi/phpagi.php");
    include_once("/var/www/html/includes/AGI/db/DB.php");

    $agi = new AGI();

    $Anexo = trim($argv[1]);
    $Exten = $argv[2];
    
    $NoSaldo = false;
    
    $SqlServicio = "SELECT U.idServicio as idServicio FROM Extensiones E INNER JOIN clientes_usuarios CU on CU.idUsuario = E.idUsuario INNER JOIN usuarios U on U.id = CU.idUsuario WHERE E.Extension='".$Anexo."'";
    $Servicio = $Connection->query($SqlServicio);
    foreach($Servicio as $S){
        $idServicio = $S["idServicio"];
        switch($idServicio){
            case "1":
                $agi->set_variable(TimeOut,"999999");
            break;
            case "2":
                $SqlTiempo = "SELECT DST.segundos as Segundos, C.saldo as Saldo FROM Extensiones Ex INNER JOIN usuarios Us on Us.id = Ex.idUsuario INNER JOIN data_sipTelecom DST on DST.idUsuario = Us.id INNER JOIN clientes_usuarios CU on CU.idUsuario = Us.id INNER JOIN clientes C on C.id = CU.idCliente WHERE Ex.Extension='".$Anexo."'";
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
            break;
        }
    }
    if($NoSaldo){
        $agi->hangup();//ir a no tiene saldo disponible
    }

?>