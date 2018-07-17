<?php
    class SipTelecom{

        function newData($idUsuario){
            $db = new DB();
            $ToReturn = array();
            $ToReturn["result"] = false;
            $SqlInsert = "insert into data_sipTelecom (idUsuario,minutos) values('".$idUsuario."','0')";
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
        function getMinutosRestantes($idUsuario){
            $db = new DB();
            $SqlSaldo = "select minutos from data_sipTelecom where idUsuario = '".$idUsuario."'";
            $Saldo = $db->select($SqlSaldo);
            return $Saldo[0]["minutos"];
        }
        function getPlanActivado($idUsuario){
            $db = new DB();
            $SqlPlan = "SELECT
                            PST.*,
                            UPST.fechaActivacion,
                            UPST.fechaCulminacion
                        FROM
                            planes_sipTelecom PST
                                INNER JOIN usuarios_planes_sipTelecom UPST ON UPST.idplan = PST.id
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
            $SqlCalls = "SELECT calldate as FechaHora, dst as NumeroDestino, billsec as Duraccion, disposition as Accion from cdr where SRC = '".$Extension."' AND MONTH(calldate)='".$Month."' AND YEAR(calldate)='".$Year."' ORDER BY calldate DESC";
            $Calls = $db->select($SqlCalls);
            return $Calls;
        }
    }
?>