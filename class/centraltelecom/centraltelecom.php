<?php
    class CentralTelecom{

        function getCentralData($idCliente){
            $db = new DB();
            $SqlCentralData = "select * from data_centralTelecom where idCliente='".$idCliente."'";
            $CentralData = $db->select($SqlCentralData);
            return $CentralData[0];
        }
        function newExtension($nombreExtension,$idCliente){
            $db = new DB();
            $LoginClass = new Login();
            $ExtensionesClass = new Extensiones();
            $ClientesClass = new Clientes();
            $AGIClass = new AGI_AsteriskManager();

            $ToReturn = array();
            $ToReturn["result"] = false;

            $newUser = $LoginClass->addUser("","",$nombreExtension,"","1",$idCliente);
            if($newUser["result"]){
                $idUsuario = $newUser["idUsuario"];
                $Extension = $ExtensionesClass->newExtension($idUsuario);
                $CentralData = $this->getCentralData($idCliente);
                $SqlInsert = "INSERT INTO central_usuarios_centralTelecom (idCentral,idUsuario) values ('".$CentralData['id']."','".$idUsuario."')";
                $Insert = $db->query($SqlInsert);
                if($Insert){
                    $ToReturn["result"] = true;
                    $PrecioExtension = $this->getPrecioExtension();
                    $ClientesClass->updateSaldo($_SESSION["userID"],$PrecioExtension);
                }
                $AGIClass->connect("localhost","nflag","nflag.,2112");
                $ChannelsReponse = $AGIClass->command("reload");
            }
            return $ToReturn;
        }
        function getExtensions($idCliente,$Month,$Year){
            $db = new DB();

            $ToReturn = array();

            $SqlExtensiones = "select E.Extension as Extension, U.nombre as nombreExtension, E.Clave as Clave, U.status as Estatus from data_centralTelecom DCT inner join central_usuarios_centralTelecom CUCT on CUCT.idCentral = DCT.id inner join Extensiones E on E.idUsuario = CUCT.idUsuario inner join usuarios U on U.id = CUCT.idUsuario WHERE DCT.idCliente='".$idCliente."' GROUP BY Extension";
            $Extensiones = $db->select($SqlExtensiones);
            foreach($Extensiones as $Extension){
                $ArrayTmp = array();

                $numeroExtension = $Extension["Extension"];
                $nombreExtension = $Extension["nombreExtension"];
                $Clave = $Extension["Clave"];
                $Estatus = $Extension["Estatus"];

                $SqlLlamadasRealizadas = "select COUNT(*) as Cantidad from (SELECT billsec FROM cdr CDR WHERE CDR.src='".$numeroExtension."' AND MONTH(CDR.calldate) = '".$Month."' and YEAR(CDR.calldate) = '".$Year."' GROUP BY uniqueid) tb1";
                $LlamadasRealizadas = $db->select($SqlLlamadasRealizadas);
                if(count($LlamadasRealizadas) > 0){
                    $LlamadasRealizadas = $LlamadasRealizadas[0]["Cantidad"];
                }else{
                    $LlamadasRealizadas = "0";
                }

                $SqlMinutosUtilizados = "select SEC_TO_TIME(SUM(billsec)) as Minutos from (SELECT billsec FROM cdr CDR WHERE CDR.src='".$numeroExtension."' AND MONTH(CDR.calldate) = '".$Month."' and YEAR(CDR.calldate) = '".$Year."' GROUP BY uniqueid) tb1";
                $MinutosUtilizados = $db->select($SqlMinutosUtilizados);
                if(count($MinutosUtilizados) > 0){
                    $MinutosUtilizados = $MinutosUtilizados[0]["Minutos"];
                    if($MinutosUtilizados == ""){
                        $MinutosUtilizados = "00:00:00";
                    }
                }else{
                    $MinutosUtilizados = "00:00:00";
                }

                $ArrayTmp["Extension"] = $numeroExtension;
                $ArrayTmp["nombreExtension"] = $nombreExtension;
                $ArrayTmp["Clave"] = $Clave;
                $ArrayTmp["Estatus"] = $Estatus;
                $ArrayTmp["LlamadasRealizadas"] = $LlamadasRealizadas;
                $ArrayTmp["MinutosUtilizados"] = $MinutosUtilizados;
                array_push($ToReturn,$ArrayTmp);
            }
            return $ToReturn;
        }
        function getPrecioExtension(){
            $db = new DB();
            $SqlPrecio = "select precioExtension from config_centralTelecom";
            $Precio = $db->select($SqlPrecio);
            return $Precio[0]["precioExtension"];
        }
        function updateExtension($nombreExtension,$Extension,$idCliente){
            $db = new DB();
            $ToReturn = array();
            $ToReturn["result"] = false;
            $SqlUpdate = "update usuarios set nombre='".$nombreExtension."' where id in (select idUsuario from Extensiones where Extension='".$Extension."')";
            $Update = $db->query($SqlUpdate);
            if($Update){
                $ToReturn["result"] = true;
            }
            return $ToReturn;
        }
    }
?>