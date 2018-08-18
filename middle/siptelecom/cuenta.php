                <header class="content__title">
                    <h1>SIP Telecom</h1>
                    <small>Aqui encontraras toda la informacion necesaria para poder utilizar el servicio.</small>
                </header>
                <div class="card row">
                    <div class="card-body">
                        <h4 class="card-title">Credenciales</h4>
                        <h6 class="card-subtitle">Con estos datos pueden registrar su extensión</h6>
                        <div class="row">
                            <?php
                                $NFlagConfig = $GlobalsClass->getNFlagConfig();
                                $ExtensionesClass = new Extensiones();
                                $Extension = $ExtensionesClass->getExtensionByUserID($_SESSION["userID"]);
                                $Extension = $Extension["Data"];
                            ?>
                            <table class="table table-bordered invoice__table">
                                <tbody>
                                    <tr>
                                        <td>EXTENSION</td>
                                        <td><?php echo $Extension["Extension"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>CLAVE</td>
                                        <td><?php echo $Extension["Clave"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>SERVIDOR</td>
                                        <td><?php echo $NFlagConfig["sipTelecomServer"]; ?></td>
                                    </tr>
                                    <?php
                                        $NumeroInbound = $ExtensionesClass->getNumeroFromExtension($Extension["Extension"]);
                                        if($NumeroInbound != ""){
                                    ?>
                                            <tr>
                                                <td>NÚMERO (LLAMADAS ENTRANTES)</td>
                                                <td><?php echo $NumeroInbound; ?></td>
                                            </tr>
                                            <tr>
                                                <td>CLAVE DEL ASOCIADO</td>
                                                <td><?php echo $Extension["claveAsociado"]; ?></td>
                                            </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                        <div class="tab-container" style="width: 100%;">
                                <ul class="nav nav-tabs nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#zoiper" role="tab" aria-expanded="false">Zoiper</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="row">
                                        <div class="tab-pane fade active show" style="width: 100%" id="zoiper" role="tabpanel" aria-expanded="true">
                                            <h3 class="card-title" style="text-align: center; font-size: 20px;">Configuración Automática</h3>
                                            <div class="zoiperQR">
                                                <img src="https://oem.zoiper.com/qr.php?provider_id=7aeecb04b689b7d18aa3a5ab531ecd89&u=<?php echo $Extension["Extension"]; ?>&h=&p=<?php echo $Extension["Clave"]; ?>&o=&t=&x=&a=&tr=" alt="QR code"/>
                                            </div>
                                            <h3 class="card-title" style="text-align: center; font-size: 20px;">Configuración Manual</h3>
                                            <div id="carouselExampleCaption" class="carousel slide" data-ride="carousel">
                                                <ol class="carousel-indicators">
                                                    <li data-target="#carouselExampleCaption" data-slide-to="0" class="active"></li>
                                                    <li data-target="#carouselExampleCaption" data-slide-to="1" class=""></li>
                                                    <li data-target="#carouselExampleCaption" data-slide-to="2" class=""></li>
                                                    <li data-target="#carouselExampleCaption" data-slide-to="3" class=""></li>
                                                    <li data-target="#carouselExampleCaption" data-slide-to="4" class=""></li>
                                                    <li data-target="#carouselExampleCaption" data-slide-to="5" class=""></li>
                                                </ol>

                                                <div class="carousel-inner" role="listbox">
                                                    <div class="carousel-item active" style="text-align: center;">
                                                        <img src="../img/configuracionSIP/configuracion_1_4.jpeg" alt="First slide" style="width: auto; height: 500px;">
                                                        <div class="carousel-caption">
                                                            <h3>Primer Paso</h3>
                                                            <p>Ingresa los datos de tu cuenta: En username ingrese el numero de su extension seguido del caracter "@" y luego el nombre del servidor; en el campo clave ingrese su clave especificada en la parte superior de esta pagina. Una vez hecho esto presione el boton "Create an account.</p>
                                                        </div>
                                                    </div>
                                                    <div class="carousel-item" style="text-align: center;">
                                                        <img src="../img/configuracionSIP/configuracion_2_4.jpeg" alt="Second slide" style="width: auto; height: 500px;">
                                                        <div class="carousel-caption">
                                                            <h3>Segundo Paso</h3>
                                                            <p>Presiona el boton "Next".</p>
                                                        </div>
                                                    </div>
                                                    <div class="carousel-item" style="text-align: center;">
                                                        <img src="../img/configuracionSIP/configuracion_3_4.jpeg" alt="Third slide" style="width: auto; height: 500px;">
                                                        <div class="carousel-caption">
                                                            <h3>Tercer Paso</h3>
                                                            <p>Presiona el botón "Skip".</p>
                                                        </div>
                                                    </div>
                                                    <div class="carousel-item" style="text-align: center;">
                                                        <img src="../img/configuracionSIP/configuracion_4_4.jpeg" alt="Third slide" style="width: auto; height: 500px;">
                                                        <div class="carousel-caption">
                                                            <h3>Cuarto Paso</h3>
                                                            <p>La Opción "SIP UDP" debe marcarse con color verde con el texto "Found", luego de verificar eso presionar el boton "Finish".</p>
                                                        </div>
                                                    </div>
                                                    <div class="carousel-item" style="text-align: center;">
                                                        <img src="../img/configuracionSIP/pantalla_principal.jpeg" alt="Third slide" style="width: auto; height: 500px;">
                                                        <div class="carousel-caption">
                                                            <h3>Quinto Paso</h3>
                                                            <p>Presionar el boton con el icono de Teclado.</p>
                                                        </div>
                                                    </div>
                                                    <div class="carousel-item" style="text-align: center;">
                                                        <img src="../img/configuracionSIP/ejemplo_discado.jpeg" alt="Third slide" style="width: auto; height: 500px;">
                                                        <div class="carousel-caption">
                                                            <h3>Sexto Paso</h3>
                                                            <p>Discar el numero al que desea llamar con el formato mostrado en la imagen y presione el boton de llamar mostrado como un icono de un teléfono.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="carousel-control-prev" href="#carouselExampleCaption" role="button" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleCaption" role="button" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>