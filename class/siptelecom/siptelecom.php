<?php
    class SipTelecom{

        function newData($idUsuario){
            $db = new DB();
            $ToReturn = array();
            $ToReturn["result"] = false;
            $SqlInsert = "insert into data_sipTelecom (idUsuario,segundos) values('".$idUsuario."','0')";
            $Insert = $db->query($SqlInsert);
            if($Insert){
                $ToReturn["result"] = true;
            }
            return $ToReturn;
        }
        /* function getSaldo($idUsuario){
            $db = new DB();
            $SqlSaldo = "select saldo from data_sipTelecom where idUsuario = '".$idUsuario."'";
            $Saldo = $db->select($SqlSaldo);
            return $Saldo[0]["saldo"];
        }
        function updateSaldo($idUsuario,$Precio){
            $db = new DB();
            $Saldo = $this->getSaldo($idUsuario);
            $SaldoFinal = $Saldo - $Precio;
            
            $SqlUpdate = "update data_sipTelecom set saldo='".$SaldoFinal."' where idUsuario='".$idUsuario."'";
            $Update = $db->query($SqlUpdate);
        } */
        function updateSegundos($idUsuario,$Segundos){
            $db = new DB();            
            $SqlUpdate = "update data_sipTelecom set segundos='".$Segundos."' where idUsuario='".$idUsuario."'";
            $Update = $db->query($SqlUpdate);
        }
        function getSegundosRestantes($idUsuario){
            $db = new DB();
            $SqlSegundos = "select segundos from data_sipTelecom where idUsuario = '".$idUsuario."'";
            $Segundos = $db->select($SqlSegundos);
            return $Segundos[0]["segundos"];
        }
        function getPlanActivado($idUsuario,$Inbound = "NULL"){
            if($Inbound == "NULL"){
                $WhereInbound = "";
            }else{
                $WhereInbound = " AND PST.inbound='".$Inbound ."'";
            }
            $db = new DB();
            $SqlPlan = "SELECT
                            PST.*,
                            UPST.fechaActivacion,
                            UPST.fechaCulminacion
                        FROM
                            planes_sipTelecom PST
                                INNER JOIN usuarios_planes_sipTelecom UPST ON UPST.idPlan = PST.id
                        WHERE
                            UPST.idUsuario='".$idUsuario."'
                            ".$WhereInbound."
                            ";
            $Plan = $db->select($SqlPlan);
            return $Plan;
        }
        function getExtension($idUsuario){
            $db = new DB();
            $SqlExtension = "select Extension from Extensiones where idUsuario = '".$idUsuario."'";
            $Extension = $db->select($SqlExtension);
            return $Extension[0]["Extension"];
        }
        function getCallsInPeriodTime($idUsuario,$startDate,$endDate){
            $db = new DB();
            $Extension = $this->getExtension($idUsuario);
            $startDate = date("Ymd",strtotime($startDate));
            $endDate = date("Ymd",strtotime($endDate));
            $SqlLlamadas = "SELECT
                                COUNT(*) AS cantidadLlamadas
                            FROM
                                (SELECT DISTINCT uniqueid FROM cdr CDR WHERE CDR.src='".$Extension."' AND calldate BETWEEN '".$startDate."' AND '".$endDate."' GROUP BY uniqueid) UNIQUES";
            $Llamadas = $db->select($SqlLlamadas);
            return $Llamadas[0]["cantidadLlamadas"];
        }
        function getCallsByMonthAndYear($Month,$Year){
            $db = new DB();
            $Extension = $this->getExtension($_SESSION["userID"]);
            //$SqlCalls = "SELECT DISTINCT calldate as FechaHora, dst as NumeroDestino, billsec as Duraccion, disposition as Accion from cdr where SRC = '".$Extension."' AND MONTH(calldate)='".$Month."' AND YEAR(calldate)='".$Year."' ORDER BY calldate DESC";
            $SqlCalls = "SELECT calldate as FechaHora, dst as NumeroDestino, SEC_TO_TIME(billsec) as Duraccion, disposition as Accion FROM cdr WHERE src = '".$Extension."' AND MONTH(calldate)='".$Month."' AND YEAR(calldate)='".$Year."' GROUP BY uniqueid ORDER BY billsec DESC";
            $Calls = $db->select($SqlCalls);
            return $Calls;
        }
        function getPlanes(){
            $db = new DB();
            $SqlPlanes = "select * from planes_sipTelecom";
            $Planes = $db->select($SqlPlanes);
            return $Planes;
        }
        function getCaracteristicasPlanes($idPlan){
            $db = new DB();
            $SqlCaracteristicas = "select * from planes_caracteristicas_sipTelecom where idPlan = '".$idPlan."'";
            $Caracteristicas = $db->select($SqlCaracteristicas);
            return $Caracteristicas;
        }
        function HavePlan($idUsuario,$idPlan){
            $db = new DB();
            $ToReturn = array();
            $ToReturn["result"] = false;
            $Plan = $this->getPlan($idPlan);
            if(count($Plan) > 0){
                $Plan = $Plan[0];
                $SqlValidacion = "select * from usuarios_planes_sipTelecom UPST INNER JOIN planes_sipTelecom PST on PST.id = UPST.idPlan where UPST.idUsuario='".$idUsuario."' and PST.inbound='".$Plan["inbound"]."'";
                $Validacion = $db->select($SqlValidacion);
                if(count($Validacion) > 0){
                    $ToReturn["result"] = true;
                    $ToReturn["inbound"] = $Plan["inbound"];
                }
            }
            return $ToReturn;
        }
        function getPlan($idPlan){
            $db = new DB();
            $SqlPlan = "SELECT
                            PST.*
                        FROM
                            planes_sipTelecom PST
                        WHERE
                            PST.id='".$idPlan."'";
            $Plan = $db->select($SqlPlan);
            return $Plan;
        }
        function contratarPlan($idUsuario,$idPlan){
            $db = new DB();
            $ToReturn = array();
            $ToReturn["result"] = false;

            $ClientesClass = new Clientes();
            $ExtensionesClass = new Extensiones();

            $Plan = $this->getPlan($idPlan);
            if(count($Plan) > 0){
                $Plan = $Plan[0];
                $Precio = $Plan["precio"];
                $Inbound = $Plan["inbound"];
                $Next = false;
                if($Inbound == "1"){
                    $Next = $ExtensionesClass->ExistenNumerosInbound();
                }else{
                    $Next = true;
                }
                if($Next){
                    $SaldoActual = $ClientesClass->getSaldo($idUsuario);
                    if($Precio <= $SaldoActual){
                    
                        $modoVencimiento = $Plan["modoVencimiento"];
                        $fechaActual = date("Ymd");
                        $fechaVencimiento = "";
                        switch($modoVencimiento){
                            case "1":
                                $fechaVencimiento = date("Ymd",strtotime("+7 day",strtotime($fechaActual)));
                                $TiempoVencimiento = "7 días";
                            break;
                            case "2":
                                $fechaVencimiento = date("Ymd",strtotime("+15 day",strtotime($fechaActual)));
                                $TiempoVencimiento = "15 días";
                            break;
                            case "3":
                                $fechaVencimiento = date("Ymd",strtotime("+1 month",strtotime($fechaActual)));
                                $TiempoVencimiento = "1 Mes";
                            break;
                        }
                        if($fechaVencimiento != ""){
                            $SqlInsert = "insert into usuarios_planes_sipTelecom (idUsuario,idPlan,fechaActivacion,fechaCulminacion) values ('".$idUsuario."','".$idPlan."','".$fechaActual."','".$fechaVencimiento."')";
                            $Insert = $db->query($SqlInsert);
                            if($Insert){
                                $ClientesClass->updateSaldo($idUsuario,$Precio);
                                if($Plan["inbound"] == "0"){
                                    $this->updateSegundos($idUsuario,($Plan["cantidadMinutos"] * 60));
                                    $ToReturn["Minutos"] = $Plan["cantidadMinutos"];
                                }else{
                                    $ToReturn["Inbound"] = true;
                                    $Extension = $ExtensionesClass->getExtensionByUserID($idUsuario);
                                    if($Extension["result"]){
                                        $Extension = $Extension["Data"]["Extension"];
                                        $Numero = $ExtensionesClass->getNumeroDisponible($Extension);
                                        if($Numero["result"]){
                                            $ClaveAsociado = $Extension.$ExtensionesClass->generarClaveAsociado(4);
                                            $ExtensionesClass->updateClaveAsociado($Extension,$ClaveAsociado);
                                            $ExtensionesClass->unlinkIVRFile($Numero["Numero"]);
                                            $ExtensionesClass->addIVRFile($Numero["Numero"]);
                                            $ToReturn["Numero"] = $Numero["Numero"];
                                            $ToReturn["ClaveAsociado"] = $ClaveAsociado;
                                            $AGIClass = new AGI_AsteriskManager();
                                            $AGIClass->connect("localhost","nflag","nflag.,2112");
                                            $ChannelsReponse = $AGIClass->command("reload");
                                        }
                                    }
                                }
                                $ToReturn["result"] = true;
                                $ToReturn["Plan"] = $Plan["nombre"];
                                $ToReturn["TiempoVencimiento"] = $TiempoVencimiento;
                            }
                        }else{

                        }
                    }else{
                        $ToReturn["Message"] = 'Su saldo no es suficiente para contratar el plan "'.$Plan["nombre"].'". Su saldo es: $ '.number_format($SaldoActual,0,',','.');
                    }
                }else{
                    $ToReturn["Message"] = 'No hay disponibilidad de números para contratar el plan de llamadas entrantes, comuniquese con Soporte para gestionar su solicitud.';
                }
            }else{
                $ToReturn["Message"] = "Hubo un error al contratar el plan: ". $idPlan." Comunique este mensaje a soporte técnico";
            }
            return $ToReturn;
        }
        function eliminarBolsasVencimiento($Date){
            $db = new DB();
            $SqlUpdateSegundos = "update data_sipTelecom set segundos = 0 where idUsuario in (select idUsuario from usuarios_planes_sipTelecom UPST inner join planes_sipTelecom PST on PST.id = UPST.idPlan where PST.inbound='0' and ADDDATE(UPST.fechaCulminacion, INTERVAL 1 DAY) <= '".$Date."')";
            $UpdateSegundos = $db->query($SqlUpdateSegundos);

            $SqlNumeros = "select NI.numero as Numero, E.Extension as Extension from usuarios_planes_sipTelecom UPST inner join planes_sipTelecom PST on PST.id = UPST.idPlan INNER JOIN Extensiones E on E.idUsuario = UPST.idUsuario INNER JOIN extensiones_numerosInbound ENI on ENI.Extension = E.Extension INNER JOIN numerosInbound NI on NI.id = ENI.idNumero where PST.inbound='1' and ADDDATE(UPST.fechaCulminacion, INTERVAL 1 DAY) <= '".$Date."'";
            $Numeros = $db->select($SqlNumeros);

            $SqlDeletePlan = "DELETE from usuarios_planes_sipTelecom where ADDDATE(fechaCulminacion, INTERVAL 1 DAY) <= '".$Date."'";
            $DeletePlan = $db->query($SqlDeletePlan);

            print_r($Numeros);
            foreach($Numeros as $Numero){
                $NumeroInbound = $Numero["Numero"];
                $Extension = $Numero["Extension"];
                $ExtensionesClass = new Extensiones();
                $ExtensionesClass->updateClaveAsociado($Extension,"");
                $ExtensionesClass->unlinkIVRFile($NumeroInbound,true);
                $ExtensionesClass->addIVRFile($NumeroInbound,true);
                $ExtensionesClass->actualizarEliminarExtensionNumero($Extension,$NumeroInbound);
            }
            $AGIClass = new AGI_AsteriskManager();
            $AGIClass->connect("localhost","nflag","nflag.,2112");
            $ChannelsReponse = $AGIClass->command("reload");
        }
        function getPrecioPorMinutoUnitario(){
            $db = new DB();
            $ToReturn = "0";
            $SqlPrecio = "SELECT precioUnitarioMinuto as Precio FROM config_sipTelecom";
            $Precio = $db->select($SqlPrecio);
            if(count($Precio) > 0){
                $ToReturn = $Precio[0]["Precio"];
            }
            return $ToReturn;
        }
        function conversorSegundosHoras($tiempo_en_segundos) {
            $horas = floor($tiempo_en_segundos / 3600);
            $horas = $horas >= 10 ? $horas : "0".$horas;
            $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
            $minutos = $minutos >= 10 ? $minutos : "0".$minutos;
            $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);
            $segundos = $segundos >= 10 ? $segundos : "0".$segundos;
        
            return $horas . ':' . $minutos . ":" . $segundos;
        }
    }
?>