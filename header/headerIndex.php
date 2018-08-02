<?php
    if(!isset($_SESSION)){
        session_start();
    }
    include_once("class/db/db.php");
    include_once("class/menu/menu.php");
    include_once("class/login/login.php");
    include_once("class/servicios/servicios.php");
    include_once("class/siptelecom/siptelecom.php");
    include_once("class/extensiones/extensiones.php");
    include_once("class/globals/globals.php");
    include_once("class/centraltelecom/centraltelecom.php");
    include_once("class/clientes/clientes.php");
    $MenuClass = new Menu();
    $LoginClass = new Login();
    $GlobalsClass = new Globals();
    $userData = $LoginClass->getUserData();
    $ClientesClass = new Clientes();
    $SaldoHeader = number_format($ClientesClass->getSaldo($_SESSION["userID"]),2,',','.');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>NFLAG</title>

        <!-- Vendor styles -->
        <link rel="stylesheet" href="vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
        <link rel="stylesheet" href="vendors/bower_components/animate.css/animate.min.css">
        <link rel="stylesheet" href="vendors/bower_components/jquery.scrollbar/jquery.scrollbar.css">
        <link rel="stylesheet" href="vendors/bower_components/fullcalendar/dist/fullcalendar.min.css">
        <link rel="stylesheet" href="vendors/bower_components/sweetalert2/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="vendors/bower_components/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="vendors/bower_components/dropzone/dist/dropzone.css">

        <!-- App styles -->
        <link rel="stylesheet" href="css/app.min.css">
        <link rel="stylesheet" href="css/nflag.css">
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
                <h1><a href="index.php"><img src="img/logos/logo.png" alt="NFLAG" style="height: 72px;"> NFLAG</a></h1>
                </div>

                <form class="search"></form>

                <ul class="top-nav">
                    <li>
                        <div class="row" style="width: 155px;">
                            <div class="col-md-8 saldoContainer">
                                <div class="Text">Saldo</div>
                                <div class="Ammount">$ <?php echo $SaldoHeader; ?></div>
                            </div>
                            <a href="cuenta/recarga.php">
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
                            <!-- <img class="user__img" src="demo/img/profile-pics/8.jpg" alt=""> -->
                            <div>
                                <div class="user__name"><?php echo $userData["Nombre"]; ?></div>
                                <div class="user__email"><?php echo $userData["Correo"]; ?></div>
                            </div>
                        </div>

                        <div class="dropdown-menu">
                            <!-- <a class="dropdown-item" href="cuenta/perfil.php">Perfil</a> -->
                            <a class="dropdown-item" href="logout.php">Salir</a>
                        </div>
                    </div>

                    <ul class="navigation">
                        <li class="navigation__active"><a href="index.php"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class=""><a href="cuenta/recarga.php"><i class="zmdi zmdi-money zmdi-hc-fw"></i> Recargar Saldo</a></li>
                        <?php
                            echo $MenuClass->getMenu(true);
                        ?>

                        <!-- <li class="navigation__sub @@variantsactive">
                            <a href=""><i class="zmdi zmdi-view-week"></i> Variants</a>

                            <ul>
                                <li class="@@sidebaractive"><a href="hidden-sidebar.html">Hidden Sidebar</a></li>
                                <li class="@@boxedactive"><a href="boxed-layout.html">Boxed Layout</a></li>
                                <li class="@@hiddensidebarboxedactive"><a href="hidden-sidebar-boxed-layout.html">Boxed Layout with Hidden Sidebar</a></li>
                            </ul>
                        </li>

                        <li class="@@typeactive"><a href="typography.html"><i class="zmdi zmdi-format-underlined"></i> Typography</a></li>

                        <li class="@@widgetactive"><a href="widgets.html"><i class="zmdi zmdi-widgets"></i> Widgets</a></li>

                        <li class="navigation__sub @@tableactive">
                            <a href=""><i class="zmdi zmdi-view-list"></i> Tables</a>

                            <ul>
                                <li class="@@normaltableactive"><a href="html-table.html">HTML Table</a></li>
                                <li class="@@datatableactive"><a href="data-table.html">Data Table</a></li>
                            </ul>
                        </li>

                        <li class="navigation__sub @@formactive">
                            <a href=""><i class="zmdi zmdi-collection-text"></i> Forms</a>

                            <ul>
                                <li class="@@formelementactive"><a href="form-elements.html">Basic Form Elements</a></li>
                                <li class="@@formcomponentactive"><a href="form-components.html">Form Components</a></li>
                                <li class="@@formvalidationactive"><a href="form-validation.html">Form Validation</a></li>
                            </ul>
                        </li>

                        <li class="navigation__sub @@uiactive">
                            <a href=""><i class="zmdi zmdi-swap-alt"></i> User Interface</a>

                            <ul>
                                <li class="@@colorsactive"><a href="colors.html">Colors</a></li>
                                <li class="@@cssanimationsactive"><a href="css-animations.html">CSS Animations</a></li>
                                <li class="@@buttonsactive"><a href="buttons.html">Buttons</a></li>
                                <li class="@@iconsactive"><a href="icons.html">Icons</a></li>
                                <li class="@@listviewactive"><a href="listview.html">Listview</a></li>
                                <li class="@@toolbarsactive"><a href="toolbars.html">Toolbars</a></li>
                                <li class="@@cardsactive"><a href="cards.html">Cards</a></li>
                                <li class="@@alertactive"><a href="alerts.html">Alerts</a></li>
                                <li class="@@badgesactive"><a href="badges.html">Badges</a></li>
                                <li class="@@breadcrumbsactive"><a href="breadcrumbs.html">Bredcrumbs</a></li>
                                <li class="@@jumbotronactive"><a href="jumbotron.html">Jumbotron</a></li>
                                <li class="@@navsactive"><a href="navs.html">Navs</a></li>
                                <li class="@@paginationactive"><a href="pagination.html">Pagination</a></li>
                                <li class="@@progressactive"><a href="progress.html">Progress</a></li>
                            </ul>
                        </li>

                        <li class="navigation__sub @@componentsactive">
                            <a href=""><i class="zmdi zmdi-group-work"></i> Javascript Components</a>

                            <ul class="navigation__sub">
                                <li class="@@carouselactive"><a href="carousel.html">Carousel</a></li>
                                <li class="@@collapseactive"><a href="collapse.html">Collapse</a></li>
                                <li class="@@dropdownsactive"><a href="dropdowns.html">Dropdowns</a></li>
                                <li class="@@modalsactive"><a href="modals.html">Modals</a></li>
                                <li class="@@popoveractive"><a href="popover.html">Popover</a></li>
                                <li class="@@tabsactive"><a href="tabs.html">Tabs</a></li>
                                <li class="@@tooltipsactive"><a href="tooltips.html">Tooltips</a></li>
                                <li class="@@notificationsactive"><a href="notifications-alerts.html">Notifications & Alerts</a></li>
                                <li class="@@treeactive"><a href="treeview.html">Tree View</a></li>
                            </ul>
                        </li>

                        <li class="navigation__sub @@chartsactive">
                            <a href=""><i class="zmdi zmdi-trending-up"></i> Charts</a>

                            <ul>
                                <li class="@@flotchartsactive"><a href="flot-charts.html">Flot</a></li>
                                <li class="@@otherchartsactive"><a href="other-charts.html">Other Charts</a></li>
                            </ul>
                        </li>

                        <li class="@@calendaractive"><a href="calendar.html"><i class="zmdi zmdi-calendar"></i> Calendar</a></li>

                        <li class="@@photogalleryactive"><a href="photo-gallery.html"><i class="zmdi zmdi-image"></i> Photo Gallery</a></li>

                        <li class="navigation__sub @@samplepagesactive">
                            <a href=""><i class="zmdi zmdi-collection-item"></i> Sample Pages</a>

                            <ul>
                                <li class="@@profileactive"><a href="profile-about.html">Profile</a></li>
                                <li class="@@messagesactive"><a href="messages.html">Messages</a></li>
                                <li class="@@contactsactive"><a href="contacts.html">Contacts</a></li>
                                <li class="@@newcontactsactive"><a href="new-contact.html">New Contact</a></li>
                                <li class="@@groupsactive"><a href="groups.html">Groups</a></li>
                                <li class="@@pricingtablesactive"><a href="pricing-tables.html">Pricing Tables</a></li>
                                <li class="@@invoiceactive"><a href="invoice.html">Invoice</a></li>
                                <li class="@@todoactive"><a href="todo-lists.html">Todo Lists</a></li>
                                <li class="@@notesactive"><a href="notes.html">Notes</a></li>
                                <li class="@@searchresultsactive"><a href="search-results.html">Search Results</a></li>
                                <li class="@@issuesactive"><a href="issue-tracker.html">Issues Tracker</a></li>
                                <li class="@@faqactive"><a href="faq.html">FAQ</a></li>
                                <li class="@@teamactive"><a href="team.html">Team</a></li>
                                <li class="@@blogactive"><a href="blog.html">Blog</a></li>
                                <li class="@@blogdetailactive"><a href="blog-detail.html">Blog Detail</a></li>
                                <li class="@@qaactive"><a href="questions-answers.html">Questions & Answers</a></li>
                                <li class="@@qadetailactive"><a href="questions-answers-details.html">Questions & Answers Details</a></li>
                                <li class="@@loginactive"><a href="login.html">Login & SignUp</a></li>
                                <li class="@@lockscreenactive"><a href="lockscreen.html">Lockscreen</a></li>
                                <li class="@@lockscreenactive"><a href="404.html">404</a></li>
                                <li class="@@emptyactive"><a href="empty.html">Empty Page</a></li>
                            </ul>
                        </li> -->
                    </ul>
                </div>
            </aside>

            <div class="themes">
                <div class="scrollbar-inner">
                    <a href="" class="themes__item" data-sa-value="1"><img src="img/bg/1.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="2"><img src="img/bg/2.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="3"><img src="img/bg/3.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="4"><img src="img/bg/4.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="5"><img src="img/bg/5.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="6"><img src="img/bg/6.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="7"><img src="img/bg/7.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="8"><img src="img/bg/8.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="9"><img src="img/bg/9.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="10"><img src="img/bg/10.jpg" alt=""></a>
                </div>
            </div>

            <section class="content">