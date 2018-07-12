<?php
    $Conf = "/var/www/html/class/db/conf.ini");
    $Server = $Conf["serverDB"];
    $Pass = $Conf["passDB"];
    $User = $Conf["userDB"];
    $Database = $Conf["DB"];
    $Connection = new mysqli($Server, $User, $Pass, $Database);
    if (mysqli_connect_errno()) {
        printf("Error de conexión: %s\n", mysqli_connect_error());
        exit();
    }
?>