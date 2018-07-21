<?php
    class Globals{

        function getNFlagConfig(){
            $db = new DB();
            $SqlConfig = "select * from nflagConfig";
            $Config = $db->select($SqlConfig);
            $Config = $Config[0];
            return $Config;
        }
    }
?>