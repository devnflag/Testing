<?php
    class Clientes{

        function addCliente($FullName,$DNI,$Mail,$Address){
            $db = new DB();
            $ServiciosClass = new Servicios();
            $ToReturn = false;
            $SqlInsert = "insert into clientes (nombreCompleto,DNI,correoElectronico,Direccion,fechaIngreso) values('".$FullName."','".$DNI."','".$Mail."','".$Address."',NOW())";
            $Insert = $db->query($SqlInsert);
            if($Insert){
                $Cliente = $this->getClienteByMail($Mail);
                if($Cliente["result"]){
                    $Cliente = $Cliente["Data"];
                    $idCliente = $Cliente["id"];
                    $Servicios = $ServiciosClass->getServiciosPorDefecto();
                    foreach($Servicios as $Servicio){
                        $idServicio = $Servicio["id"];
                        $SqlInsertClientesServicios = "insert into clientes_servicios (idCliente,idServicio,fechaIngreso) values('".$idCliente."','".$idServicio."',NOW())";
                        $InsertClientesServicios = $db->query($SqlInsertClientesServicios);
                    }
                    $ToReturn = true;
                }
            }
            return $ToReturn;
        }
        function getClienteByMail($Mail){
            $db = new DB();
            $ToReturn = array();
            $ToReturn["result"] = false;
            $SqlCliente = "select * from clientes where correoElectronico='".$Mail."'";
            $Cliente = $db->select($SqlCliente);
            if(count($Cliente) > 0){
                $ToReturn["Data"] = $Cliente[0];
                $ToReturn["result"] = true;
            }
            return $ToReturn;
        }
    }
?>