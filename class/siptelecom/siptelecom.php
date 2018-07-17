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
    }
?>