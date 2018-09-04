<?php
    class Extensiones{
        
        function newExtension($idUsuario){
            $db = new DB();
            $ToReturn = array();
            $ToReturn["result"] = false;
            $Password = substr(md5(microtime()), 1, 8);
            $SqlInsert = "insert into Extensiones (Extension,idUsuario,Clave) select max(Extension) + 1,'".$idUsuario."','".$Password."' from Extensiones";
            $Insert = $db->query($SqlInsert);
            if($Insert){
                $ToReturn = $this->getExtensionByUserID($idUsuario);
                $this->addExtensionFile($ToReturn["Data"]["Extension"],$Password,"NFLAG-Netelip");
            }
            return $ToReturn;
        }
        function getExtensionByUserID($idUsuario){
            $db = new DB();
            $ToReturn = array();
            $ToReturn["result"] = false;
            $SqlExtension = "select * from Extensiones where idUsuario='".$idUsuario."'";
            $Extension = $db->select($SqlExtension);
            if(count($Extension) > 0){
                $ToReturn["result"] = true;
                $ToReturn["Data"] = $Extension[0];
            }
            return $ToReturn;
        }
        function getExtensionByExtensionAndCliente($Extension,$idCliente){
            $db = new DB();
            $ToReturn = array();
            $ToReturn["result"] = false;
            $SqlExtension = "select E.* from Extensiones E  INNER JOIN clientes_usuarios CU on CU.idUsuario = E.idUsuario INNER JOIN clientes C on C.id = CU.idCliente INNER JOIN usuarios U on U.id = CU.idUsuario where E.Extension='".$Extension."' and C.id='".$idCliente."'";
            $Extension = $db->select($SqlExtension);
            if(count($Extension) > 0){
                $ToReturn["result"] = true;
                $ToReturn["Data"] = $Extension[0];
            }
            return $ToReturn;
        }
        function addExtensionFile($Extension,$Password,$Contexto){
            $nombre_archivo = "../../pbxConf/Sip/".$Extension.".conf";

            if(file_exists($nombre_archivo)){
                //echo $mensaje = "El Archivo $nombre_archivo se ha modificado";
            }else{
                //echo $mensaje = "El Archivo $nombre_archivo se ha creado";
            }

            $Contenido = "[".$Extension."]\n";
            $Contenido .= "type=friend\n";
            $Contenido .= "secret=".$Password."\n";
            $Contenido .= "host=dynamic\n";
            $Contenido .= "port=5060\n";
            $Contenido .= "username=".$Extension."\n";
            $Contenido .= "canreinvite=no\n";
            $Contenido .= "disallow=all\n";
            $Contenido .= "allow=ulaw\n";
            $Contenido .= "allow=gsm\n";
            $Contenido .= "insecure=port,invite\n";
            $Contenido .= "nat=yes\n";
            $Contenido .= "context=".$Contexto."\n";
            $Contenido .= "callcounter=yes\n";
            $Contenido .= "limitonpeers=yes\n";
            $Contenido .= "call-limit=1\n";
            $Contenido .= "qualify=yes\n";

            if($archivo = fopen($nombre_archivo, "a")){
                if(fwrite($archivo,$Contenido)){
                    //echo "Se ha ejecutado correctamente";
                }else{
                    //echo "Ha habido un problema al crear el archivo";
                }
                fclose($archivo);
            }
        }
        function unlinkExtensionFile($Extension){
            $nombre_archivo = "../../pbxConf/Sip/".$Extension.".conf";
            unlink($nombre_archivo);
        }
        function getNumeroFromExtension($Extension){
            $db = new DB();
            $ToReturn = "";
            $SqlNumero = "select NI.numero as Numero from numerosInbound NI INNER JOIN extensiones_numerosInbound ENI on ENI.idNumero = NI.id where ENI.Extension='".$Extension."'";
            $Numero = $db->select($SqlNumero);
            if(count($Numero) > 0){
                $ToReturn = $Numero[0]["Numero"];
            }
            return $ToReturn;
        }
        function getNumeroDisponible($Extension){
            $db = new DB();
            $ToReturn = array();
            $ToReturn["resut"] = false;
            $SqlInsert = "INSERT INTO extensiones_numerosInbound (idNumero, Extension) 
                        SELECT id, '".$Extension."'
                        FROM numerosInbound 
                        WHERE cantidadDisponible < CantidadMaxima AND Estatus = '1'
                        LIMIT 1";
            $Insert = $db->query($SqlInsert);
            if($Insert){
                $SqlUpdate = "update numerosInbound set cantidadDisponible = (cantidadDisponible + 1) where id in (select idNumero from extensiones_numerosInbound where Extension='".$Extension."')";
                $Update = $db->query($SqlUpdate);
                $ToReturn["result"] = true;
                $ToReturn["Numero"] = $this->getNumeroFromExtension($Extension);
            }
            return $ToReturn;
        }
        function unlinkIVRFile($Numero,$CronJob = false){
            if($CronJob == false){
                $nombre_archivo = "../../pbxConf/IVR/Inbound/".$Numero.".conf";
            }else{
                $nombre_archivo = "../pbxConf/IVR/Inbound/".$Numero.".conf";
            }
            unlink($nombre_archivo);
        }
        function addIVRFile($Numero,$CronJob = false){
            $db = new DB();
            if($CronJob == false){
                $nombre_archivo = "../../pbxConf/IVR/Inbound/".$Numero.".conf";
            }else{
                $nombre_archivo = "../pbxConf/IVR/Inbound/".$Numero.".conf";
            }

            $Contenido = "[".$Numero."]\n";
            $Contenido .= "exten => s,1,Set(TIMEOUT(digit)=7)\n";
            $Contenido .= "exten => s,2,Set(TIMEOUT(response)=10)\n";
            $Contenido .= "exten => s,3,Set(CHANNEL(language)=es)\n";
            $Contenido .= "exten => s,4,BackGround(/etc/asterisk/sounds/custom/marqueclave)\n";
            $Contenido .= "exten => s,5,WaitExten()\n";


            $SqlExtensiones = "select E.Extension as Extension, E.claveAsociado as claveAsociado from numerosInbound NI INNER JOIN extensiones_numerosInbound ENI on ENI.idNumero = NI.id INNER JOIN Extensiones E on E.Extension = ENI.Extension where NI.numero='".$Numero."'";
            $Extensiones = $db->select($SqlExtensiones);
            foreach($Extensiones as $Extension){
                $Anexo = $Extension["Extension"];
                $claveAsociado = $Extension["claveAsociado"];

                $Contenido .= "exten => ".$claveAsociado.",1,Dial(SIP/".$Anexo.")\n";
            }


            $Contenido .= "exten => i,3,hangup\n";
            $Contenido .= "exten => t,1,goto(".$Numero.",s,1)\n";
            $Contenido .= "exten => h,1,Hangup\n";


            if($archivo = fopen($nombre_archivo, "a")){
                if(fwrite($archivo,$Contenido)){
                    //echo "Se ha ejecutado correctamente";
                }else{
                    //echo "Ha habido un problema al crear el archivo";
                }
                fclose($archivo);
            }
        }
        function generarClaveAsociado($longitud) {
            $key = '';
            $pattern = '1234567890';
            $max = strlen($pattern)-1;
            for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
            return $key;
        }
        function updateClaveAsociado($Extension,$claveAsociado){
            $db = new DB();
            $SqlUpdate = "update Extensiones set claveAsociado='".$claveAsociado."' where Extension='".$Extension."'";
            $Update = $db->query($SqlUpdate);
        }
        function ExistenNumerosInbound(){
            $db = new DB();
            $ToReturn = false;
            $SqlNumerosDisponibles = "select count(*) Cantidad from numerosInbound where cantidadDisponible < cantidadMaxima and Estatus = '1'";
            $NumerosDisponibles = $db->select($SqlNumerosDisponibles);
            if(count($NumerosDisponibles) > 0){
                $Cantidad = $NumerosDisponibles[0]["Cantidad"];
                if($Cantidad > 0){
                    $ToReturn = true;
                }
            }
            return $ToReturn;
        }
        function actualizarEliminarExtensionNumero($Extension,$Numero){
            $db = new DB();
            $SqlUpdateNumero = "update numerosInbound set cantidadDisponible = cantidadDisponible - 1 where numero='".$Numero."'";
            $UpdateNumero = $db->query($SqlUpdateNumero);

            $SqlDelete = "delete from extensiones_numerosInbound where Extension='".$Extension."'";
            $Delete = $db->query($SqlDelete);
        }
    }
?>