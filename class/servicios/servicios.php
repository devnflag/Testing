<?php
    class Servicios{

        function getServiciosPorDefecto(){
            $db = new DB();
            $SqlServicios = "select * from servicios where forall='1'";
            $Servivios = $db->select($SqlServicios);
            return $Servivios;
        }
    }
?>