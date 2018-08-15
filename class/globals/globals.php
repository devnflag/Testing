<?php
    class Globals{

        function getNFlagConfig(){
            $db = new DB();
            $SqlConfig = "select * from nflagConfig";
            $Config = $db->select($SqlConfig);
            $Config = $Config[0];
            return $Config;
        }
        function getDolarTasa(){
            $db = new DB();
            $SqlDolar = "select dolar from dolar order by fechaActualizacion DESC LIMIT 1";
            $Dolar = $db->select($SqlDolar);
            return $Dolar[0]["dolar"];
        }
    }
?>