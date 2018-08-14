<?php
    class Comprobantes{

        function nuevoComprobante($idCliente,$rutaComprobante,$tipoComprobante){
            $db = new DB();
            $ToReturn = array();
            $ToReturn["result"] = false;
            $SqlInsert = "insert into comprobantes (idCliente,tipoComprobante,fechaRegistro) values('".$idCliente."','".$tipoComprobante."',NOW())";
            $Insert = $db->query($SqlInsert);
            if($Insert){
                $ToReturn["result"] = true;
                $ToReturn["idComprobante"] = $db->getLastID();
            }
            return $ToReturn;
        }
        function deleteComprobante($idComprobante){
            $db = new DB();
            $ToReturn = array();
            $ToReturn["result"] = false;
            $SqlDelete = "delete from comprobantes where id='".$idComprobante."'";
            $Delete = $db->query($SqlDelete);
            if($Delete){
                $ToReturn["result"] = true;
            }
            return $ToReturn;
        }
    }
?>