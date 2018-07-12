#!/usr/bin/php -q
<?php
require("/var/www/html/AGI/phpagi.php");
$mysqli = new mysqli("localhost", "root", "3579m9a7r5s3A", "discador");
if (mysqli_connect_errno()) {
    printf("Error de conexión: %s\n", mysqli_connect_error());
    exit();
}


$agi = new AGI();

$cliente = $argv[1];
$cliente = clean(strtolower($cliente));
$bot = $argv[2];
$Fono= $argv[3];
$Rut = $argv[4];
$contador = $argv[5];
$urlGrabacion = $argv[6];
$urlIP = $argv[7];
$idBot = $argv[8];
$exten = $argv[9];

$frase = '';
$posicion_coincidencia = '';
$rama = "";
$patron = "";
$gestion = "";
$stop = 0;
$urlFinal = "http://".$urlIP."/BOT/".$urlGrabacion;
$fechaArray = explode("/", $urlGrabacion);
$fecha = $fechaArray[0];
$horaArray = explode("_", $urlGrabacion);
$hora = $horaArray[1];


$sqlPatrones = $mysqli->query("SELECT patron,rama,gestion  FROM BT_patron");
$cantidad = $sqlPatrones->num_rows;
foreach($sqlPatrones as $sqlPatron){
    $patron = $sqlPatron['patron'];
    $rama = $sqlPatron['rama'];
    $gestion  = $sqlPatron['gestion'];

    $pos = strpos($cliente, $patron);
    if ($pos === false) {

    }else{
        $agi->exec_goto($exten,$rama);  
        $stop=1;    
        $mysqli->query("INSERT INTO BT_conversaciones(fase,estado,cliente,bot,rama,Rut,Fono,fecha,hora,urlGrabacion,gestion,idBot,coincidencia) VALUES ('RECONOCIMIENTO','PATRON','$cliente','$bot','$rama','$Rut','$Fono','$fecha','$hora','$urlFinal','$gestion','$idBot','$patron')");  
    }
}
if($stop==0){        
    $sqlFrases = $mysqli->query("SELECT frase,rama,gestion FROM BT_frases WHERE  frase = '$cliente'");
    $cantidad = $sqlFrases->num_rows;
    if($cantidad>0){
        foreach($sqlFrases as $row){
            $rama = $row["rama"];
            $frase = $row["frase"];
            $gestion = $row["gestion"];

        }
        $agi->exec_goto($exten,$rama);
        $mysqli->query("INSERT INTO BT_conversaciones(fase,estado,cliente,bot,rama,Rut,Fono,fecha,hora,urlGrabacion,gestion,idBot,coincidencia) VALUES ('RECONOCIMIENTO','FRASE','$cliente','$bot','$rama','$Rut','$Fono','$fecha','$hora','$urlFinal','$gestion','$idBot','$frase')");

    }else{
        
        if($contador<1){
            $agi->set_variable(contador,1);
            $agi->exec_goto($exten,7);
            $mysqli->query("INSERT INTO BT_conversaciones(fase,estado,cliente,bot,rama,Rut,Fono,fecha,hora,urlGrabacion,gestion,idBot,coincidencia) VALUES ('RECONOCIMIENTO','APRENDIZAJE','$cliente','$bot','','$Rut','$Fono','$fecha','$hora','$urlFinal','','$idBot','')");


        }else{
            $agi->hangup();
            $mysqli->query("INSERT INTO BT_conversaciones(fase,estado,cliente,bot,rama,Rut,Fono,fecha,hora,urlGrabacion,gestion,idBot,coincidencia) VALUES ('RECONOCIMIENTO','APRENDIZAJE FINAL','$cliente','$bot','','$Rut','$Fono','$fecha','$hora','$urlFinal','','$idBot','')");

        }
        
    }
}


function clean($cadena) {
    $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã<8f>","Ã„","Ã‹");
    $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
    $texto = str_replace($no_permitidas, $permitidas ,$cadena);
    return $texto;
}

?>