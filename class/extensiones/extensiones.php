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
    }
?>