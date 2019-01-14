<?php
    /**
     * Clase para Configurar el cliente
     * @Filename: Config.class.php
     * @version: 2.0
     * @Author: flow.cl
     * @Email: csepulveda@tuxpan.com
     * @Date: 28-04-2017 11:32
     * @Last Modified by: Carlos Sepulveda
     * @Last Modified time: 28-04-2017 11:32
     */
    
    $COMMERCE_CONFIG = array(
        "APIKEY" => "327FEEE2-8842-45EA-A594-3FEL107C4C3C", // Registre aquí su apiKey
        "SECRETKEY" => "26574b539dc354ddebc9ef8b9fd2aaac05b8b7cc", // Registre aquí su secretKey
        "APIURL" => "https://sandbox.flow.cl/api", // Producción EndPoint o Sandbox EndPoint
        "BASEURL" => "https://app.nflag.io" //Registre aquí la URL base en su página donde instalará el cliente
    );
    
    class Config {
        
        static function get($name) {
            global $COMMERCE_CONFIG;
            if(!isset($COMMERCE_CONFIG[$name])) {
                throw new Exception("The configuration element thas not exist", 1);
            }
            return $COMMERCE_CONFIG[$name];
        }
    }
?>