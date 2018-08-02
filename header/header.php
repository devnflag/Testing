<?php
    if(!isset($_SESSION)){
        session_start();
    }
    include_once("../class/db/db.php");
    include_once("../class/menu/menu.php");
    include_once("../class/login/login.php");
    include_once("../class/servicios/servicios.php");
    include_once("../class/siptelecom/siptelecom.php");
    include_once("../class/extensiones/extensiones.php");
    include_once("../class/globals/globals.php");
    include_once("../class/centraltelecom/centraltelecom.php");
    include_once("../class/clientes/clientes.php");
    $MenuClass = new Menu();
    $LoginClass = new Login();
    $GlobalsClass = new Globals();
    $userData = $LoginClass->getUserData();
    $ClientesClass = new Clientes();
    $SaldoHeader = $ClientesClass->getSaldo($_SESSION["userID"]);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>NFLAG</title>

        <!-- Vendor styles -->
        <link rel="stylesheet" href="../vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
        <link rel="stylesheet" href="../vendors/bower_components/animate.css/animate.min.css">
        <link rel="stylesheet" href="../vendors/bower_components/jquery.scrollbar/jquery.scrollbar.css">
        <link rel="stylesheet" href="../vendors/bower_components/fullcalendar/dist/fullcalendar.min.css">
        <link rel="stylesheet" href="../vendors/bower_components/sweetalert2/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="../vendors/bower_components/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="../vendors/bower_components/dropzone/dist/dropzone.css">

        <!-- App styles -->
        <link rel="stylesheet" href="../css/app.min.css">
        <link rel="stylesheet" href="../css/nflag.css">
    </head>

    <body data-sa-theme="3">
        <main class="main">
            <div class="page-loader">
                <div class="page-loader__spinner">
                    <svg viewBox="25 25 50 50">
                        <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                    </svg>
                </div>
            </div>

            <header class="header">
                <div class="navigation-trigger hidden-xl-up" data-sa-action="aside-open" data-sa-target=".sidebar">
                    <i class="zmdi zmdi-menu"></i>
                </div>

                <div class="logo hidden-sm-down">
                    <h1><a href="../index.php"><img src="../img/logos/logo.png" alt="NFLAG" style="height: 72px;"> NFLAG</a></h1>
                </div>

                <form class="search"></form>

                <ul class="top-nav">
                    <li>
                        <div class="row" style="width: 155px;">
                            <div class="col-md-8 saldoContainer">
                                <div class="Text">Saldo</div>
                                <div class="Ammount">$ <?php echo $SaldoHeader; ?></div>
                            </div>
                            <a href="../cuenta/recarga.php">
                                <div class="col-md-4 recargaContainer" title="" data-toggle="tooltip" data-original-title="Recarga.">
                                    <i class="zmdi zmdi-card zmdi-hc-fw"></i>
                                </div>
                            </a>
                        </div>
                    </li>
                </ul>

                <div class="clock hidden-md-down">
                    <div class="time">
                        <span class="time__hours"></span>
                        <span class="time__min"></span>
                        <span class="time__sec"></span>
                    </div>
                </div>
            </header>

            <aside class="sidebar">
                <div class="scrollbar-inner">

                    <div class="user">
                        <div class="user__info" data-toggle="dropdown">
                            <!-- <img class="user__img" src="../demo/img/profile-pics/8.jpg" alt=""> -->
                            <div>
                                <div class="user__name"><?php echo $userData["Nombre"]; ?></div>
                                <div class="user__email"><?php echo $userData["Correo"]; ?></div>
                            </div>
                        </div>

                        <div class="dropdown-menu">
                            <!-- <a class="dropdown-item" href="../cuenta/perfil.php">Perfil</a> -->
                            <a class="dropdown-item" href="../cuenta/recarga.php">Recargar</a>
                            <a class="dropdown-item" href="../logout.php">Salir</a>
                        </div>
                    </div>

                    <ul class="navigation">
                        <li class="navigation__active"><a href="../index.php"><i class="zmdi zmdi-home"></i> Home</a></li>

                        <?php
                            echo $MenuClass->getMenu();
                        ?>
                        
                    </ul>
                </div>
            </aside>

            <div class="themes">
                <div class="scrollbar-inner">
                    <a href="" class="themes__item" data-sa-value="1"><img src="../img/bg/1.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="2"><img src="../img/bg/2.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="3"><img src="../img/bg/3.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="4"><img src="../img/bg/4.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="5"><img src="../img/bg/5.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="6"><img src="../img/bg/6.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="7"><img src="../img/bg/7.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="8"><img src="../img/bg/8.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="9"><img src="../img/bg/9.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="10"><img src="../img/bg/10.jpg" alt=""></a>
                </div>
            </div>

            <section class="content">