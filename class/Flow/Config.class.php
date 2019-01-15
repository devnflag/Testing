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
        "APIKEY" => "3B7F58B2-3FF6-42FF-9D4D-9FD5CA1E6L58", // Registre aquí su apiKey
        "SECRETKEY" => "780d6e66a36f6af42f493ce1ee074fb3731a4154", // Registre aquí su secretKey
        "APIURL" => "https://sandbox.flow.cl/api", // Producción EndPoint o Sandbox EndPoint
        "BASEURL" => "http://app.nflag.io/cuenta/Flow" //Registre aquí la URL base en su página donde instalará el cliente
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