<?php
    if(!isset($_SESSION)){
        session_start();
    }
    include_once("../class/db/db.php");
    include_once("../class/menu/menu.php");
    include_once("../class/login/login.php");
    include_once("../class/servicios/servicios.php");
    include_once("../class/siptelecom/siptelecom.php");
    $MenuClass = new Menu();
    $LoginClass = new Login();
    $userData = $LoginClass->getUserData();
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
                    <h1><a href="../index.php">NFLAG</a></h1>
                </div>

                <form class="search">
                    <div class="search__inner">
                        <input type="text" class="search__text" placeholder="Search for people, files, documents...">
                        <i class="zmdi zmdi-search search__helper" data-sa-action="search-close"></i>
                    </div>
                </form>

               <ul class="top-nav">

                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class=""><i class="zmdi zmdi-card zmdi-hc-fw"></i></a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu--block">
                            <div class="dropdown-header">
                                Saldo
                            </div>

                            <div class="listview listview--hover">
                                <a href="" class="listview__item">
                                    <div class="listview__content">
                                        <div class="listview__heading">
                                            SipTelecom <small>$ 5.000</small>
                                        </div>
                                        <p><button class="btn btn-primary" style="width: 100%;">Recargar</button></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>

                    <!--<li class="dropdown top-nav__notifications">
                        <a href="" data-toggle="dropdown" class="top-nav__notify">
                            <i class="zmdi zmdi-notifications"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu--block">
                            <div class="dropdown-header">
                                Notifications

                                <div class="actions">
                                    <a href="" class="actions__item zmdi zmdi-check-all" data-sa-action="notifications-clear"></a>
                                </div>
                            </div>

                            <div class="listview listview--hover">
                                <div class="listview__scroll scrollbar-inner">
                                    <a href="" class="listview__item">
                                        <img src="demo/img/profile-pics/1.jpg" class="listview__img" alt="">

                                        <div class="listview__content">
                                            <div class="listview__heading">David Belle</div>
                                            <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                        </div>
                                    </a>

                                    <a href="" class="listview__item">
                                        <img src="demo/img/profile-pics/2.jpg" class="listview__img" alt="">

                                        <div class="listview__content">
                                            <div class="listview__heading">Jonathan Morris</div>
                                            <p>Nunc quis diam diamurabitur at dolor elementum, dictum turpis vel</p>
                                        </div>
                                    </a>

                                    <a href="" class="listview__item">
                                        <img src="demo/img/profile-pics/3.jpg" class="listview__img" alt="">

                                        <div class="listview__content">
                                            <div class="listview__heading">Fredric Mitchell Jr.</div>
                                            <p>Phasellus a ante et est ornare accumsan at vel magnauis blandit turpis at augue ultricies</p>
                                        </div>
                                    </a>

                                    <a href="" class="listview__item">
                                        <img src="demo/img/profile-pics/4.jpg" class="listview__img" alt="">

                                        <div class="listview__content">
                                            <div class="listview__heading">Glenn Jecobs</div>
                                            <p>Ut vitae lacus sem ellentesque maximus, nunc sit amet varius dignissim, dui est consectetur neque</p>
                                        </div>
                                    </a>

                                    <a href="" class="listview__item">
                                        <img src="demo/img/profile-pics/5.jpg" class="listview__img" alt="">

                                        <div class="listview__content">
                                            <div class="listview__heading">Bill Phillips</div>
                                            <p>Proin laoreet commodo eros id faucibus. Donec ligula quam, imperdiet vel ante placerat</p>
                                        </div>
                                    </a>

                                    <a href="" class="listview__item">
                                        <img src="demo/img/profile-pics/1.jpg" class="listview__img" alt="">

                                        <div class="listview__content">
                                            <div class="listview__heading">David Belle</div>
                                            <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                        </div>
                                    </a>

                                    <a href="" class="listview__item">
                                        <img src="demo/img/profile-pics/2.jpg" class="listview__img" alt="">

                                        <div class="listview__content">
                                            <div class="listview__heading">Jonathan Morris</div>
                                            <p>Nunc quis diam diamurabitur at dolor elementum, dictum turpis vel</p>
                                        </div>
                                    </a>

                                    <a href="" class="listview__item">
                                        <img src="demo/img/profile-pics/3.jpg" class="listview__img" alt="">

                                        <div class="listview__content">
                                            <div class="listview__heading">Fredric Mitchell Jr.</div>
                                            <p>Phasellus a ante et est ornare accumsan at vel magnauis blandit turpis at augue ultricies</p>
                                        </div>
                                    </a>
                                </div>

                                <div class="p-1"></div>
                            </div>
                        </div>
                    </li>

                    <li class="dropdown hidden-xs-down">
                        <a href="" data-toggle="dropdown"><i class="zmdi zmdi-check-circle"></i></a>

                        <div class="dropdown-menu dropdown-menu-right dropdown-menu--block" role="menu">
                            <div class="dropdown-header">Tasks</div>

                            <div class="listview listview--hover">
                                <a href="" class="listview__item">
                                    <div class="listview__content">
                                        <div class="listview__heading">HTML5 Validation Report</div>

                                        <div class="progress mt-1">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="listview__item">
                                    <div class="listview__content">
                                        <div class="listview__heading">Google Chrome Extension</div>

                                        <div class="progress mt-1">
                                            <div class="progress-bar bg-warning" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="listview__item">
                                    <div class="listview__content">
                                        <div class="listview__heading">Social Intranet Projects</div>

                                        <div class="progress mt-1">
                                            <div class="progress-bar bg-success" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="listview__item">
                                    <div class="listview__content">
                                        <div class="listview__heading">Bootstrap Admin Template</div>

                                        <div class="progress mt-1">
                                            <div class="progress-bar bg-info" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="listview__item">
                                    <div class="listview__content">
                                        <div class="listview__heading">Youtube Client App</div>

                                        <div class="progress mt-1">
                                            <div class="progress-bar bg-danger" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="view-more">View all Tasks</a>
                            </div>
                        </div>
                    </li>

                    <li class="dropdown hidden-xs-down">
                        <a href="" data-toggle="dropdown"><i class="zmdi zmdi-apps"></i></a>

                        <div class="dropdown-menu dropdown-menu-right dropdown-menu--block" role="menu">
                            <div class="row app-shortcuts">
                                <a class="col-4 app-shortcuts__item" href="">
                                    <i class="zmdi zmdi-calendar"></i>
                                    <small class="">Calendar</small>
                                </a>
                                <a class="col-4 app-shortcuts__item" href="">
                                    <i class="zmdi zmdi-file-text"></i>
                                    <small class="">Files</small>
                                </a>
                                <a class="col-4 app-shortcuts__item" href="">
                                    <i class="zmdi zmdi-email"></i>
                                    <small class="">Email</small>
                                </a>
                                <a class="col-4 app-shortcuts__item" href="">
                                    <i class="zmdi zmdi-trending-up"></i>
                                    <small class="">Reports</small>
                                </a>
                                <a class="col-4 app-shortcuts__item" href="">
                                    <i class="zmdi zmdi-view-headline"></i>
                                    <small class="">News</small>
                                </a>
                                <a class="col-4 app-shortcuts__item" href="">
                                    <i class="zmdi zmdi-image"></i>
                                    <small class="">Gallery</small>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li class="dropdown hidden-xs-down">
                        <a href="" data-toggle="dropdown"><i class="zmdi zmdi-more-vert"></i></a>

                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="" class="dropdown-item" data-sa-action="fullscreen">Fullscreen</a>
                            <a href="" class="dropdown-item">Clear Local Storage</a>
                            <a href="" class="dropdown-item">Settings</a>
                        </div>
                    </li> -->

                    <li class="hidden-xs-down">
                        <a href="" class="top-nav__themes" data-sa-action="aside-open" data-sa-target=".themes"><i class="zmdi zmdi-palette"></i></a>
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
                            <img class="user__img" src="../demo/img/profile-pics/8.jpg" alt="">
                            <div>
                                <div class="user__name"><?php echo $userData["Nombre"]; ?></div>
                                <div class="user__email"><?php echo $userData["Correo"]; ?></div>
                            </div>
                        </div>

                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="">View Profile</a>
                            <a class="dropdown-item" href="">Settings</a>
                            <a class="dropdown-item" href="../logout.php">Logout</a>
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