<?php
    class Servicios{

        function getServiciosPorDefecto(){
            $db = new DB();
            $SqlServicios = "select * from servicios where forall='1'";
            $Servivios = $db->select($SqlServicios);
            return $Servivios;
        }
        function getServiciosAsociados(){
            $db = new DB();
            $SqlServicios = "SELECT
                                S.*
                            FROM
                                servicios S
                                    INNER JOIN clientes_servicios CS ON CS.idServicio = S.id
                                    INNER JOIN clientes C ON C.id = CS.idCliente
                                    INNER JOIN clientes_usuarios CU ON CU.idCliente = C.id
                                    INNER JOIN usuarios U ON U.id = CU.idUsuario
                            WHERE
                                U.id = '".$_SESSION["userID"]."' ";
            $Servicios = $db->select($SqlServicios);
            return $Servicios;
        }
    }
?>