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
        function getSaldo($idUsuario){
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
        }
        function updateSegundos($idUsuario,$Segundos){
            $db = new DB();            
            $SqlUpdate = "update data_sipTelecom set segundos='".$Segundos."' where idUsuario='".$idUsuario."'";
            $Update = $db->query($SqlUpdate);
        }
        function getSegundosRestantes($idUsuario){
            $db = new DB();
            $SqlSaldo = "select segundos from data_sipTelecom where idUsuario = '".$idUsuario."'";
            $Saldo = $db->select($SqlSaldo);
            return $Saldo[0]["segundos"];
        }
        function getPlanActivado($idUsuario){
            $db = new DB();
            $SqlPlan = "SELECT
                            PST.*,
                            UPST.fechaActivacion,
                            UPST.fechaCulminacion
                        FROM
                            planes_sipTelecom PST
                                INNER JOIN usuarios_planes_sipTelecom UPST ON UPST.idPlan = PST.id
                        WHERE
                            UPST.idUsuario='".$idUsuario."'";
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
            $SqlCalls = "SELECT calldate as FechaHora, dst as NumeroDestino, billsec as Duraccion, disposition as Accion FROM cdr WHERE src = '".$Extension."' AND MONTH(calldate)='".$Month."' AND YEAR(calldate)='".$Year."' GROUP BY uniqueid ORDER BY billsec DESC";
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
        function HavePlan($idUsuario){
            $db = new DB();
            $ToReturn = false;
            $SqlValidacion = "select * from usuarios_planes_sipTelecom where idUsuario='".$idUsuario."'";
            $Validacion = $db->select($SqlValidacion);
            if(count($Validacion) > 0){
                $ToReturn = true;
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

            $Plan = $this->getPlan($idPlan);
            if(count($Plan) > 0){
                $Plan = $Plan[0];
                $Precio = $Plan["precio"];
                $SaldoActual = $this->getSaldo($idUsuario);
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
                            $this->updateSaldo($idUsuario,$Precio);
                            $this->updateSegundos($idUsuario,($Plan["cantidadMinutos"] * 60));
                            $ToReturn["result"] = true;
                            $ToReturn["Plan"] = $Plan["nombre"];
                            $ToReturn["Minutos"] = $Plan["cantidadMinutos"];
                            $ToReturn["TiempoVencimiento"] = $TiempoVencimiento;
                        }
                    }else{

                    }
                }else{
                    $ToReturn["Message"] = 'Su saldo no es suficiente para contratar el plan "'.$Plan["nombre"].'". Su saldo es: $ '.number_format($SaldoActual,0,',','.');
                }
            }else{
                $ToReturn["Message"] = "Hubo un error al contratar el plan: ". $idPlan." Comunique este mensaje a soporte técnico";
            }
            return $ToReturn;
        }
        function eliminarBolsasVencimiento($Date){
            $db = new DB();
            $SqlUpdateSegundos = "update data_sipTelecom set segundos = 0 where idUsuario in (select idUsuario from usuarios_planes_sipTelecom where ADDDATE(fechaCulminacion, INTERVAL 1 DAY) <= '".$Date."')";
            $UpdateSegundos = $db->query($SqlUpdateSegundos);
            if($UpdateSegundos){
                $SqlDeletePlan = "DELETE from usuarios_planes_sipTelecom where ADDDATE(fechaCulminacion, INTERVAL 1 DAY) <= '".$Date."'";
                $DeletePlan = $db->query($SqlDeletePlan);    
            }
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
    }
?>